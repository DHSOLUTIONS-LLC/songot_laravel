<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Password Reset OTP</title>
  <style>
    body { margin: 0; padding: 0; background: #05070f; font-family: 'Segoe UI', sans-serif; color: #e8ecff; }
    .wrapper { max-width: 480px; margin: 0 auto; padding: 40px 20px; }
    .card {
      background: #0d1124;
      border: 1px solid rgba(96,116,255,.2);
      border-radius: 16px;
      padding: 40px;
      text-align: center;
    }
    .logo { font-size: 20px; font-weight: 300; letter-spacing: .1em; color: #6074ff; margin-bottom: 32px; }
    h1 { font-size: 22px; font-weight: 500; margin-bottom: 8px; }
    p { font-size: 14px; color: #8f9abf; line-height: 1.6; margin-bottom: 32px; }
    .otp-box {
      display: inline-block;
      background: rgba(96,116,255,.1);
      border: 1px solid rgba(96,116,255,.35);
      border-radius: 12px;
      padding: 16px 40px;
      font-size: 36px;
      font-weight: 700;
      letter-spacing: .35em;
      color: #8097ff;
      margin-bottom: 28px;
    }
    .expiry { font-size: 12px; color: #5a6488; margin-bottom: 32px; }
    .footer { font-size: 11px; color: #3a4060; margin-top: 32px; }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="card">
      <div class="logo">SON GOT SAMPLES</div>
      <h1>Reset your password</h1>
      <p>Hey {{ $name }}, use the code below to reset your password. It expires in <strong style="color:#e8ecff">10 minutes</strong>.</p>
      <div class="otp-box">{{ $otp }}</div>
      <p class="expiry">This code is single-use and will expire at {{ now()->addMinutes(10)->format('H:i') }} UTC.</p>
      <p style="font-size:13px;color:#5a6488;">If you didn't request this, you can safely ignore this email.</p>
      <div class="footer">© {{ date('Y') }} Son Got Samples. All rights reserved.</div>
    </div>
  </div>
</body>
</html>