<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $alertSubject }}</title>
</head>
<body style="margin:0;padding:0;background:#0a0a0a;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#0a0a0a;padding:40px 20px;">
  <tr>
    <td align="center">
      <table width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;background:#111111;border:1px solid #2a2a2a;border-radius:12px;overflow:hidden;">

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

            {{-- Type badge --}}
            <p style="margin:0 0 12px;font-size:11px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:#D31E24;">
              {{ $type }}
            </p>

            <h1 style="margin:0 0 28px;font-size:22px;font-weight:700;color:#ffffff;line-height:1.3;">
              {{ $alertSubject }}
            </h1>

            {{-- Detail rows --}}
            @php $tableMarginBottom = $note ? '28px' : '8px'; @endphp
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:{{ $tableMarginBottom }};border:1px solid #2a2a2a;border-radius:8px;overflow:hidden;">
              @foreach($rows as $i => $row)
              @php $rowBg = ($i % 2 === 0) ? '#1a1a1a' : '#161616'; @endphp
              <tr style="background:{{ $rowBg }};">
                <td style="padding:12px 16px;font-size:11px;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;color:rgba(255,255,255,0.35);width:38%;white-space:nowrap;vertical-align:top;">
                  {{ $row['label'] }}
                </td>
                <td style="padding:12px 16px;font-size:13px;color:rgba(255,255,255,0.8);vertical-align:top;">
                  {{ $row['value'] }}
                </td>
              </tr>
              @endforeach
            </table>

            @if($note)
            {{-- Optional note / message block --}}
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:8px;">
              <tr>
                <td style="background:#1a1a1a;border:1px solid #2a2a2a;border-left:3px solid #D31E24;border-radius:0 8px 8px 0;padding:16px 20px;">
                  <p style="margin:0 0 6px;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,0.25);">Message</p>
                  <p style="margin:0;font-size:13px;color:rgba(255,255,255,0.65);line-height:1.7;white-space:pre-wrap;">{{ $note }}</p>
                </td>
              </tr>
            </table>
            @endif

          </td>
        </tr>

        {{-- Footer --}}
        <tr>
          <td style="padding:20px 40px;border-top:1px solid #1e1e1e;">
            <p style="margin:0;font-size:11px;color:rgba(255,255,255,0.2);">
              Premax Automotive Studio &nbsp;·&nbsp; Nairobi, Kenya<br>
              This is an automated admin alert — please do not reply.
            </p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>
</body>
</html>
