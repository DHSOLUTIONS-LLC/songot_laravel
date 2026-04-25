<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - Son Got Samples</title>
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
        .checkmark {
            width: 80px;
            height: 80px;
            background: rgba(34,197,94,.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }
        .checkmark svg {
            width: 40px;
            height: 40px;
            stroke: #4ade80;
            stroke-width: 2;
        }
        h1 { font-size: 32px; font-weight: 200; margin-bottom: 16px; }
        p { color: #8f9abf; margin-bottom: 32px; }
        .btn {
            background: linear-gradient(135deg, #6074ff, #4a5ee8);
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
        <div class="checkmark">
            <svg viewBox="0 0 24 24" fill="none">
                <polyline points="20 6 9 17 4 12" stroke="currentColor" stroke-width="2" fill="none"/>
            </svg>
        </div>
        <h1>Payment Successful! 🎉</h1>
        <p>Your account has been upgraded to <strong>{{ ucfirst($tier) }} Access</strong>.<br>You can now download all stems from the library.</p>
        <a href="/" class="btn">Go to Library</a>
    </div>
</body>
</html>