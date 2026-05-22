<?php

namespace App\View\Components;

use App\Models\ContactInformation;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class WhatsappFloat extends Component
{
    public ?ContactInformation $contact;
    public array $contacts;

    public function __construct()
    {
        $this->contact = rescue(fn () => Cache::remember('contact.primary', now()->addMinutes(60), function () {
            return ContactInformation::where('is_primary', true)
                ->where('is_active', true)
                ->first();
        }), null, false);

        $this->contacts = $this->contact?->whatsapp_contacts ?? [];
    }

    public function render(): View|Closure|string
    {
        return view('components.whatsapp-float');
    }
}
