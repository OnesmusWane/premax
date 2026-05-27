<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    private string $consumerKey;
    private string $consumerSecret;
    private string $shortcode;
    private string $passkey;
    private string $env;

    public function __construct()
    {
        $this->consumerKey    = Setting::get('mpesa_consumer_key', '');
        $this->consumerSecret = Setting::get('mpesa_consumer_secret', '');
        $this->shortcode      = Setting::get('mpesa_shortcode') ?: Setting::get('mpesa_paybill', '');
        $this->passkey        = Setting::get('mpesa_passkey', '');
        $this->env            = Setting::get('mpesa_env', 'sandbox'); // 'sandbox' or 'production'
    }

    private function baseUrl(): string
    {
        return $this->env === 'production'
            ? 'https://api.safaricom.co.ke'
            : 'https://sandbox.safaricom.co.ke';
    }

    private function accessToken(): ?string
    {
        $credentials = base64_encode("{$this->consumerKey}:{$this->consumerSecret}");

        $response = Http::withHeaders(['Authorization' => "Basic {$credentials}"])
            ->timeout(15)
            ->get("{$this->baseUrl()}/oauth/v1/generate?grant_type=client_credentials");

        if ($response->failed()) {
            Log::error('M-Pesa OAuth failed', ['body' => $response->body()]);
            return null;
        }

        return $response->json('access_token');
    }

    public function stkPush(string $phone, int $amount, string $accountRef, string $description): array
    {
        $token = $this->accessToken();
        if (!$token) {
            return ['success' => false, 'message' => 'Could not authenticate with M-Pesa.'];
        }

        $timestamp = now()->format('YmdHis');
        $password  = base64_encode("{$this->shortcode}{$this->passkey}{$timestamp}");
        $callbackUrl = Setting::get('mpesa_callback_url')
            ?: rtrim(config('app.url'), '/') . '/mpesa/callback';

        $payload = [
            'BusinessShortCode' => $this->shortcode,
            'Password'          => $password,
            'Timestamp'         => $timestamp,
            'TransactionType'   => 'CustomerPayBillOnline',
            'Amount'            => $amount,
            'PartyA'            => $this->formatPhone($phone),
            'PartyB'            => $this->shortcode,
            'PhoneNumber'       => $this->formatPhone($phone),
            'CallBackURL'       => $callbackUrl,
            'AccountReference'  => $accountRef,
            'TransactionDesc'   => $description,
        ];

        $response = Http::withToken($token)
            ->timeout(20)
            ->post("{$this->baseUrl()}/mpesa/stkpush/v1/processrequest", $payload);

        Log::info('M-Pesa STK Push', ['payload' => $payload, 'response' => $response->json()]);

        if ($response->failed() || $response->json('ResponseCode') !== '0') {
            return [
                'success' => false,
                'message' => $response->json('errorMessage') ?? $response->json('CustomerMessage') ?? 'STK push failed.',
            ];
        }

        return [
            'success'             => true,
            'checkout_request_id' => $response->json('CheckoutRequestID'),
            'merchant_request_id' => $response->json('MerchantRequestID'),
        ];
    }

    public function formatPhone(string $phone): string
    {
        // Normalise to 2547XXXXXXXX format
        $phone = preg_replace('/\D/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '254' . substr($phone, 1);
        } elseif (str_starts_with($phone, '+')) {
            $phone = ltrim($phone, '+');
        }
        return $phone;
    }
}
