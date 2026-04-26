<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Password Reset Code</title>
</head>
<body style="margin:0;padding:0;background:#f0f2ff;font-family:'Segoe UI',Arial,sans-serif;">

  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f0f2ff;padding:40px 16px;">
    <tr>
      <td align="center">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:480px;">

          {{-- Logo / Header --}}
          <tr>
            <td align="center" style="padding-bottom:24px;">
              <span style="font-size:13px;font-weight:700;letter-spacing:.18em;color:#6074ff;text-transform:uppercase;">SON GOT SAMPLES</span>
            </td>
          </tr>

          {{-- Card --}}
          <tr>
            <td style="background:#ffffff;border-radius:16px;border:1px solid #dde1ff;padding:44px 40px;text-align:center;">

              {{-- Icon --}}
              <div style="display:inline-block;background:#eef0ff;border-radius:50%;width:56px;height:56px;line-height:56px;text-align:center;margin-bottom:24px;font-size:26px;">🔐</div>

              {{-- Title --}}
              <h1 style="margin:0 0 10px;font-size:22px;font-weight:700;color:#0d1124;letter-spacing:-.01em;">Reset your password</h1>

              {{-- Subtitle --}}
              <p style="margin:0 0 28px;font-size:14px;color:#4a5072;line-height:1.65;">
                Hey <strong style="color:#0d1124;">{{ $name }}</strong>, use the code below to reset your password.
                It expires in <strong style="color:#0d1124;">10 minutes</strong>.
              </p>

              {{-- OTP Box --}}
              <div style="display:inline-block;background:#f0f2ff;border:2px solid #6074ff;border-radius:12px;padding:18px 44px;margin-bottom:28px;">
                <span style="font-size:38px;font-weight:800;letter-spacing:.32em;color:#3d52e6;font-family:'Courier New',monospace;">{{ $otp }}</span>
              </div>

              {{-- Expiry note --}}
              <p style="margin:0 0 24px;font-size:12px;color:#7a82a8;">
                This code is single-use and will expire at <strong>{{ now()->addMinutes(10)->format('H:i') }} UTC</strong>.
              </p>

              {{-- Divider --}}
              <div style="height:1px;background:#eaecf8;margin:0 0 24px;"></div>

              {{-- Safety note --}}
              <p style="margin:0;font-size:12px;color:#9399b8;line-height:1.6;">
                If you didn't request a password reset, you can safely ignore this email.<br>Your password will remain unchanged.
              </p>

            </td>
          </tr>

          {{-- Footer --}}
          <tr>
            <td align="center" style="padding-top:28px;">
              <p style="margin:0;font-size:11px;color:#9399b8;">© {{ date('Y') }} Son Got Samples. All rights reserved.</p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>