@php
  $q = $data->quotation;
@endphp
<!doctype html>
<html lang="th">
  <head>
    <meta charset="utf-8">
    <title>{{ $data->subject }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body style="margin:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;color:#111;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8;padding:24px 12px;">
      <tr>
        <td align="center">
          <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e9ecef">
            <tr>
              <td style="padding:0">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:linear-gradient(135deg,#1765ff,#0d57df);padding:32px 24px">
                  <tr>
                    <td align="center">
                      @if(!empty($data->setting->setting_logoWeb))
                        <img src="{{ asset('storage/setting/'.$data->setting->setting_logoWeb) }}" alt="PTCAD" style="display:block;max-height:48px;height:auto">
                      @else
                        <span style="font-family:Arial,Helvetica,sans-serif;color:#ffffff;font-size:26px;font-weight:800;letter-spacing:-.5px">PTCAD</span>
                      @endif
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <tr>
              <td style="padding:28px 24px 8px">
                <h2 style="margin:0 0 6px;font-size:20px;line-height:1.4;font-weight:700">
                  ใบเสนอราคาเลขที่ {{ $q->quotationNumber }}
                </h2>
                <p style="margin:0;color:#4b5563;line-height:1.6">
                  เรียนคุณ {{ $data->customer_name ?: $q->name }},
                  <br>ขอบคุณที่สนใจสินค้า/บริการจาก <strong>phpstack-1646968-6541058.cloudwaysapps.com</strong> ด้านล่างคือรายละเอียดโดยสรุป
                </p>
              </td>
            </tr>

            <tr>
              <td style="padding:12px 24px 0">
                <table role="presentation" width="100%" style="border-collapse:collapse">
                  <tr>
                    <td style="padding:8px 0;font-size:14px;color:#111;"><strong>สินค้า</strong></td>
                    <td style="padding:8px 0;font-size:14px;color:#111;text-align:right">{{ $q->productName ?? '-' }}</td>
                  </tr>
                  <tr>
                    <td style="padding:8px 0;font-size:14px;color:#111;"><strong>จำนวน</strong></td>
                    <td style="padding:8px 0;font-size:14px;color:#111;text-align:right">{{ $q->productUnit ?? '-' }}</td>
                  </tr>
                  <tr>
                    <td style="padding:8px 0;font-size:14px;color:#111;"><strong>มูลค่าสินค้าโดยประมาณ</strong></td>
                    <td style="padding:8px 0;font-size:14px;color:#111;text-align:right">
                      {{ isset($q->productTotal) ? number_format($q->productTotal,2) . ' THB' : '-' }}
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <tr>
              <td style="padding:22px 24px 6px" align="center">
                @if(!empty($data->pdf_url))
                  <a href="{{ $data->pdf_url }}" target="_blank" style="display:inline-block;background:#111;color:#fff;text-decoration:none;padding:12px 18px;border-radius:999px;font-size:14px;margin:4px 6px">
                    เปิดใบเสนอราคา (PDF)
                  </a>
                @endif
                <a href="{{ $data->site_url }}" target="_blank" style="display:inline-block;background:#ffffff;border:1px solid #111;color:#111;text-decoration:none;padding:12px 18px;border-radius:999px;font-size:14px;margin:4px 6px">
                  เยี่ยมชมเว็บไซต์
                </a>
              </td>
            </tr>

            <tr>
              <td style="padding:8px 24px 22px">
                <p style="margin:0;color:#4b5563;line-height:1.6;font-size:14px">
                  หากต้องการสอบถามเพิ่มเติม สามารถตอบกลับอีเมลฉบับนี้ได้ทันที หรือโทร 097-060-8328
                  @if(!empty($data->setting->setting_email_bcc))
                    หรืออีเมล <a href="mailto:{{ $data->setting->setting_email_bcc }}" style="color:#111">{{ $data->setting->setting_email_bcc }}</a>
                  @endif
                </p>
              </td>
            </tr>

            <tr>
              <td style="border-top:1px solid #e9ecef;padding:18px 24px 24px;color:#6b7280;font-size:12px" align="center">
                {{ $data->setting->setting_nameWeb ?? 'PTCAD' }}
                <br>
                <a href="{{ $data->site_url }}" target="_blank" style="color:#6b7280;text-decoration:none">{{ $data->site_url }}</a>
              </td>
            </tr>
          </table>

          <div style="height:12px"></div>

          <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px">
            <tr><td style="color:#9ca3af;font-size:12px;text-align:center">
              อีเมลนี้ถูกส่งอัตโนมัติจากระบบใบเสนอราคา PTCAD
            </td></tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
