<header class="header">
  <div class="brand" id="brandBtn">
    <span class="brand-name">Son Got Samples</span>
  </div>
  <nav class="nav" id="mainNav">
    <a class="active" data-nav="home">Home</a>
    <a data-nav="library">Library</a>
    <a data-nav="pricing">Pricing</a>
    <a data-nav="about">About</a>
  </nav>
  <div class="auth-area" id="authArea">
    @guest
      <a href="{{ route('login') }}" class="al" id="loginLink">Login</a>
      <span class="asep"></span>
      <a href="{{ route('register') }}" class="al" id="signupLink">Sign Up</a>
    @endguest
@auth
  <a href="#" class="al hi" id="dashLink">{{ auth()->user()->name }}</a>
  <span class="asep"></span>
  
@if(auth()->user()->role === 'admin')
  <a class="al" id="adminPanelLink" style="color:#6074ff;font-weight:600;cursor:pointer;">
    Super Admins
  </a>
  <span class="asep"></span>
@endif
  
  <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
  <a href="#" class="al" id="logoutLink" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">Logout</a>
@endauth
  </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('adminPanelLink')?.addEventListener('click', function(e) {
        e.stopImmediatePropagation();
        e.preventDefault();
        window.location.href = '/manage-panel-x9k';
    }, true); // true = capture phase, pehle chalta hai
});
</script>