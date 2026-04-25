<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Son Got Samples</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@200;300;400;600&family=Poppins:wght@300;400;500;600&family=Share+Tech+Mono&display=swap" rel="stylesheet">

  <script>
    (function() {
      if (localStorage.getItem('sgs_theme') === 'light') {
        document.documentElement.classList.add('theme-light');
        document.body && document.body.classList.add('theme-light');
      }
    })();
  </script>
  <style>
    :root{
      --hh:68px;--ph:72px;--fh:52px;
      --bg:#000510;--bg2:#00030a;--acc:#6074ff;
      --tx:#e8ecff;--mu:#8f9abf;--mu2:#5a6488;
      --di:rgba(255,255,255,.07);--me:rgba(255,255,255,.12);
      --hg:rgba(120,160,255,.26);--in:rgba(255,255,255,.20);
      --pb:rgba(255,255,255,.03);--pb2:rgba(255,255,255,.015);
    }
    body.theme-light {
      --bg: #f0f2f8;
      --bg2: #e8eaf2;
      --acc: #4a5ee8;
      --tx: #1a1d2e;
      --mu: rgba(0,0,0,.5);
      --mu2: rgba(0,0,0,.35);
      --di: rgba(0,0,0,.08);
      --me: rgba(0,0,0,.12);
      --hg: rgba(74,94,232,.18);
      --in: rgba(0,0,0,.15);
      --pb: rgba(0,0,0,.03);
      --pb2: rgba(0,0,0,.015);
    }
    body.theme-light { background:var(--bg);color:var(--tx); }
    body.theme-light .space { background:linear-gradient(180deg,#e8eaf5,#dde0f0); }
    body.theme-light .space::before { background:radial-gradient(50% 70% at 40% 50%,rgba(74,94,232,.06),transparent 80%); }
    body.theme-light .blob { background:radial-gradient(circle at 30% 30%,rgba(74,94,232,.08),transparent 80%);opacity:.06; }
    body.theme-light .header { background:rgba(240,242,248,.96);border-bottom-color:rgba(0,0,0,.08); }
    body.theme-light .nav a { color:var(--tx); }
    body.theme-light .brand-name { color:var(--tx); }
    body.theme-light .al { color:var(--tx); }
    body.theme-light .al.hi { color:var(--acc); }
    body.theme-light .asep { background:rgba(0,0,0,.15); }
    body.theme-light .site-footer { border-top-color:rgba(0,0,0,.08); }
    body.theme-light .feat-card { background:rgba(255,255,255,.7);border-color:rgba(0,0,0,.07); }
    body.theme-light .mobile-nav { background:rgba(240,242,248,.98);border-left-color:rgba(0,0,0,.08); }

    *{box-sizing:border-box;margin:0;padding:0}
    html,body{height:100%}
    body{font-family:'Poppins',system-ui,sans-serif;color:var(--tx);background:var(--bg);overflow-x:hidden;}
    a{color:inherit;text-decoration:none}
    button{font-family:inherit;cursor:pointer}

    /* Space background */
    .space{position:fixed;inset:0;z-index:-3;overflow:hidden;background:linear-gradient(180deg,var(--bg),var(--bg2));}
    .space::before{content:'';position:absolute;inset:-20%;background:radial-gradient(50% 70% at 40% 50%,rgba(99,117,255,.07),transparent 80%),radial-gradient(50% 70% at 70% 60%,rgba(60,90,220,.05),transparent 90%);filter:blur(22px);opacity:.22;animation:waves 60s ease-in-out infinite;}
    .blob{position:absolute;border-radius:50%;filter:blur(64px);opacity:.07;background:radial-gradient(circle at 30% 30%,rgba(99,117,255,.14),rgba(48,64,160,.08) 60%,transparent 80%);animation:drift 90s ease-in-out infinite;}
    .blob.b2{left:-12vmax;top:18vh;width:70vmax;height:70vmax;animation-duration:95s;}
    .blob.b3{right:-14vmax;top:-10vh;width:60vmax;height:60vmax;animation-duration:85s;}
    @keyframes waves{0%{transform:translate(-4%,-2%) rotate(0)}50%{transform:translate(4%,2%) rotate(180deg)}100%{transform:translate(-4%,-2%) rotate(360deg)}}
    @keyframes drift{0%{transform:translate(-6%,-4%) scale(1)}50%{transform:translate(6%,4%) scale(1.05)}100%{transform:translate(-6%,-4%) scale(1)}}

    /* HEADER */
    .header{position:fixed;top:0;left:0;right:0;height:var(--hh);display:flex;align-items:center;justify-content:space-between;padding:0 32px;z-index:50;background:rgba(0,5,18,.95);backdrop-filter:blur(14px);border-bottom:1px solid rgba(255,255,255,.055);}
    .brand{display:flex;align-items:center;cursor:pointer;}
    .brand-name{font-family:'Exo 2';font-weight:400;font-size:.88rem;letter-spacing:.11em;text-transform:uppercase;color:var(--tx);}
    .brand:hover .brand-name{color:var(--acc);}
    .nav{display:flex;gap:22px;align-items:center;}
    .nav a{font-family:'Exo 2';font-weight:400;font-size:.88rem;letter-spacing:.11em;text-transform:uppercase;color:var(--tx);opacity:.68;cursor:pointer;}
    .nav a:hover,.nav a.active{color:var(--acc);opacity:1;}
    .auth-area{display:flex;align-items:center;gap:10px;}
    .al{font-family:'Exo 2';font-weight:400;font-size:.88rem;letter-spacing:.11em;text-transform:uppercase;color:var(--tx);opacity:.8;cursor:pointer;}
    .al:hover{color:var(--acc);opacity:1;}
    .al.hi{color:var(--acc);opacity:1;}
    .asep{width:1px;height:16px;background:var(--me);}

    /* Mobile Menu Button */
    .menu-toggle{display:none;background:transparent;border:none;cursor:pointer;padding:10px;z-index:101;}
    .menu-toggle span{display:block;width:25px;height:2px;background:white;margin:5px 0;transition:0.3s;}

    /* Mobile Navigation */
    .mobile-nav{position:fixed;top:0;right:-100%;width:70%;max-width:280px;height:100vh;background:rgba(5,12,35,.98);backdrop-filter:blur(14px);z-index:99;padding:80px 25px 30px;transition:0.3s;display:flex;flex-direction:column;gap:20px;border-left:1px solid var(--di);}
    .mobile-nav.open{right:0;}
    .mobile-nav a{color:var(--tx);text-decoration:none;font-size:1rem;padding:12px 0;border-bottom:1px solid var(--di);font-family:'Exo 2';letter-spacing:.1em;}
    .mobile-nav a:hover{color:var(--acc);}
    .mobile-auth{margin-top:20px;display:flex;flex-direction:column;gap:12px;}
    .mobile-auth a{border-bottom:none !important;}
    .overlay{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:98;display:none;}
    .overlay.active{display:block;}

    /* Footer */
    .site-footer{height:var(--fh);display:flex;align-items:center;justify-content:center;gap:9px;padding:0 24px;border-top:1px solid var(--di);font-size:12px;color:var(--mu2);flex-wrap:wrap;}
    .site-footer a{color:var(--mu2);transition:.2s;cursor:pointer;}
    .site-footer a:hover{color:var(--acc);}

    /* Pages */
    .page{display:none;}
    .page.active{display:block;}
    main{padding-top:var(--hh);}

    /* Hero */
    .hero-section{min-height:calc(100vh - var(--hh));display:flex;align-items:center;justify-content:center;padding:20px;}
    .hero{text-align:center;max-width:800px;}
    .hero-title{font-family:'Exo 2';font-weight:200;font-size:clamp(28px,5vw,60px);margin-bottom:16px;}
    .hero-title em{color:var(--acc);font-style:normal;}
    .hero-sub{font-size:clamp(13px,2vw,16px);color:var(--mu);margin-bottom:32px;max-width:500px;margin-left:auto;margin-right:auto;}
    .hero-btns{display:flex;gap:16px;justify-content:center;flex-wrap:wrap;}
    .hero-btn-primary,.hero-btn-sec{padding:12px 32px;border-radius:30px;font-size:14px;font-weight:600;cursor:pointer;transition:0.3s;}
    .hero-btn-primary{background:linear-gradient(135deg,var(--acc),#4a5ee8);border:none;color:#fff;}
    .hero-btn-sec{background:rgba(255,255,255,.05);border:1px solid var(--me);color:var(--tx);}
    .hero-btn-primary:hover,.hero-btn-sec:hover{transform:translateY(-2px);}

    /* Features */
    .whats-inside-section{padding:60px 0 20px;border-top:1px solid var(--di);}
    .feat-intro{text-align:center;padding:10px 0 24px;}
    .feat-intro h2{font-family:'Exo 2';font-weight:300;font-size:clamp(18px,2vw,24px);text-transform:uppercase;letter-spacing:.08em;}
    .feat-intro p{font-size:clamp(12px,1.5vw,14px);color:var(--mu);max-width:400px;margin:0 auto;}
    .feat-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;max-width:1100px;margin:0 auto;padding:0 20px;}
    .feat-card{background:var(--pb);border:1px solid var(--di);border-radius:12px;padding:20px;}
    .feat-card:hover{transform:translateY(-3px);border-color:rgba(96,116,255,.3);}
    .ft{font-family:'Exo 2';font-size:.8rem;text-transform:uppercase;letter-spacing:.1em;margin-bottom:8px;}
    .fd{font-size:clamp(11px,1.2vw,13px);color:var(--mu);line-height:1.5;}

    /* Container */
    .hw,.lw,.pw,.aw,.dw{max-width:1200px;margin:0 auto;padding:20px 24px 60px;}

    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px){
      :root{--hh:60px;--ph:65px;}
      .header{padding:0 15px;}
      .nav,.auth-area{display:none;}
      .menu-toggle{display:block;}
      .feat-grid{grid-template-columns:1fr!important;gap:12px;padding:0 16px;}
      .feat-card{padding:16px;}
      .whats-inside-section{padding:30px 0 15px;}
      .hero-btns{gap:12px;}
      .hero-btn-primary,.hero-btn-sec{padding:10px 24px;font-size:13px;}
      .hw,.lw,.pw,.aw,.dw{padding:15px 16px 50px;}
      .lib-topbar{flex-direction:column;}
      .lib-search,.lib-sort,.lib-unlock{width:100%;}
      .lib-table-wrap{overflow-x:auto;}
      .lib-table{min-width:600px;}
      .site-footer{font-size:10px;gap:6px;}
    }
    @media (max-width: 480px){
      .hero-title{font-size:24px;}
      .hero-sub{font-size:12px;}
      .hero-btn-primary,.hero-btn-sec{padding:8px 20px;font-size:12px;}
      .ft{font-size:.7rem;}
      .fd{font-size:10px;}
      .site-footer{font-size:9px;}
    }
    @media (min-width:769px) and (max-width:1024px){
      .feat-grid{grid-template-columns:repeat(2,1fr)!important;}
    }

    /* ========== CLIENT DESIGN SPECIFIC STYLES ========== */
    .cat-pill[data-cat="Acapella"]:hover,.cat-pill[data-cat="Acapella"].active { background:rgba(210,40,40,.13)!important;border-color:#d82828!important;color:#ff5555!important; }
    .cat-pill[data-cat="Drums"]:hover,.cat-pill[data-cat="Drums"].active       { background:rgba(96,116,255,.15)!important;border-color:var(--acc)!important;color:#8097ff!important; }
    .cat-pill[data-cat="Bass"]:hover,.cat-pill[data-cat="Bass"].active         { background:rgba(30,185,145,.13)!important;border-color:#1eb991!important;color:#23c99a!important; }
    .cat-pill[data-cat="Melody"]:hover,.cat-pill[data-cat="Melody"].active     { background:rgba(215,170,28,.13)!important;border-color:#d0a81c!important;color:#ddb820!important; }
    .cat-pill[data-cat="Instrumental"]:hover,.cat-pill[data-cat="Instrumental"].active { background:rgba(160,85,235,.13)!important;border-color:#9050e0!important;color:#b070f0!important; }

    .play-btn { width:28px;height:28px;border-radius:50%;background:rgba(96,116,255,.1);border:1px solid rgba(96,116,255,.24);display:inline-flex;align-items:center;justify-content:center;cursor:pointer;transition:.15s; }
    .play-btn:hover { background:rgba(96,116,255,.28);border-color:var(--acc); }
    .play-btn.ia { background:var(--acc);border-color:var(--acc); }
    .play-btn .pp { width:9px;height:9px;display:block; }
    .play-btn .pa { width:9px;height:9px;display:none; }
    .play-btn.ia .pp { display:none; }
    .play-btn.ia .pa { display:block; }

    .lock-ico { width:28px;height:28px;display:inline-flex;align-items:center;justify-content:center; }
    .lock-ico svg { width:12px;height:12px;fill:var(--mu2); }

    .trk-title { white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px; }
    .trk-art   { white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:150px; }

    .price-card.feat::after { content:'Best Value';position:absolute;top:14px;right:-26px;background:var(--acc);color:#fff;font-size:9px;letter-spacing:.1em;text-transform:uppercase;padding:4px 30px;transform:rotate(45deg);font-weight:700; }

    .access-strip-txt strong { color:var(--tx); }

    .unlock-row-btn { height:27px;padding:0 11px;border-radius:6px;background:linear-gradient(135deg,var(--acc),#4a5ee8);border:none;color:#fff;font-size:11px;font-weight:600;cursor:pointer;white-space:nowrap;box-shadow:0 0 8px rgba(96,116,255,.22);transition:.15s;display:inline-flex;align-items:center;gap:4px; }
    .unlock-row-btn:hover { opacity:.88;box-shadow:0 0 14px rgba(96,116,255,.44); }
  </style>
</head>
<body>

<div class="space" aria-hidden="true">
  <div class="blob b2"></div>
  <div class="blob b3"></div>
</div>

{{-- HEADER --}}
<header class="header">
  <div class="brand" id="brandBtn">
    <span class="brand-name">SON GOT SAMPLES</span>
  </div>

  <nav class="nav" id="mainNav">
    <a class="active" data-nav="home">HOME</a>
    <a data-nav="library">LIBRARY</a>
    <a data-nav="pricing">PRICING</a>
    <a data-nav="about">ABOUT</a>
    @auth
      @if(auth()->user()->plan_tier === 'full')
        <a data-nav="vault" style="color:#f0c860;">VAULT</a>
      @endif
    @endauth
  </nav>

  <div class="auth-area" id="authArea">
    {{-- GUEST: show Login + Sign Up --}}
    @guest
      <a href="{{ route('login') }}" class="al" id="loginLink">LOGIN</a>
      <span class="asep"></span>
      <a href="{{ route('register') }}" class="al" id="signupLink">SIGN UP</a>
    @endguest

    {{-- LOGGED IN: show Username + Logout (admin gets extra link) --}}
    @auth
      @if(auth()->user()->role === 'admin')
        <a href="/manage-panel-x9k" class="al hi">SUPER ADMINS</a>
        <span class="asep"></span>
      @endif
      {{-- Dashboard link --}}
      <a href="#" class="al hi" id="dashLink">DASHBOARD</a>
      <span class="asep"></span>
      <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
      <a href="#" class="al" id="logoutLink" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">LOGOUT</a>
    @endauth
  </div>

  <button class="menu-toggle" id="menuToggle">
    <span></span><span></span><span></span>
  </button>
</header>

{{-- MOBILE NAV --}}
<div class="mobile-nav" id="mobileNav">
  <button onclick="toggleMenu()" style="position:absolute;top:18px;right:20px;background:none;border:none;cursor:pointer;padding:6px;line-height:1;">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--tx)" stroke-width="2" stroke-linecap="round">
      <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
    </svg>
  </button>

  {{-- Nav links --}}
  <a data-nav="home">HOME</a>
  <a data-nav="library">LIBRARY</a>
  <a data-nav="pricing">PRICING</a>
  <a data-nav="about">ABOUT</a>
  @auth
    @if(auth()->user()->plan_tier === 'full')
      <a data-nav="vault">VAULT</a>
    @endif
  @endauth

  {{-- Auth section at bottom --}}
  <div class="mobile-auth">
    @guest
      <a href="{{ route('login') }}" class="al">LOGIN</a>
      <a href="{{ route('register') }}" class="al">SIGN UP</a>
    @endguest

    @auth
      {{-- Dashboard link --}}
      @if(auth()->user()->role === 'admin')
        <a href="/manage-panel-x9k" class="al hi">DASHBOARD</a>
      @else
        <a href="#" class="al hi" id="mobileDashLink">DASHBOARD</a>
      @endif
      <a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();" class="al">LOGOUT</a>
    @endauth
  </div>
</div>
<div class="overlay" id="overlay"></div>

<main>
  @include('pages.home')
  @include('pages.library')
  @include('pages.pricing')
  @include('pages.about')
  @include('pages.dashboard')
  @include('pages.vault')
</main>

@include('partials.modals')

<script>
  // ── Mobile Menu ──
  const menuToggle = document.getElementById('menuToggle');
  const mobileNav  = document.getElementById('mobileNav');
  const overlay    = document.getElementById('overlay');

  function toggleMenu() {
    mobileNav.classList.toggle('open');
    overlay.classList.toggle('active');
    document.body.style.overflow = mobileNav.classList.contains('open') ? 'hidden' : '';
  }

  menuToggle?.addEventListener('click', toggleMenu);
  overlay?.addEventListener('click', toggleMenu);
  document.querySelectorAll('.mobile-nav a[data-nav]').forEach(link => {
    link.addEventListener('click', () => {
      mobileNav.classList.remove('open');
      overlay.classList.remove('active');
      document.body.style.overflow = '';
    });
  });

  // ── SPA Navigation ──
  const pages = {
    home      : document.getElementById('page-home'),
    library   : document.getElementById('page-library'),
    pricing   : document.getElementById('page-pricing'),
    about     : document.getElementById('page-about'),
    dashboard : document.getElementById('page-dashboard'),
    vault     : document.getElementById('page-vault'),
  };

  const navLinks = document.querySelectorAll('#mainNav a, .mobile-nav a[data-nav]');

  function goTo(pageName) {
    if (!pages[pageName]) pageName = 'home';
    Object.values(pages).forEach(page => { if (page) page.classList.remove('active'); });
    pages[pageName].classList.add('active');
    navLinks.forEach(link => {
      link.classList.remove('active');
      if (link.getAttribute('data-nav') === pageName) link.classList.add('active');
    });
    window.scrollTo({ top: 0, behavior: 'smooth' });
    window.location.hash = pageName;
  }

  window.goTo = goTo;

  document.addEventListener('DOMContentLoaded', function () {
    // On refresh, restore page from hash
    const hash      = window.location.hash.replace('#', '').trim();
    const startPage = (hash && pages[hash]) ? hash : 'home';
    goTo(startPage);

    // Nav link clicks
    navLinks.forEach(link => {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        goTo(this.getAttribute('data-nav'));
      });
    });

    // Brand → home
    document.querySelector('.brand')?.addEventListener('click', () => goTo('home'));

    // Desktop username → dashboard
    document.getElementById('dashLink')?.addEventListener('click', function (e) {
      e.preventDefault();
      goTo('dashboard');
    });

    // Mobile username → dashboard
    document.getElementById('mobileDashLink')?.addEventListener('click', function (e) {
      e.preventDefault();
      mobileNav.classList.remove('open');
      overlay.classList.remove('active');
      document.body.style.overflow = '';
      goTo('dashboard');
    });
  });

  // Browser back/forward
  window.addEventListener('hashchange', function () {
    const hash = window.location.hash.replace('#', '').trim();
    if (hash && pages[hash]) {
      Object.values(pages).forEach(page => { if (page) page.classList.remove('active'); });
      pages[hash].classList.add('active');
      navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('data-nav') === hash) link.classList.add('active');
      });
    }
  });

  // Close mobile menu on outside click
  document.addEventListener('click', function (e) {
    if (mobileNav && mobileNav.classList.contains('open')) {
      if (!mobileNav.contains(e.target) && !menuToggle.contains(e.target)) {
        toggleMenu();
      }
    }
  });
</script>
</body>
</html>