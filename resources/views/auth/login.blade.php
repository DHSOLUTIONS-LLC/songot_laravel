<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login - Son Got Samples</title>
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@200;300;400;600&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    *{margin:0;padding:0;box-sizing:border-box;}
    body{
      font-family:'Poppins',sans-serif;
      background:linear-gradient(135deg,#000510,#00030a);
      min-height:100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      color:#e8ecff;
      position:relative;
    }
    .auth-container{
      background:rgba(255,255,255,.05);
      backdrop-filter:blur(10px);
      border:1px solid rgba(255,255,255,.1);
      border-radius:24px;
      padding:48px;
      width:100%;
      max-width:440px;
      position:relative;
      animation:fadeIn 0.3s ease;
    }
    @keyframes fadeIn{
      from{opacity:0;transform:scale(0.96);}
      to{opacity:1;transform:scale(1);}
    }
    .close-btn{
      position:absolute;
      top:16px;
      right:16px;
      width:32px;
      height:32px;
      border-radius:50%;
      background:rgba(255,255,255,.05);
      border:1px solid rgba(255,255,255,.1);
      color:var(--mu);
      font-size:18px;
      cursor:pointer;
      display:flex;
      align-items:center;
      justify-content:center;
      transition:all 0.2s;
      text-decoration:none;
    }
    .close-btn:hover{
      background:rgba(255,255,255,.15);
      color:#fff;
      transform:rotate(90deg);
    }
    .auth-title{
      font-family:'Exo 2';
      font-size:32px;
      font-weight:200;
      text-align:center;
      margin-bottom:32px;
      letter-spacing:.06em;
    }
    .auth-title em{color:#6074ff;font-style:normal;}
    .google-btn{
      width:100%;
      padding:12px;
      background:#131314;
      border:1px solid rgba(255,255,255,.18);
      border-radius:9px;
      color:#fff;
      font-size:14px;
      font-weight:500;
      display:flex;
      align-items:center;
      justify-content:center;
      gap:12px;
      cursor:pointer;
      transition:.2s;
      text-decoration:none;
    }
    .google-btn:hover{background:#222;}
    .divider{
      display:flex;
      align-items:center;
      gap:10px;
      margin:20px 0;
    }
    .divider::before,.divider::after{
      content:'';
      flex:1;
      height:1px;
      background:rgba(255,255,255,.1);
    }
    .divider span{font-size:11px;color:#8f9abf;text-transform:uppercase;}
    .input-group{margin-bottom:20px;}
    .input-group input{
      width:100%;
      padding:12px 14px;
      background:rgba(255,255,255,.05);
      border:1px solid rgba(255,255,255,.1);
      border-radius:9px;
      color:#e8ecff;
      font-size:14px;
      outline:none;
      transition:.2s;
    }
    .input-group input:focus{
      border-color:#6074ff;
      background:rgba(255,255,255,.08);
    }
    .remember-group{
      display:flex;
      align-items:center;
      gap:8px;
      margin-bottom:20px;
    }
    .remember-group input{
      width:16px;
      height:16px;
      accent-color:#6074ff;
    }
    .remember-group label{font-size:13px;color:#8f9abf;}
    .auth-btn{
      width:100%;
      padding:12px;
      background:linear-gradient(135deg,#6074ff,#4a5ee8);
      border:none;
      border-radius:9px;
      color:#fff;
      font-size:14px;
      font-weight:600;
      cursor:pointer;
      transition:.2s;
    }
    .auth-btn:hover{opacity:.9;transform:translateY(-1px);}
    .auth-footer{
      text-align:center;
      margin-top:24px;
      font-size:13px;
      color:#8f9abf;
    }
    .auth-footer a{color:#6074ff;text-decoration:none;}
    .error-message{
      background:rgba(220,38,38,.15);
      border:1px solid #ef4444;
      border-radius:9px;
      padding:12px;
      margin-bottom:20px;
      font-size:13px;
      color:#fca5a5;
    }
    .success-message{
      background:rgba(34,197,94,.15);
      border:1px solid #22c55e;
      border-radius:9px;
      padding:12px;
      margin-bottom:20px;
      font-size:13px;
      color:#86efac;
    }
    .admin-section{
      margin-top:20px;
      padding-top:20px;
      border-top:1px solid rgba(255,255,255,.08);
      text-align:center;
    }
    .admin-section p{
      font-size:10px;
      color:#5a6488;
      text-transform:uppercase;
      letter-spacing:.1em;
      margin-bottom:10px;
    }
    .admin-quick-btn{
      width:100%;
      padding:10px;
      background:rgba(96,116,255,.08);
      border:1px solid rgba(96,116,255,.2);
      border-radius:9px;
      color:#8097ff;
      font-size:12px;
      font-weight:500;
      cursor:pointer;
      transition:.2s;
      display:flex;
      align-items:center;
      justify-content:center;
      gap:8px;
    }
    .admin-quick-btn:hover{
      background:rgba(96,116,255,.15);
      border-color:rgba(96,116,255,.4);
    }
  </style>
</head>
<body>
  <div class="auth-container">
    {{-- Close Button --}}
    <a href="{{ url('/') }}" class="close-btn" title="Close">✕</a>
    
    <h1 class="auth-title">Sign <em>In</em></h1>

    @if ($errors->any())
      <div class="error-message">
        @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif

    @if (session('success'))
      <div class="success-message">{{ session('success') }}</div>
    @endif

    @if (session('error'))
      <div class="error-message">{{ session('error') }}</div>
    @endif

    <a href="{{ route('auth.google') }}" class="google-btn">
      <svg width="18" height="18" viewBox="0 0 48 48">
        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.08 17.74 9.5 24 9.5z"/>
        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-3.59-13.46-8.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
      </svg>
      Continue with Google
    </a>

    <div class="divider"><span>OR</span></div>

    <form method="POST" action="{{ route('login.post') }}">
      @csrf
      <div class="input-group">
        <input type="email" name="email" placeholder="Email address" value="{{ old('email') }}" required>
      </div>
      <div class="input-group">
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <div class="remember-group">
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">Remember me</label>
      </div>
      <button type="submit" class="auth-btn">Sign In</button>
    </form>

    <div class="auth-footer">
      Don't have an account? <a href="{{ route('register') }}">Sign up</a>
    </div>

    <div class="admin-section">
      <p>ADMIN</p>
      <button class="admin-quick-btn" onclick="window.location.href=''">
        <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6">
          <circle cx="8" cy="5" r="3"/>
          <path d="M2 14c0-3.31 2.69-6 6-6s6 2.69 6 6"/>
          <path d="M13 10l1.5 1.5L17 9" stroke="#8097ff"/>
        </svg>
        Quick Admin Login
      </button>
    </div>
  </div>
</body>
</html>