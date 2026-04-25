<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Cancelled - Son Got Samples</title>
    <style>
        body {
            background: linear-gradient(135deg, #000510, #00030a);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e8ecff;
        }
        .container {
            text-align: center;
            background: rgba(255,255,255,.05);
            backdrop-filter: blur(10px);
            padding: 48px;
            border-radius: 24px;
            border: 1px solid rgba(255,255,255,.1);
        }
        .cross {
            width: 80px;
            height: 80px;
            background: rgba(239,68,68,.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }
        .cross svg {
            width: 40px;
            height: 40px;
            stroke: #f87171;
            stroke-width: 2;
        }
        h1 { font-size: 32px; font-weight: 200; margin-bottom: 16px; }
        p { color: #8f9abf; margin-bottom: 32px; }
        .btn {
            background: rgba(255,255,255,.1);
            padding: 12px 32px;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="cross">
            <svg viewBox="0 0 24 24" fill="none">
                <line x1="18" y1="6" x2="6" y2="18" stroke="currentColor" stroke-width="2"/>
                <line x1="6" y1="6" x2="18" y2="18" stroke="currentColor" stroke-width="2"/>
            </svg>
        </div>
        <h1>Payment Cancelled</h1>
        <p>Your payment was cancelled. No charges were made.<br>You can try again anytime.</p>
        <a href="/#pricing" class="btn">Back to Pricing</a>
    </div>
</body>
</html>