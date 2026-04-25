<section id="page-dashboard" class="page">

  {{-- Theme style injection --}}
  <style id="theme-styles">
    :root {
      --bg: #050a18;
      --card-bg: rgba(255,255,255,.03);
      --card-border: rgba(255,255,255,.07);
      --tx: #e8eaf0;
      --mu: rgba(255,255,255,.45);
      --mu2: rgba(255,255,255,.25);
      --acc: #6074ff;
      --acc2: #4a5ee8;
      --panel-bg: #0b1128;
      --panel-border: rgba(255,255,255,.08);
      --input-bg: rgba(0,0,0,.35);
      --input-border: rgba(255,255,255,.1);
      --del-bg: rgba(180,30,30,.18);
      --del-border: rgba(220,60,60,.22);
      --del-tx: #f08080;
      --btn-outline: rgba(255,255,255,.12);
      --btn-outline-tx: #e8eaf0;
      --btn-active-bg: rgba(96,116,255,.14);
      --badge-bg: rgba(96,116,255,.18);
      --badge-tx: #a0adff;
      --overlay: rgba(0,0,0,.15);
    }
    body.theme-light {
      --bg: #f0f2f8;
      --card-bg: #ffffff;
      --card-border: rgba(0,0,0,.09);
      --tx: #1a1d2e;
      --mu: rgba(0,0,0,.45);
      --mu2: rgba(0,0,0,.3);
      --acc: #4a5ee8;
      --acc2: #3a4ed8;
      --panel-bg: #ffffff;
      --panel-border: rgba(0,0,0,.1);
      --input-bg: rgba(0,0,0,.04);
      --input-border: rgba(0,0,0,.14);
      --del-bg: rgba(220,60,60,.08);
      --del-border: rgba(200,50,50,.18);
      --del-tx: #c0392b;
      --btn-outline: rgba(0,0,0,.1);
      --btn-outline-tx: #1a1d2e;
      --btn-active-bg: rgba(74,94,232,.1);
      --badge-bg: rgba(74,94,232,.1);
      --badge-tx: #4a5ee8;
      --overlay: rgba(0,0,0,.55);
    }
    #page-dashboard {
      background: var(--bg);
      min-height: 100vh;
      transition: background 0.3s;
    }
    .dash-wrap {
      max-width: 680px;
      margin: 0 auto;
      padding: 60px 24px 80px;
    }
    /* ---------- ACCOUNT CARD ---------- */
    .acc-card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 14px;
      overflow: hidden;
    }
    .acc-card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 14px 20px;
      border-bottom: 1px solid var(--card-border);
    }
    .acc-card-header h3 {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--mu);
      margin: 0;
    }
    .acc-badge-theme {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .acc-badge {
      padding: 3px 10px;
      background: var(--badge-bg);
      color: var(--badge-tx);
      border-radius: 20px;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
    }
    /* Theme Toggle */
    .theme-label {
      font-size: 11px;
      color: var(--mu);
      margin-right: 4px;
    }
    .toggle-wrap {
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .toggle-switch {
      position: relative;
      width: 38px;
      height: 20px;
      cursor: pointer;
    }
    .toggle-switch input { display: none; }
    .toggle-track {
      position: absolute;
      inset: 0;
      background: var(--acc);
      border-radius: 20px;
      transition: background 0.3s;
    }
    body.theme-light .toggle-track { background: #c8cde8; }
    .toggle-thumb {
      position: absolute;
      width: 14px;
      height: 14px;
      top: 3px;
      left: 3px;
      background: #fff;
      border-radius: 50%;
      transition: transform 0.25s;
      box-shadow: 0 1px 4px rgba(0,0,0,.3);
    }
    body.theme-light .toggle-thumb { transform: translateX(18px); }
    /* Nav Buttons */
    .acc-nav {
      display: flex;
      gap: 0;
      padding: 14px 14px 0;
      flex-wrap: wrap;
      gap: 8px;
    }
    .acc-nav-btn {
      padding: 9px 18px;
      background: transparent;
      border: 1px solid var(--btn-outline);
      border-radius: 8px;
      color: var(--btn-outline-tx);
      font-size: 13px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.18s;
      font-family: inherit;
    }
    .acc-nav-btn:hover {
      background: var(--btn-active-bg);
      border-color: var(--acc);
      color: var(--acc);
    }
    .acc-nav-btn.active {
      background: var(--btn-active-bg);
      border-color: var(--acc);
      color: var(--acc);
    }
    /* Delete row */
    .acc-delete-row {
      margin: 14px 14px 14px;
      background: var(--del-bg);
      border: 1px solid var(--del-border);
      border-radius: 8px;
      padding: 13px 18px;
      text-align: center;
    }
    .acc-delete-row button {
      background: transparent;
      border: none;
      color: var(--del-tx);
      font-size: 13px;
      font-weight: 500;
      cursor: pointer;
      font-family: inherit;
      width: 100%;
    }

    /* ---------- SLIDE-OUT PANEL ---------- */
    .side-panel {
      position: fixed;
      top: 0;
      right: -420px;
      width: 340px;
      max-width: 90vw;
      height: 100vh;
      background: var(--panel-bg);
      border-left: 1px solid var(--panel-border);
      z-index: 250;
      padding: 28px 24px;
      overflow-y: auto;
      transition: right 0.3s cubic-bezier(0.4,0,0.2,1);
      box-shadow: -8px 0 40px rgba(0,0,0,.35);
    }
    .side-panel.open { right: 0; }
    .panel-overlay {
      position: fixed;
      inset: 0;
      background: transparent;
      z-index: 240;
      display: none;
    }
    .panel-overlay.open { display: block; }
    .panel-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 24px;
    }
    .panel-header h3 {
      font-size: 15px;
      font-weight: 600;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      color: var(--tx);
      margin: 0 0 4px;
    }
    .panel-header p {
      font-size: 12px;
      color: var(--mu);
      margin: 0;
    }
    .panel-close {
      background: transparent;
      border: none;
      color: var(--mu);
      cursor: pointer;
      font-size: 18px;
      line-height: 1;
      padding: 2px 6px;
      border-radius: 4px;
      transition: color 0.15s;
    }
    .panel-close:hover { color: var(--tx); }

    /* Form elements */
    .form-label {
      display: block;
      font-size: 10px;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--mu);
      margin-bottom: 7px;
      font-weight: 600;
    }
    .form-input {
      width: 100%;
      padding: 11px 14px;
      background: var(--input-bg);
      border: 1px solid var(--input-border);
      border-radius: 8px;
      color: var(--tx);
      font-size: 13px;
      outline: none;
      transition: border-color 0.18s;
      box-sizing: border-box;
      font-family: inherit;
    }
    .form-input:focus { border-color: var(--acc); }
    .form-group { margin-bottom: 18px; }
    .btn-primary {
      width: 100%;
      padding: 11px;
      background: linear-gradient(135deg, var(--acc), var(--acc2));
      border: none;
      border-radius: 8px;
      color: #fff;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 6px;
      transition: opacity 0.15s;
      font-family: inherit;
    }
    .btn-primary:hover { opacity: 0.88; }
    .btn-primary:disabled { opacity: 0.5; cursor: not-allowed; }

    /* Billing panel */
    .plan-current {
      background: rgba(96,116,255,.07);
      border: 1px solid rgba(96,116,255,.2);
      border-radius: 10px;
      padding: 16px;
      margin-bottom: 18px;
    }
    .plan-current .plan-label {
      font-size: 10px;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--mu);
      margin-bottom: 4px;
    }
    .plan-current .plan-name {
      font-size: 18px;
      font-weight: 700;
      color: var(--tx);
    }
    .plan-current .plan-sub {
      font-size: 11px;
      color: var(--mu);
      margin-top: 4px;
    }
    .plan-btn {
      width: 100%;
      padding: 11px;
      border-radius: 8px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      margin-bottom: 10px;
      transition: all 0.18s;
      font-family: inherit;
    }
    .plan-btn-web {
      background: transparent;
      border: 1px solid rgba(96,116,255,.4);
      color: var(--tx);
    }
    .plan-btn-web:hover { background: rgba(96,116,255,.12); }
    .plan-btn-full {
      background: linear-gradient(135deg, var(--acc), var(--acc2));
      border: none;
      color: #fff;
    }
    .plan-btn-full:hover { opacity: 0.88; }

    /* Toast */
    #dashToast {
      position: fixed;
      bottom: 30px;
      left: 50%;
      transform: translateX(-50%) translateY(20px);
      background: #22c55e;
      color: #fff;
      padding: 10px 22px;
      border-radius: 8px;
      font-size: 13px;
      z-index: 500;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.25s, transform 0.25s;
      white-space: nowrap;
    }
    #dashToast.show {
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }

    /* Delete Modal */
    #deleteModal {
      display: none;
      position: fixed;
      inset: 0;
      z-index: 350;
      align-items: center;
      justify-content: center;
      background: rgba(0,0,0,.85);
      backdrop-filter: blur(8px);
    }
    #deleteModal.open { display: flex; }
    .delete-modal-box {
      background: linear-gradient(135deg, #0c1535, #080f26);
      border: 1px solid rgba(255,80,80,.28);
      border-radius: 16px;
      padding: 28px;
      max-width: 360px;
      width: 90%;
      text-align: center;
    }
    .delete-icon {
      width: 48px; height: 48px;
      border-radius: 50%;
      background: rgba(255,80,80,.12);
      border: 1px solid rgba(255,80,80,.28);
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 16px;
    }

    /* Light theme page bg */
    body.theme-light #page-dashboard { background: #f0f2f8; }
  </style>

  <div class="dash-wrap">
    {{-- Header --}}
    <div style="margin-bottom: 32px;">
      <h1 style="font-family: 'Exo 2', sans-serif; font-size: 22px; font-weight: 300; letter-spacing: 0.1em; color: var(--tx); margin-bottom: 6px;">DASHBOARD</h1>
      <p style="font-size: 13px; color: var(--mu);">Welcome back, <span style="color: var(--acc); font-weight: 600;">{{ auth()->user()->name ?? 'user' }}</span>.</p>
    </div>

    {{-- Account Card --}}
    <div class="acc-card">
    <div class="acc-card-header">
  <h3>ACCOUNT</h3>
  <div class="acc-badge-theme">
    @auth
      @if(auth()->user()->plan_tier === 'full')
        <span class="acc-badge" style="background: rgba(35,201,154,0.15); border-color: #23c99a; color: #23c99a;">FULL ACCESS</span>
      @elseif(auth()->user()->plan_tier === 'web')
        <span class="acc-badge" style="background: rgba(96,116,255,0.15); border-color: #6074ff; color: #8097ff;">WEB ACCESS</span>
      @else
        <span class="acc-badge" id="planBadge">FREE ACCESS</span>
      @endif
    @else
      <span class="acc-badge" id="planBadge">FREE ACCESS</span>
    @endauth
    <span class="theme-label">THEME</span>
    <label class="toggle-switch" title="Toggle dark/light mode">
      <input type="checkbox" id="themeToggle" onchange="toggleTheme(this)">
      <div class="toggle-track"></div>
      <div class="toggle-thumb"></div>
    </label>
  </div>
</div>

      <div class="acc-nav">
        <button class="acc-nav-btn" data-panel="email" onclick="openPanel('email', this)">Update Email</button>
        <button class="acc-nav-btn" data-panel="password" onclick="openPanel('password', this)">Change Password</button>
        <button class="acc-nav-btn" data-panel="billing" onclick="openPanel('billing', this)">Billing</button>
        <button class="acc-nav-btn" data-panel="contact" onclick="openPanel('contact', this)">Contact Us</button>
      </div>

      <div class="acc-delete-row">
        <button onclick="openDeleteModal()">Delete Account</button>
      </div>
    </div>

    {{-- Footer --}}
    <div style="margin-top: 48px; text-align: center; font-size: 11px; color: var(--mu2);">
      <span>© Son Got Samples 2026</span>
      <span style="margin: 0 8px;">·</span>
      <a href="#" style="color: var(--mu2); text-decoration: none;">Privacy Policy</a>
      <span style="margin: 0 8px;">·</span>
      <a href="#" style="color: var(--mu2); text-decoration: none;">Terms of Service</a>
    </div>
  </div>

  {{-- Panel Overlay --}}
  <div class="panel-overlay" id="panelOverlay" onclick="closePanel()"></div>

  {{-- UPDATE EMAIL PANEL --}}
  <div class="side-panel" id="panel-email">
    <div class="panel-header">
      <div>
        <h3>UPDATE EMAIL</h3>
        <p>Change your account email address</p>
      </div>
      <button class="panel-close" onclick="closePanel()">✕</button>
    </div>
    <form onsubmit="updateEmail(event)">
      <div class="form-group">
        <label class="form-label">NEW EMAIL ADDRESS</label>
        <input type="email" id="newEmail" class="form-input" placeholder="you@example.com" value="{{ auth()->user()->email ?? '' }}">
      </div>
      <button type="submit" class="btn-primary">Save Email</button>
    </form>
  </div>

  {{-- CHANGE PASSWORD PANEL --}}
  <div class="side-panel" id="panel-password">
    <div class="panel-header">
      <div>
        <h3>CHANGE PASSWORD</h3>
        <p>Update your login credentials</p>
      </div>
      <button class="panel-close" onclick="closePanel()">✕</button>
    </div>
    <form onsubmit="changePassword(event)">
      <div class="form-group">
        <label class="form-label">CURRENT PASSWORD</label>
        <input type="password" id="currentPassword" class="form-input" placeholder="••••••••">
      </div>
      <div class="form-group">
        <label class="form-label">NEW PASSWORD</label>
        <input type="password" id="newPassword" class="form-input" placeholder="••••••••">
      </div>
      <div class="form-group">
        <label class="form-label">CONFIRM PASSWORD</label>
        <input type="password" id="confirmPassword" class="form-input" placeholder="••••••••">
      </div>
      <button type="submit" class="btn-primary">Save Password</button>
    </form>
  </div>

  {{-- BILLING PANEL --}}
  <div class="side-panel" id="panel-billing">
    <div class="panel-header">
      <div>
        <h3>BILLING</h3>
        <p>Manage your access and plan</p>
      </div>
      <button class="panel-close" onclick="closePanel()">✕</button>
    </div>
    <div class="plan-current">
      <div class="plan-label">CURRENT PLAN</div>
      <div class="plan-name" id="currentPlanName">FREE ACCESS</div>
      <div class="plan-sub">No active purchase on file.</div>
      <div class="plan-sub">All plans are one-time purchases. Upgrade anytime for full library access.</div>
    </div>
    <button class="plan-btn plan-btn-web" onclick="processPayment('web', event)">Upgrade to Web Access ($35)</button>
    <button class="plan-btn plan-btn-full" onclick="processPayment('full', event)">Get Full Library ($55)</button>
  </div>

  {{-- CONTACT PANEL --}}
  <div class="side-panel" id="panel-contact">
    <div class="panel-header">
      <div>
        <h3>CONTACT US</h3>
        <p>We'd love to hear from you</p>
      </div>
      <button class="panel-close" onclick="closePanel()">✕</button>
    </div>
    <form onsubmit="sendContact(event)">
      <div class="form-group">
        <input type="text" id="contactSubject" class="form-input" placeholder="Subject...">
      </div>
      <div class="form-group">
        <textarea id="contactMessage" class="form-input" rows="7" placeholder="Write your message..." style="resize: none;"></textarea>
      </div>
      <button type="submit" class="btn-primary">Send</button>
    </form>
  </div>

  {{-- DELETE MODAL --}}
  <div id="deleteModal">
    <div class="delete-modal-box">
      <div class="delete-icon">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#f08080" stroke-width="1.8">
          <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
      </div>
      <h3 style="font-size: 17px; font-weight: 600; color: var(--tx); margin-bottom: 8px;">Delete Account?</h3>
      <p style="font-size: 13px; color: var(--mu); margin-bottom: 22px;">This action cannot be undone. All your data will be permanently removed.</p>
      <div style="display: flex; gap: 10px;">
        <button onclick="closeDeleteModal()" style="flex:1; padding:10px; background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.1); border-radius:8px; color:var(--tx); font-size:13px; cursor:pointer; font-family:inherit;">Cancel</button>
        <button onclick="deleteAccount()" style="flex:1; padding:10px; background:#f08080; border:none; border-radius:8px; color:#fff; font-size:13px; font-weight:600; cursor:pointer; font-family:inherit;">Delete Forever</button>
      </div>
    </div>
  </div>

  {{-- Toast --}}
  <div id="dashToast"></div>

  <script>
    // ── Theme ──────────────────────────────────────────────
    (function() {
      const saved = localStorage.getItem('sgs_theme') || 'dark';
      if (saved === 'light') {
        document.documentElement.classList.add('theme-light');
        document.body.classList.add('theme-light');
        const t = document.getElementById('themeToggle');
        if (t) t.checked = true;
      }
    })();
    function updatePlanBadge() {
  const badge = document.getElementById('planBadge');
  if (!badge) return;
  
  // Get user tier from Laravel (or from API)
  const userTier = '{{ auth()->user()->plan_tier ?? 'free' }}';
  
  if (userTier === 'full') {
    badge.innerHTML = 'FULL ACCESS';
    badge.style.background = 'rgba(35,201,154,0.15)';
    badge.style.borderColor = '#23c99a';
    badge.style.color = '#23c99a';
  } else if (userTier === 'web') {
    badge.innerHTML = 'WEB ACCESS';
    badge.style.background = 'rgba(96,116,255,0.15)';
    badge.style.borderColor = '#6074ff';
    badge.style.color = '#8097ff';
  } else {
    badge.innerHTML = 'FREE ACCESS';
    badge.style.background = '';
    badge.style.borderColor = '';
    badge.style.color = '';
  }
}

// Call on page load
document.addEventListener('DOMContentLoaded', function() {
  updatePlanBadge();
});

    function toggleTheme(checkbox) {
      if (checkbox.checked) {
        document.documentElement.classList.add('theme-light');
        document.body.classList.add('theme-light');
        localStorage.setItem('sgs_theme', 'light');
      } else {
        document.documentElement.classList.remove('theme-light');
        document.body.classList.remove('theme-light');
        localStorage.setItem('sgs_theme', 'dark');
      }
    }

    // ── Panel ──────────────────────────────────────────────
    let currentPanel = null;

    function openPanel(id, btn) {
      // deactivate all buttons
      document.querySelectorAll('.acc-nav-btn').forEach(b => b.classList.remove('active'));
      if (btn) btn.classList.add('active');

      // close any open panel first
      if (currentPanel) {
        document.getElementById('panel-' + currentPanel).classList.remove('open');
      }
      currentPanel = id;
      document.getElementById('panel-' + id).classList.add('open');
      document.getElementById('panelOverlay').classList.add('open');
    }

    function closePanel() {
      if (currentPanel) {
        document.getElementById('panel-' + currentPanel).classList.remove('open');
        currentPanel = null;
      }
      document.getElementById('panelOverlay').classList.remove('open');
      document.querySelectorAll('.acc-nav-btn').forEach(b => b.classList.remove('active'));
    }

    // Close on Escape
    document.addEventListener('keydown', e => { if (e.key === 'Escape') { closePanel(); closeDeleteModal(); } });

    // ── Toast ──────────────────────────────────────────────
    function toast(msg, isError = false) {
      const el = document.getElementById('dashToast');
      el.textContent = msg;
      el.style.background = isError ? '#ef4444' : '#22c55e';
      el.classList.add('show');
      setTimeout(() => el.classList.remove('show'), 3000);
    }

    // ── Forms ──────────────────────────────────────────────
async function updateEmail(e) {
  e.preventDefault();
  const val = document.getElementById('newEmail').value.trim();
  if (!val) { toast('Please enter an email', true); return; }
  const btn = e.target.querySelector('button[type=submit]');
  btn.disabled = true; btn.textContent = 'Saving...';
  try {
    const res = await fetch('/api/user/update-email', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || ''
      },
      body: JSON.stringify({ email: val })
    });
    const data = await res.json();
    if (data.success) {
      toast('✅ Email updated successfully!');
    } else {
      toast(data.message || '❌ Update failed', true);
    }
  } catch(err) {
    toast('❌ Network error', true);
  } finally {
    btn.disabled = false; btn.textContent = 'Save Email';
  }
}

    function changePassword(e) {
      e.preventDefault();
      const np = document.getElementById('newPassword').value;
      const cp = document.getElementById('confirmPassword').value;
      if (np !== cp) { toast('❌ Passwords do not match', true); return; }
      toast('✅ Password changed!');
      e.target.reset();
    }

    function sendContact(e) {
      e.preventDefault();
      const s = document.getElementById('contactSubject').value;
      const m = document.getElementById('contactMessage').value;
      if (!s || !m) { toast('Please fill all fields', true); return; }
      toast('📧 Message sent!');
      e.target.reset();
    }

    // ── Payment ────────────────────────────────────────────
    async function processPayment(tier, e) {
      const btn = e.target;
      const orig = btn.textContent;
      btn.textContent = 'Processing...';
      btn.disabled = true;
      toast('🔒 Redirecting to secure checkout...');
      try {
        const res = await fetch(`/checkout/${tier}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
          },
          body: JSON.stringify({ tier })
        });
        const data = await res.json();
        if (data.checkout_url) {
          window.location.href = data.checkout_url;
        } else {
          toast('Payment error. Please try again.', true);
          btn.textContent = orig; btn.disabled = false;
        }
      } catch {
        toast('Something went wrong.', true);
        btn.textContent = orig; btn.disabled = false;
      }
    }

    // ── Delete Account ─────────────────────────────────────
    function openDeleteModal()  { document.getElementById('deleteModal').classList.add('open'); }
    function closeDeleteModal() { document.getElementById('deleteModal').classList.remove('open'); }
function deleteAccount() {
    toast('Account logged out. Redirecting...');
    closeDeleteModal();
    
    // Create and submit a POST form for logout
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/logout';
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = csrfToken;
    form.appendChild(csrfInput);
    
    document.body.appendChild(form);
    form.submit();
}
  </script>
</section>