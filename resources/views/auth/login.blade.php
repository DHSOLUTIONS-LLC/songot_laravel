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
    :root{
      --blue:#6074ff;
      --blue-dim:rgba(96,116,255,.12);
      --blue-border:rgba(96,116,255,.25);
      --mu:#8f9abf;
      --surface:rgba(255,255,255,.05);
      --border:rgba(255,255,255,.1);
      --err:#ef4444;
      --err-bg:rgba(220,38,38,.15);
      --ok:#22c55e;
      --ok-bg:rgba(34,197,94,.15);
    }

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

    /* ── Login Card ── */
    .auth-container{
      background:var(--surface);
      backdrop-filter:blur(10px);
      border:1px solid var(--border);
      border-radius:24px;
      padding:48px;
      width:100%;
      max-width:440px;
      position:relative;
      animation:fadeIn 0.3s ease;
    }
    @keyframes fadeIn{from{opacity:0;transform:scale(0.96);}to{opacity:1;transform:scale(1);}}

    .close-btn{
      position:absolute;top:16px;right:16px;
      width:32px;height:32px;border-radius:50%;
      background:var(--surface);border:1px solid var(--border);
      color:var(--mu);font-size:18px;cursor:pointer;
      display:flex;align-items:center;justify-content:center;
      transition:all .2s;text-decoration:none;
    }
    .close-btn:hover{background:rgba(255,255,255,.15);color:#fff;transform:rotate(90deg);}

    .auth-title{
      font-family:'Exo 2';font-size:32px;font-weight:200;
      text-align:center;margin-bottom:32px;letter-spacing:.06em;
    }
    .auth-title em{color:var(--blue);font-style:normal;}

    .google-btn{
      width:100%;padding:12px;background:#131314;
      border:1px solid rgba(255,255,255,.18);border-radius:9px;
      color:#fff;font-size:14px;font-weight:500;
      display:flex;align-items:center;justify-content:center;gap:12px;
      cursor:pointer;transition:.2s;text-decoration:none;
    }
    .google-btn:hover{background:#222;}

    .divider{display:flex;align-items:center;gap:10px;margin:20px 0;}
    .divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--border);}
    .divider span{font-size:11px;color:var(--mu);text-transform:uppercase;}

    .input-group{margin-bottom:20px;}
    .input-group input{
      width:100%;padding:12px 14px;
      background:var(--surface);border:1px solid var(--border);
      border-radius:9px;color:#e8ecff;font-size:14px;
      outline:none;transition:.2s;font-family:inherit;
    }
    .input-group input:focus{border-color:var(--blue);background:rgba(255,255,255,.08);}

    .remember-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;}
    .remember-group{display:flex;align-items:center;gap:8px;}
    .remember-group input{width:16px;height:16px;accent-color:var(--blue);}
    .remember-group label{font-size:13px;color:var(--mu);}

    .forgot-link{
      font-size:13px;color:var(--blue);
      background:none;border:none;cursor:pointer;
      font-family:inherit;padding:0;text-decoration:none;
      transition:.15s;
    }
    .forgot-link:hover{opacity:.75;}

    .auth-btn{
      width:100%;padding:12px;
      background:linear-gradient(135deg,#6074ff,#4a5ee8);
      border:none;border-radius:9px;color:#fff;
      font-size:14px;font-weight:600;cursor:pointer;transition:.2s;
    }
    .auth-btn:hover{opacity:.9;transform:translateY(-1px);}

    .auth-footer{text-align:center;margin-top:24px;font-size:13px;color:var(--mu);}
    .auth-footer a{color:var(--blue);text-decoration:none;}

    .error-message{
      background:var(--err-bg);border:1px solid var(--err);
      border-radius:9px;padding:12px;margin-bottom:20px;
      font-size:13px;color:#fca5a5;
    }
    .success-message{
      background:var(--ok-bg);border:1px solid var(--ok);
      border-radius:9px;padding:12px;margin-bottom:20px;
      font-size:13px;color:#86efac;
    }

    .admin-section{
      margin-top:20px;padding-top:20px;
      border-top:1px solid rgba(255,255,255,.08);text-align:center;
    }
    .admin-section p{font-size:10px;color:#5a6488;text-transform:uppercase;letter-spacing:.1em;margin-bottom:10px;}
    .admin-quick-btn{
      width:100%;padding:10px;
      background:var(--blue-dim);border:1px solid var(--blue-border);
      border-radius:9px;color:#8097ff;font-size:12px;font-weight:500;
      cursor:pointer;transition:.2s;
      display:flex;align-items:center;justify-content:center;gap:8px;
    }
    .admin-quick-btn:hover{background:rgba(96,116,255,.2);border-color:rgba(96,116,255,.4);}

    /* ─────────────────────────────────────────────
       MODAL OVERLAY
    ───────────────────────────────────────────── */
    .modal-overlay{
      position:fixed;inset:0;z-index:100;
      background:rgba(0,3,10,.82);
      backdrop-filter:blur(6px);
      display:flex;align-items:center;justify-content:center;
      opacity:0;pointer-events:none;
      transition:opacity .25s;
    }
    .modal-overlay.open{opacity:1;pointer-events:all;}

    .modal{
      background:rgba(13,17,36,.95);
      border:1px solid rgba(96,116,255,.22);
      border-radius:24px;
      padding:40px;
      width:100%;max-width:400px;
      position:relative;
      transform:scale(.94) translateY(12px);
      transition:transform .28s cubic-bezier(.34,1.36,.64,1);
      margin:20px;
    }
    .modal-overlay.open .modal{transform:scale(1) translateY(0);}

    .modal-close{
      position:absolute;top:14px;right:14px;
      width:30px;height:30px;border-radius:50%;
      background:rgba(255,255,255,.05);
      border:1px solid rgba(255,255,255,.1);
      color:var(--mu);font-size:16px;cursor:pointer;
      display:flex;align-items:center;justify-content:center;
      transition:all .2s;
    }
    .modal-close:hover{background:rgba(255,255,255,.12);color:#fff;transform:rotate(90deg);}

    .modal-title{
      font-family:'Exo 2';font-size:24px;font-weight:200;
      text-align:center;margin-bottom:6px;letter-spacing:.05em;
    }
    .modal-title em{color:var(--blue);font-style:normal;}
    .modal-subtitle{
      font-size:13px;color:var(--mu);
      text-align:center;margin-bottom:28px;line-height:1.5;
    }

    /* Steps */
    .step{display:none;}
    .step.active{display:block;}

    /* Step indicator */
    .step-indicator{
      display:flex;align-items:center;justify-content:center;
      gap:0;margin-bottom:28px;
    }
    .step-dot{
      width:28px;height:28px;border-radius:50%;
      background:rgba(255,255,255,.05);
      border:1px solid rgba(255,255,255,.15);
      color:var(--mu);font-size:11px;font-weight:600;
      display:flex;align-items:center;justify-content:center;
      transition:.25s;position:relative;z-index:1;
    }
    .step-dot.active{background:var(--blue);border-color:var(--blue);color:#fff;box-shadow:0 0 0 4px rgba(96,116,255,.2);}
    .step-dot.done{background:rgba(34,197,94,.2);border-color:var(--ok);color:var(--ok);}
    .step-line{width:32px;height:1px;background:rgba(255,255,255,.1);}
    .step-line.done{background:rgba(34,197,94,.4);}

    /* OTP input grid */
    .otp-grid{display:flex;gap:10px;justify-content:center;margin-bottom:24px;}
    .otp-cell{
      width:44px;height:52px;
      background:var(--surface);
      border:1px solid var(--border);
      border-radius:10px;
      color:#e8ecff;font-size:22px;font-weight:600;
      text-align:center;outline:none;
      transition:.2s;font-family:'Exo 2',inherit;
      caret-color:var(--blue);
    }
    .otp-cell:focus{border-color:var(--blue);background:rgba(255,255,255,.08);box-shadow:0 0 0 3px rgba(96,116,255,.18);}
    .otp-cell.filled{border-color:rgba(96,116,255,.5);}
    .otp-cell.error{border-color:var(--err);background:rgba(220,38,38,.08);}

    /* Password strength */
    .pw-strength{margin-top:8px;margin-bottom:16px;}
    .pw-strength-bar{height:3px;border-radius:2px;background:rgba(255,255,255,.08);margin-bottom:5px;}
    .pw-strength-fill{height:100%;border-radius:2px;transition:width .3s, background .3s;width:0;}
    .pw-strength-label{font-size:11px;color:var(--mu);}

    /* Password field wrapper */
    .pw-wrap{position:relative;}
    .pw-wrap input{padding-right:40px;}
    .pw-eye{
      position:absolute;right:12px;top:50%;transform:translateY(-50%);
      background:none;border:none;cursor:pointer;color:var(--mu);
      display:flex;align-items:center;padding:0;transition:.15s;
    }
    .pw-eye:hover{color:#e8ecff;}

    /* In-modal messages */
    .modal-msg{
      border-radius:8px;padding:10px 13px;
      font-size:13px;margin-bottom:18px;display:none;
    }
    .modal-msg.error{background:var(--err-bg);border:1px solid var(--err);color:#fca5a5;display:block;}
    .modal-msg.success{background:var(--ok-bg);border:1px solid var(--ok);color:#86efac;display:block;}

    /* Resend */
    .resend-row{text-align:center;margin-bottom:18px;font-size:13px;color:var(--mu);}
    .resend-btn{
      background:none;border:none;color:var(--blue);
      cursor:pointer;font-size:13px;font-family:inherit;
      padding:0;transition:.15s;
    }
    .resend-btn:hover{opacity:.7;}
    .resend-btn:disabled{color:var(--mu);cursor:default;opacity:1;}

    .modal-btn{
      width:100%;padding:12px;
      background:linear-gradient(135deg,#6074ff,#4a5ee8);
      border:none;border-radius:9px;color:#fff;
      font-size:14px;font-weight:600;cursor:pointer;transition:.2s;
      font-family:inherit;display:flex;align-items:center;justify-content:center;gap:8px;
    }
    .modal-btn:hover{opacity:.9;transform:translateY(-1px);}
    .modal-btn:disabled{opacity:.5;cursor:not-allowed;transform:none;}

    .modal-input{
      width:100%;padding:12px 14px;
      background:var(--surface);border:1px solid var(--border);
      border-radius:9px;color:#e8ecff;font-size:14px;
      outline:none;transition:.2s;font-family:inherit;
      margin-bottom:16px;
    }
    .modal-input:focus{border-color:var(--blue);background:rgba(255,255,255,.08);}

    /* Spinner */
    .spinner{
      width:16px;height:16px;border:2px solid rgba(255,255,255,.3);
      border-top-color:#fff;border-radius:50%;
      animation:spin .6s linear infinite;display:none;
    }
    @keyframes spin{to{transform:rotate(360deg);}}
    .loading .spinner{display:block;}
    .loading .btn-text{display:none;}
  </style>
</head>
<body>

  {{-- ══════════════════════════════════════
       LOGIN CARD
  ══════════════════════════════════════ --}}
  <div class="auth-container">
    <a href="{{ url('/') }}" class="close-btn" title="Close">✕</a>

    <h1 class="auth-title">Sign <em>In</em></h1>

    @if ($errors->any())
      <div class="error-message">
        @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
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
        <input type="email" name="email" id="loginEmail"
               placeholder="Email address" value="{{ old('email') }}" required>
      </div>
      <div class="input-group">
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <div class="remember-row">
        <div class="remember-group">
          <input type="checkbox" name="remember" id="remember">
          <label for="remember">Remember me</label>
        </div>
        <button type="button" class="forgot-link" onclick="openForgotModal()">Forgot password?</button>
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
        </svg>
        Quick Admin Login
      </button>
    </div>
  </div>


  {{-- ══════════════════════════════════════
       FORGOT PASSWORD MODAL
  ══════════════════════════════════════ --}}
  <div class="modal-overlay" id="forgotOverlay" onclick="overlayClick(event)">
    <div class="modal">
      <button class="modal-close" onclick="closeModal()">✕</button>

      {{-- Step dots --}}
      <div class="step-indicator">
        <div class="step-dot active" id="dot1">1</div>
        <div class="step-line" id="line1"></div>
        <div class="step-dot" id="dot2">2</div>
        <div class="step-line" id="line2"></div>
        <div class="step-dot" id="dot3">3</div>
      </div>

      <div class="modal-msg" id="modalMsg"></div>

      {{-- ─── STEP 1: Enter email ─── --}}
      <div class="step active" id="step1">
        <h2 class="modal-title">Forgot <em>Password</em></h2>
        <p class="modal-subtitle">Enter your account email and we'll send you a 6-digit reset code.</p>

        <input type="email" class="modal-input" id="fpEmail" placeholder="Email address">

        <button class="modal-btn" id="sendOtpBtn" onclick="sendOtp()">
          <span class="btn-text">Send Reset Code</span>
          <div class="spinner"></div>
        </button>
      </div>

      {{-- ─── STEP 2: Enter OTP ─── --}}
      <div class="step" id="step2">
        <h2 class="modal-title">Enter <em>Code</em></h2>
        <p class="modal-subtitle">We sent a 6-digit code to <strong id="emailDisplay" style="color:#e8ecff"></strong></p>

        <div class="otp-grid">
          <input class="otp-cell" type="text" inputmode="numeric" maxlength="1" id="otp0">
          <input class="otp-cell" type="text" inputmode="numeric" maxlength="1" id="otp1">
          <input class="otp-cell" type="text" inputmode="numeric" maxlength="1" id="otp2">
          <input class="otp-cell" type="text" inputmode="numeric" maxlength="1" id="otp3">
          <input class="otp-cell" type="text" inputmode="numeric" maxlength="1" id="otp4">
          <input class="otp-cell" type="text" inputmode="numeric" maxlength="1" id="otp5">
        </div>

        <button class="modal-btn" id="verifyOtpBtn" onclick="verifyOtp()">
          <span class="btn-text">Verify Code</span>
          <div class="spinner"></div>
        </button>

        <div class="resend-row" style="margin-top:16px;">
          Didn't receive it?
          <button class="resend-btn" id="resendBtn" onclick="resendOtp()">Resend</button>
          <span id="resendTimer" style="display:none;"></span>
        </div>
      </div>

      {{-- ─── STEP 3: New password ─── --}}
      <div class="step" id="step3">
        <h2 class="modal-title">New <em>Password</em></h2>
        <p class="modal-subtitle">Choose a strong password for your account.</p>

        <div class="pw-wrap">
          <input type="password" class="modal-input" id="newPassword"
                 placeholder="New password" oninput="checkStrength(this.value)">
          <button type="button" class="pw-eye" onclick="togglePw('newPassword',this)">
            <svg id="eye1" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>

        <div class="pw-strength">
          <div class="pw-strength-bar"><div class="pw-strength-fill" id="strengthFill"></div></div>
          <div class="pw-strength-label" id="strengthLabel">Enter a password</div>
        </div>

        <div class="pw-wrap">
          <input type="password" class="modal-input" id="confirmPassword" placeholder="Confirm password">
          <button type="button" class="pw-eye" onclick="togglePw('confirmPassword',this)">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>

        <button class="modal-btn" id="resetPwBtn" onclick="resetPassword()">
          <span class="btn-text">Set New Password</span>
          <div class="spinner"></div>
        </button>
      </div>

    </div>{{-- .modal --}}
  </div>{{-- .modal-overlay --}}


<script>
  // ── State ──
  let currentStep = 1;
  let verifiedEmail = '';
  let resetToken = '';
  let resendInterval = null;

  // ── Helpers ──
  const $ = id => document.getElementById(id);

  function showMsg(text, type = 'error') {
    const el = $('modalMsg');
    el.className = 'modal-msg ' + type;
    el.textContent = text;
  }
  function clearMsg() {
    const el = $('modalMsg');
    el.className = 'modal-msg';
    el.textContent = '';
  }

  function setLoading(btnId, on) {
    const btn = $(btnId);
    btn.disabled = on;
    btn.classList.toggle('loading', on);
  }

  function goToStep(n) {
    currentStep = n;
    [1,2,3].forEach(i => {
      $('step'+i).classList.toggle('active', i === n);
      const dot = $('dot'+i);
      dot.classList.remove('active','done');
      if (i < n) dot.classList.add('done'), dot.textContent = '✓';
      else if (i === n) dot.classList.add('active'), dot.textContent = i;
      else dot.textContent = i;
    });
    ['line1','line2'].forEach((id,i) => {
      $(id).classList.toggle('done', n > i+1);
    });
    clearMsg();
  }

  // ── Open / Close modal ──
  function openForgotModal() {
    const emailVal = $('loginEmail') ? $('loginEmail').value.trim() : '';
    if (emailVal) $('fpEmail').value = emailVal;
    $('forgotOverlay').classList.add('open');
    goToStep(1);
    setTimeout(() => $('fpEmail').focus(), 300);
  }
  function closeModal() {
    $('forgotOverlay').classList.remove('open');
    clearMsg();
    clearOtp();
    if (resendInterval) clearInterval(resendInterval);
  }
  function overlayClick(e) {
    if (e.target === $('forgotOverlay')) closeModal();
  }

  // ── STEP 1: Send OTP ──
  async function sendOtp() {
    clearMsg();
    const email = $('fpEmail').value.trim();
    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      return showMsg('Please enter a valid email address.');
    }
    setLoading('sendOtpBtn', true);
    try {
      const res = await apiFetch('/api/forgot-password/send-otp', { email });
      if (res.success) {
        verifiedEmail = email;
        $('emailDisplay').textContent = email;
        goToStep(2);
        startResendTimer(60);
        setTimeout(() => $('otp0').focus(), 300);
      } else {
        showMsg(res.message || 'Something went wrong.');
      }
    } catch(e) {
      showMsg('Network error. Please try again.');
    } finally {
      setLoading('sendOtpBtn', false);
    }
  }

  // ── STEP 2: Verify OTP ──
  function getOtpValue() {
    return [0,1,2,3,4,5].map(i => $('otp'+i).value).join('');
  }
  function clearOtp() {
    [0,1,2,3,4,5].forEach(i => {
      const c = $('otp'+i);
      if(c){ c.value=''; c.classList.remove('filled','error'); }
    });
  }
  function setOtpError() {
    [0,1,2,3,4,5].forEach(i => $('otp'+i).classList.add('error'));
  }

  async function verifyOtp() {
    clearMsg();
    const otp = getOtpValue();
    if (otp.length < 6) return showMsg('Please enter the complete 6-digit code.');
    setLoading('verifyOtpBtn', true);
    try {
      const res = await apiFetch('/api/forgot-password/verify-otp', { email: verifiedEmail, otp });
      if (res.success) {
        resetToken = res.reset_token;
        goToStep(3);
        setTimeout(() => $('newPassword').focus(), 300);
      } else {
        setOtpError();
        showMsg(res.message || 'Invalid code. Please try again.');
      }
    } catch(e) {
      showMsg('Network error. Please try again.');
    } finally {
      setLoading('verifyOtpBtn', false);
    }
  }

  async function resendOtp() {
    clearMsg();
    clearOtp();
    const btn = $('resendBtn');
    btn.disabled = true;
    try {
      const res = await apiFetch('/api/forgot-password/send-otp', { email: verifiedEmail });
      if (res.success) {
        showMsg('A new code has been sent to your email.', 'success');
        startResendTimer(60);
      } else {
        showMsg(res.message || 'Could not resend. Please wait.');
        btn.disabled = false;
      }
    } catch(e) {
      showMsg('Network error.');
      btn.disabled = false;
    }
  }

  function startResendTimer(seconds) {
    const btn = $('resendBtn');
    const timer = $('resendTimer');
    btn.style.display = 'none';
    timer.style.display = 'inline';
    if (resendInterval) clearInterval(resendInterval);
    let s = seconds;
    timer.textContent = `Resend in ${s}s`;
    resendInterval = setInterval(() => {
      s--;
      if (s <= 0) {
        clearInterval(resendInterval);
        timer.style.display = 'none';
        btn.style.display = 'inline';
        btn.disabled = false;
      } else {
        timer.textContent = `Resend in ${s}s`;
      }
    }, 1000);
  }

  // ── STEP 3: Reset password ──
  async function resetPassword() {
    clearMsg();
    const pw = $('newPassword').value;
    const cpw = $('confirmPassword').value;
    if (pw.length < 8) return showMsg('Password must be at least 8 characters.');
    if (pw !== cpw) return showMsg('Passwords do not match.');
    setLoading('resetPwBtn', true);
    try {
      const res = await apiFetch('/api/forgot-password/reset', {
        email: verifiedEmail,
        reset_token: resetToken,
        password: pw,
        password_confirmation: cpw,
      });
      if (res.success) {
        showMsg(res.message || 'Password reset! Redirecting…', 'success');
        setTimeout(() => {
          closeModal();
          // Optionally pre-fill email on login form
          if ($('loginEmail')) $('loginEmail').value = verifiedEmail;
        }, 1800);
      } else {
        showMsg(res.message || 'Something went wrong.');
      }
    } catch(e) {
      showMsg('Network error. Please try again.');
    } finally {
      setLoading('resetPwBtn', false);
    }
  }

  // ── Password strength ──
  function checkStrength(v) {
    const fill = $('strengthFill');
    const label = $('strengthLabel');
    let score = 0;
    if (v.length >= 8) score++;
    if (/[A-Z]/.test(v)) score++;
    if (/[0-9]/.test(v)) score++;
    if (/[^A-Za-z0-9]/.test(v)) score++;
    const map = [
      {w:'0%',   c:'#ef4444', t:'Too short'},
      {w:'25%',  c:'#ef4444', t:'Weak'},
      {w:'50%',  c:'#f59e0b', t:'Fair'},
      {w:'75%',  c:'#6074ff', t:'Good'},
      {w:'100%', c:'#22c55e', t:'Strong'},
    ];
    const s = v.length === 0 ? 0 : score;
    fill.style.width = map[s].w;
    fill.style.background = map[s].c;
    label.textContent = v.length === 0 ? 'Enter a password' : map[s].t;
    label.style.color = v.length === 0 ? 'var(--mu)' : map[s].c;
  }

  // ── Toggle password visibility ──
  function togglePw(inputId, btn) {
    const inp = $(inputId);
    const show = inp.type === 'password';
    inp.type = show ? 'text' : 'password';
    btn.innerHTML = show
      ? `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
      : `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
  }

  // ── OTP cell keyboard navigation ──
  document.addEventListener('DOMContentLoaded', () => {
    [0,1,2,3,4,5].forEach(i => {
      const cell = $('otp'+i);
      if (!cell) return;
      cell.addEventListener('keydown', e => {
        if (e.key === 'Backspace') {
          if (!cell.value && i > 0) { $('otp'+(i-1)).focus(); $('otp'+(i-1)).value = ''; }
          cell.classList.remove('filled','error');
        } else if (e.key === 'ArrowLeft' && i > 0) {
          $('otp'+(i-1)).focus();
        } else if (e.key === 'ArrowRight' && i < 5) {
          $('otp'+(i+1)).focus();
        } else if (e.key === 'Enter') {
          verifyOtp();
        }
      });
      cell.addEventListener('input', e => {
        const v = cell.value.replace(/[^0-9]/g,'');
        cell.value = v ? v[v.length-1] : '';
        cell.classList.remove('error');
        cell.classList.toggle('filled', !!cell.value);
        if (cell.value && i < 5) $('otp'+(i+1)).focus();
      });
      cell.addEventListener('paste', e => {
        e.preventDefault();
        const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g,'').slice(0,6);
        pasted.split('').forEach((ch, idx) => {
          const t = $('otp'+idx);
          if (t) { t.value = ch; t.classList.add('filled'); }
        });
        const last = Math.min(pasted.length, 5);
        $('otp'+last).focus();
      });
    });

    // Enter key on email field
    const fpEmail = $('fpEmail');
    if (fpEmail) fpEmail.addEventListener('keydown', e => { if (e.key === 'Enter') sendOtp(); });

    // Escape closes modal
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
  });

  // ── API fetch helper ──
  async function apiFetch(url, body) {
    const res = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json',
      },
      body: JSON.stringify(body),
    });
    return res.json();
  }
</script>
</body>
</html>