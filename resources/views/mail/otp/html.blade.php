<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Premax sign-in code</title>
</head>
<body style="margin:0;padding:0;background:#0a0a0a;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#0a0a0a;padding:40px 20px;">
  <tr>
    <td align="center">
      <table width="100%" cellpadding="0" cellspacing="0" style="max-width:520px;background:#111111;border:1px solid #2a2a2a;border-radius:12px;overflow:hidden;">

        {{-- Header --}}
        <tr>
          <td style="padding:28px 40px 22px;border-bottom:1px solid #1e1e1e;">
            <table cellpadding="0" cellspacing="0">
              <tr>
                <td>
                  <img src="{{ asset('assets/images/logos/logo.png') }}"
                       alt="Premax Automotive Studio"
                       height="36"
                       style="height:36px;width:auto;display:block;border:0;">
                </td>
                <td width="10"></td>
                <td style="width:7px;height:7px;background:#D31E24;border-radius:1px;vertical-align:middle;"></td>
              </tr>
            </table>
          </td>
        </tr>

        {{-- Body --}}
        <tr>
          <td style="padding:40px 40px 32px;">
            <p style="margin:0 0 8px;font-size:12px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:#D31E24;">Sign-In Code</p>
            <h1 style="margin:0 0 16px;font-size:26px;font-weight:700;color:#ffffff;line-height:1.3;">Hi {{ $name }},</h1>
            <p style="margin:0 0 32px;font-size:15px;color:rgba(255,255,255,0.55);line-height:1.6;">
              Here is your one-time sign-in code for Premax Studio. It expires in <strong style="color:rgba(255,255,255,0.8);">10 minutes</strong>.
            </p>

            {{-- OTP block --}}
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:32px;">
              <tr>
                <td align="center" style="background:#1a1a1a;border:1px solid #2a2a2a;border-radius:10px;padding:28px 20px;">
                  <p style="margin:0 0 6px;font-size:11px;font-weight:600;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,0.3);">Your code</p>
                  <p style="margin:0;font-size:42px;font-weight:800;letter-spacing:14px;color:#ffffff;font-family:'Courier New',monospace;">{{ $code }}</p>
                </td>
              </tr>
            </table>

            <p style="margin:0 0 8px;font-size:13px;color:rgba(255,255,255,0.35);line-height:1.6;">
              If you didn't request this code, you can safely ignore this email. Your account remains secure.
            </p>
          </td>
        </tr>

        {{-- Footer --}}
        <tr>
          <td style="padding:20px 40px;border-top:1px solid #1e1e1e;">
            <p style="margin:0;font-size:11px;color:rgba(255,255,255,0.2);">
              Premax Automotive Studio &nbsp;·&nbsp; Nairobi, Kenya<br>
              This is an automated message — please do not reply.
            </p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>
</body>
</html>
