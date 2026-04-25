/**
 * Son Got Samples — Main JavaScript
 * File: public/js/app.js
 *
 * Yeh file client ki original JS hai lekin real API se connected hai
 * SGS = window.SGS (Laravel se inject hota hai app.blade.php mein)
 */

// ============================================================
// 1. THEME
// ============================================================
(function(){
  const s = localStorage.getItem('sgs_theme');
  if(s === 'light') document.documentElement.classList.add('light');
})();

function applyTheme(dark) {
  document.documentElement.classList.toggle('light', !dark);
  localStorage.setItem('sgs_theme', dark ? 'dark' : 'light');
}

document.addEventListener('DOMContentLoaded', () => {
  const t = document.getElementById('themeToggle');
  if(t) {
    t.checked = !document.documentElement.classList.contains('light');
    t.addEventListener('change', () => applyTheme(t.checked));
  }

  // Flash messages check
  if(window.SGS?.flash?.success) showToast(window.SGS.flash.success, 'success');
  if(window.SGS?.flash?.error)   showToast(window.SGS.flash.error, 'error');
  if(window.SGS?.flash?.info)    showToast(window.SGS.flash.info, 'info');
});

// ============================================================
// 2. NAVIGATION
// ============================================================
const navLinks = document.querySelectorAll('#mainNav a[data-nav]');

function goTo(id) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  const t = document.getElementById('page-' + id);
  if(!t) return;
  t.classList.add('active');
  navLinks.forEach(l => l.classList.toggle('active', l.getAttribute('data-nav') === id));
  window.scrollTo(0, 0);

  // Library page par jaate waqt stems load karo
  if(id === 'library') loadStems();
}

navLinks.forEach(l => l.addEventListener('click', e => {
  e.preventDefault();
  goTo(l.getAttribute('data-nav'));
}));

document.getElementById('brandBtn')?.addEventListener('click', () => goTo('home'));

document.addEventListener('click', e => {
  const el = e.target.closest('[data-nav]');
  if(!el || el.closest('#mainNav')) return;
  e.preventDefault();
  goTo(el.getAttribute('data-nav'));
});

document.getElementById('dashLink')?.addEventListener('click', () => goTo('dashboard'));

// ============================================================
// 3. MODALS
// ============================================================
function openModal(id) {
  const el = document.getElementById(id);
  if(el) el.style.display = 'flex';
}

function closeModal(id) {
  const el = document.getElementById(id);
  if(!el) return;
  el.style.transition = 'opacity .18s';
  el.style.opacity = '0';
  setTimeout(() => { el.style.display = 'none'; el.style.opacity = ''; }, 200);
}

document.addEventListener('click', e => {
  const c = e.target.closest('[data-close]');
  if(c) closeModal(c.getAttribute('data-close'));
  const m = e.target.closest('[data-modal]');
  if(m) { e.preventDefault(); openModal(m.getAttribute('data-modal')); }
  if(e.target.classList.contains('modal-backdrop')) closeModal(e.target.id);
});

// ============================================================
// 4. AUTH MODAL — Login/Register toggle
// ============================================================
let isSignUp = true;

document.getElementById('loginLink')?.addEventListener('click', () => {
  isSignUp = false;
  updateAuthModal();
  openModal('authModal');
});

document.getElementById('signupLink')?.addEventListener('click', () => {
  isSignUp = true;
  updateAuthModal();
  openModal('authModal');
});

function updateAuthModal() {
  const title = document.getElementById('authTitle');
  const registerForm = document.getElementById('registerForm');
  const loginForm = document.getElementById('loginForm');
  const emailForms = document.getElementById('emailAuthForm');
  const swapText = document.getElementById('authSwap');
  const swapLink = document.getElementById('authSwapLink');

  if(title) title.textContent = isSignUp ? 'Sign Up' : 'Sign In';
  if(swapText) swapText.innerHTML = isSignUp
    ? 'Already have an account? <a id="authSwapLink" style="color:var(--acc);cursor:pointer;">Sign in</a>'
    : 'Don\'t have an account? <a id="authSwapLink" style="color:var(--acc);cursor:pointer;">Sign up</a>';

  if(emailForms && emailForms.style.display !== 'none') {
    if(registerForm) registerForm.style.display = isSignUp ? 'block' : 'none';
    if(loginForm) loginForm.style.display = isSignUp ? 'none' : 'block';
  }

  // Re-bind swap link
  setTimeout(() => {
    const newLink = document.getElementById('authSwapLink');
    if(newLink) newLink.addEventListener('click', e => {
      e.preventDefault();
      isSignUp = !isSignUp;
      updateAuthModal();
    });
  }, 50);
}

// Email button toggle
document.getElementById('emailAuthBtn')?.addEventListener('click', () => {
  const emailAuthForm = document.getElementById('emailAuthForm');
  const registerForm = document.getElementById('registerForm');
  const loginForm = document.getElementById('loginForm');

  if(emailAuthForm) {
    const isHidden = emailAuthForm.style.display === 'none' || !emailAuthForm.style.display;
    emailAuthForm.style.display = isHidden ? 'block' : 'none';
    if(isHidden) {
      if(registerForm) registerForm.style.display = isSignUp ? 'block' : 'none';
      if(loginForm) loginForm.style.display = isSignUp ? 'none' : 'block';
    }
  }
});

// Sign in to purchase
document.getElementById('sitpSignIn')?.addEventListener('click', () => {
  closeModal('signInToPurchaseModal');
  isSignUp = false;
  updateAuthModal();
  openModal('authModal');
});
document.getElementById('sitpSignUp')?.addEventListener('click', () => {
  closeModal('signInToPurchaseModal');
  isSignUp = true;
  updateAuthModal();
  openModal('authModal');
});

// ============================================================
// 5. PAYMENT — Stripe Checkout (real redirect)
// ============================================================
function authThenCheckout(tier) {
  if(window.SGS?.loggedIn) {
    // Direct Stripe checkout redirect
    const url = tier === 'web'
      ? window.SGS.routes.checkoutWeb
      : window.SGS.routes.checkoutFull;
    window.location.href = url;
  } else {
    openModal('signInToPurchaseModal');
  }
}

document.getElementById('heroFullAccess')?.addEventListener('click', () => goTo('pricing'));
document.getElementById('heroStartFree')?.addEventListener('click', () => goTo('library'));
document.getElementById('priceFreeBtn')?.addEventListener('click', () => goTo('library'));

document.getElementById('priceWebBtn')?.addEventListener('click', () => authThenCheckout('web'));
document.getElementById('priceFullBtn')?.addEventListener('click', () => authThenCheckout('full'));

document.getElementById('topUnlockBtn')?.addEventListener('click', () => {
  const tier = window.SGS?.userTier;
  if(tier === 'full_library') return;
  if(tier === 'web_access') authThenCheckout('full');
  else authThenCheckout('web');
});

document.getElementById('paySuccessGoLib')?.addEventListener('click', () => {
  closeModal('paySuccessModal');
  goTo('library');
});

// ============================================================
// 6. LIBRARY — Real API se stems load karo
// ============================================================
let currentCat = 'Acapella';
let currentPage = 1;
let currentSearch = '';
let currentSort = 'recent';
let stemsData = [];
let totalPages = 1;
const PER_PAGE = 50;

// Active playing track
let activeStemId = null;
let isPlaying = false;
let progressPct = 0;
let activeAudio = null; // Real HTML5 Audio object

async function loadStems() {
  const tbody = document.getElementById('stemTbody');
  if(tbody) tbody.innerHTML = '<tr><td colspan="8" style="text-align:center;padding:40px;color:var(--mu);">Loading stems...</td></tr>';

  try {
    const params = new URLSearchParams({
      type: currentCat,
      page: currentPage,
      sort: currentSort,
    });
    if(currentSearch) params.append('search', currentSearch);

    const res = await fetch(`${window.SGS.routes.stems}?${params}`, {
      headers: {
        'X-CSRF-TOKEN': window.SGS.csrfToken,
        'Accept': 'application/json',
      }
    });

    if(!res.ok) throw new Error('Failed to load stems');

    const data = await res.json();
    stemsData = data.data || [];
    totalPages = data.last_page || 1;

    renderStems();
    renderPagination(data.total || 0);

  } catch(err) {
    console.error('Stems load error:', err);
    if(tbody) tbody.innerHTML = '<tr><td colspan="8" style="text-align:center;padding:40px;color:#e05050;">Failed to load stems. Please refresh.</td></tr>';
  }
}

function getBadgeClass(type) {
  return { 'Acapella':'sa', 'Drums':'sd', 'Bass':'sb2', 'Melody':'sm', 'Instrumental':'si2' }[type] || 'sa';
}

function renderStems() {
  const tbody = document.getElementById('stemTbody');
  if(!tbody) return;
  tbody.innerHTML = '';

  if(!stemsData.length) {
    tbody.innerHTML = '<tr><td colspan="8" style="text-align:center;padding:40px;color:var(--mu);">No stems found.</td></tr>';
    return;
  }

  stemsData.forEach(stem => {
    const isLocked = !stem.is_free && !stem.is_accessible;
    const isActive = stem.id === activeStemId;
    const tr = document.createElement('tr');
    if(isActive) tr.classList.add('is-playing');
    if(isLocked) tr.classList.add('is-locked');

    tr.innerHTML = `
      <td class="col-p">${isLocked
        ? `<div class="lock-ico"><svg viewBox="0 0 12 14" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="6" width="8" height="7" rx="1.2"/><path d="M4 6V4.5a2 2 0 0 1 4 0V6"/></svg></div>`
        : `<button class="play-btn${isActive && isPlaying ? ' ia' : ''}" data-pid="${stem.id}">
             <svg class="pp" viewBox="0 0 10 12"><path d="M1 1l8 5-8 5z"/></svg>
             <svg class="pa" viewBox="0 0 10 12"><rect x="1" y="1" width="3" height="10" rx=".8"/><rect x="6" y="1" width="3" height="10" rx=".8"/></svg>
           </button>`
      }</td>
      <td class="col-ti"><div class="trk-title">${stem.title}</div></td>
      <td class="col-ar"><span class="trk-art">${stem.artist}</span></td>
      <td class="col-ty"><span class="sbadge ${getBadgeClass(stem.stem_type)}">${stem.stem_type}</span></td>
      <td class="col-bpm"><span class="bpm-val">${isLocked ? '—' : (stem.bpm || '—')}</span></td>
      <td class="col-key"><span class="key-val">${isLocked ? '—' : (stem.musical_key || '—')}</span></td>
      <td class="col-gen"><span class="gen-val">${stem.genre || '—'}</span></td>
      <td class="col-dl">${isLocked
        ? `<button class="unlock-row-btn" data-unlock="1">
             <svg width="9" height="9" viewBox="0 0 12 14" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="6" width="8" height="7" rx="1.2"/><path d="M4 6V4.5a2 2 0 0 1 4 0V6"/></svg>
             Unlock
           </button>`
        : `<button class="dl-btn" data-did="${stem.id}">
             <svg width="9" height="9" viewBox="0 0 12 13" fill="currentColor"><path d="M5.25 1v7.19L3.03 5.97l-1.06 1.06L6 11.06l4.03-4.03-1.06-1.06-2.22 2.22V1zM1 12h10v1H1z"/></svg>
             Download
           </button>`
      }</td>`;
    tbody.appendChild(tr);
  });
}

// Table click events
document.getElementById('stemTbody')?.addEventListener('click', async e => {
  const pb = e.target.closest('.play-btn');
  const db = e.target.closest('.dl-btn');
  const ub = e.target.closest('[data-unlock]');

  if(ub) { goTo('pricing'); return; }

  if(pb) {
    const id = parseInt(pb.getAttribute('data-pid'));
    const stem = stemsData.find(s => s.id === id);
    if(!stem) return;
    await playStem(stem);
  }

  if(db) {
    const id = parseInt(db.getAttribute('data-did'));
    const stem = stemsData.find(s => s.id === id);
    if(stem) await downloadStem(stem);
  }
});

// ── Play Stem ──
async function playStem(stem) {
  try {
    // Preview URL lao
    const previewUrl = window.SGS.routes.stemPreview.replace('{id}', stem.id);
    const res = await fetch(previewUrl, {
      headers: { 'X-CSRF-TOKEN': window.SGS.csrfToken, 'Accept': 'application/json' }
    });
    const data = await res.json();

    if(activeStemId === stem.id) {
      // Same track — toggle play/pause
      isPlaying = !isPlaying;
      if(activeAudio) {
        isPlaying ? activeAudio.play() : activeAudio.pause();
      }
    } else {
      // New track
      if(activeAudio) activeAudio.pause();
      activeStemId = stem.id;
      isPlaying = true;
      progressPct = 0;

      activeAudio = new Audio(data.stream_url);
      activeAudio.play();

      // Player bar update
      document.getElementById('pTitle').textContent = stem.title;
      document.getElementById('pArtist').textContent = `${stem.artist} · ${stem.genre}`;

      // Audio events
      activeAudio.addEventListener('timeupdate', () => {
        const pct = activeAudio.currentTime / (activeAudio.duration || 1);
        document.getElementById('pFill').style.width = (pct * 100) + '%';
        document.getElementById('pCur').textContent = formatTime(activeAudio.currentTime);
        document.getElementById('pTotal').textContent = formatTime(activeAudio.duration || 0);
      });
      activeAudio.addEventListener('ended', () => {
        isPlaying = false;
        syncPlay();
        renderStems();
      });
    }

    syncPlay();
    renderStems();
  } catch(err) {
    showToast('Could not load preview.', 'error');
  }
}

function syncPlay() {
  document.getElementById('playBtn')?.classList.toggle('playing', isPlaying);
}

function formatTime(seconds) {
  const s = Math.floor(seconds) || 0;
  return Math.floor(s / 60) + ':' + String(s % 60).padStart(2, '0');
}

// Player controls
document.getElementById('playBtn')?.addEventListener('click', () => {
  if(!activeStemId || !activeAudio) return;
  isPlaying = !isPlaying;
  isPlaying ? activeAudio.play() : activeAudio.pause();
  syncPlay();
});

document.getElementById('prevBtn')?.addEventListener('click', () => {
  const idx = stemsData.findIndex(s => s.id === activeStemId);
  if(idx > 0) playStem(stemsData[idx - 1]);
});

document.getElementById('nextBtn')?.addEventListener('click', () => {
  const idx = stemsData.findIndex(s => s.id === activeStemId);
  if(idx < stemsData.length - 1) playStem(stemsData[idx + 1]);
});

// ── Download Stem ──
async function downloadStem(stem) {
  try {
    const downloadUrl = window.SGS.routes.stemDownload.replace('{id}', stem.id);
    const res = await fetch(downloadUrl, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': window.SGS.csrfToken,
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    });

    const data = await res.json();

    if(!data.success) {
      if(data.show_register) { openModal('dlLimitModal'); return; }
      if(data.require_upgrade) { goTo('pricing'); return; }
      if(data.cooldown_seconds) { showCooldownModal(data); return; }
      showToast(data.message || 'Download failed.', 'error');
      return;
    }

    // Real file download
    const a = document.createElement('a');
    a.href = data.download_url;
    a.download = data.filename || stem.title;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);

    showToast(`Downloading: ${stem.title}`);

  } catch(err) {
    showToast('Download failed. Please try again.', 'error');
  }
}

// ── Search / Sort / Category ──
document.getElementById('catRow')?.addEventListener('click', e => {
  const p = e.target.closest('.cat-pill');
  if(!p) return;
  document.querySelectorAll('.cat-pill').forEach(x => x.classList.remove('active'));
  p.classList.add('active');
  currentCat = p.getAttribute('data-cat');
  currentPage = 1;
  loadStems();
});

let searchTimer;
document.getElementById('stemSearch')?.addEventListener('input', e => {
  clearTimeout(searchTimer);
  searchTimer = setTimeout(() => {
    currentSearch = e.target.value.trim();
    currentPage = 1;
    loadStems();
  }, 400);
});

document.getElementById('stemSort')?.addEventListener('change', e => {
  currentSort = e.target.value;
  currentPage = 1;
  loadStems();
});

// ── Pagination ──
function renderPagination(total) {
  const tp = Math.ceil(total / PER_PAGE) || 1;
  totalPages = tp;

  ['pagination', 'paginationTop'].forEach(id => {
    const el = document.getElementById(id);
    if(!el) return;
    el.innerHTML = '';
    if(tp <= 1) return;

    const prev = document.createElement('button');
    prev.className = 'pag-arr';
    prev.textContent = '←';
    prev.disabled = currentPage <= 1;
    prev.addEventListener('click', () => { if(currentPage > 1) { currentPage--; loadStems(); } });
    el.appendChild(prev);

    const start = Math.max(1, currentPage - 3);
    const end = Math.min(tp, currentPage + 3);

    for(let i = start; i <= end; i++) {
      const b = document.createElement('button');
      b.className = 'pag-num' + (i === currentPage ? ' active' : '');
      b.textContent = i;
      const _i = i;
      b.addEventListener('click', () => { currentPage = _i; loadStems(); });
      el.appendChild(b);
    }

    const next = document.createElement('button');
    next.className = 'pag-arr';
    next.textContent = '→';
    next.disabled = currentPage >= tp;
    next.addEventListener('click', () => { if(currentPage < tp) { currentPage++; loadStems(); } });
    el.appendChild(next);
  });
}

// ============================================================
// 7. DOWNLOAD RATE LIMIT — server se aata hai response mein
// ============================================================
function showCooldownModal(data) {
  document.getElementById('cooldownTitle').textContent = 'Too Many Downloads';
  document.getElementById('cooldownMsg').textContent = data.message || 'Please wait before downloading more.';
  document.getElementById('cooldownLabel').textContent = 'Available again in';

  const cooldownEnd = Date.now() + (data.cooldown_seconds * 1000);
  openModal('cooldownModal');

  const interval = setInterval(() => {
    const rem = Math.max(0, cooldownEnd - Date.now());
    const m = Math.floor(rem / 60000);
    const s = Math.floor((rem % 60000) / 1000);
    const el = document.getElementById('cooldownTimer');
    if(el) el.textContent = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
    if(rem <= 0) { clearInterval(interval); closeModal('cooldownModal'); }
  }, 1000);
}

document.getElementById('cooldownUpgradeBtn')?.addEventListener('click', () => {
  closeModal('cooldownModal');
  authThenCheckout('web');
});

// DL Limit modal buttons
document.getElementById('dlLimitSignup')?.addEventListener('click', () => {
  closeModal('dlLimitModal');
  isSignUp = true;
  updateAuthModal();
  openModal('authModal');
});
document.getElementById('dlLimitFullAccess')?.addEventListener('click', () => {
  closeModal('dlLimitModal');
  goTo('pricing');
});

// ============================================================
// 8. CONTACT FORM — Real API call
// ============================================================
document.getElementById('contactForm')?.addEventListener('submit', async e => {
  e.preventDefault();
  const subject = document.getElementById('contactSubject').value.trim();
  const message = document.getElementById('contactMessage').value.trim();

  if(!subject || !message) { showToast('Please fill in all fields.', 'error'); return; }

  try {
    const res = await fetch(window.SGS.routes.contact, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': window.SGS.csrfToken,
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify({ subject, message })
    });

    const data = await res.json();
    if(data.success) {
      showToast('Message sent! We\'ll get back to you within 1-2 days.');
      document.getElementById('contactSubject').value = '';
      document.getElementById('contactMessage').value = '';
      closeModal('contactModal');
    } else {
      showToast(data.message || 'Failed to send.', 'error');
    }
  } catch(err) {
    showToast('Failed to send message.', 'error');
  }
});

// ============================================================
// 9. SIDE DRAWER
// ============================================================
const sideDrawer = document.getElementById('sideDrawer');

function openDrawer(title, sub, html) {
  document.getElementById('sdTitle').textContent = title;
  document.getElementById('sdSub').textContent = sub;
  document.getElementById('sdContent').innerHTML = html;
  sideDrawer.classList.add('open');
  sideDrawer.setAttribute('aria-hidden', 'false');
}

function closeDrawer() {
  sideDrawer.classList.remove('open');
  sideDrawer.setAttribute('aria-hidden', 'true');
}

document.getElementById('sdClose')?.addEventListener('click', closeDrawer);

// Dashboard actions
document.getElementById('btnUpdateEmail')?.addEventListener('click', () => {
  openDrawer('Update Email', 'Change your account email address', `
    <div style="margin-bottom:10px;">
      <label class="fl">New email address</label>
      <input type="email" id="sdEmailInput" class="input" placeholder="you@example.com"/>
    </div>
    <button class="btn btn-accent" style="width:100%;height:38px;font-size:13px;" id="sdSaveEmail">Save Email</button>
  `);
  setTimeout(() => {
    document.getElementById('sdSaveEmail')?.addEventListener('click', async () => {
      const email = document.getElementById('sdEmailInput').value.trim();
      if(!email) return;
      const res = await fetch('/account/email', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': window.SGS.csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({ email })
      });
      const data = await res.json();
      showToast(data.message || 'Email updated!');
      if(data.success) closeDrawer();
    });
  }, 50);
});

document.getElementById('btnChangePwd')?.addEventListener('click', () => {
  openDrawer('Change Password', 'Update your login credentials', `
    <div style="margin-bottom:9px;"><label class="fl">Current password</label><input type="password" id="sdPwdCur" class="input"/></div>
    <div style="margin-bottom:9px;"><label class="fl">New password</label><input type="password" id="sdPwdNew" class="input"/></div>
    <div style="margin-bottom:14px;"><label class="fl">Confirm password</label><input type="password" id="sdPwdConf" class="input"/></div>
    <button class="btn btn-accent" style="width:100%;height:38px;font-size:13px;" id="sdSavePwd">Save Password</button>
  `);
  setTimeout(() => {
    document.getElementById('sdSavePwd')?.addEventListener('click', async () => {
      const cur = document.getElementById('sdPwdCur').value;
      const n1  = document.getElementById('sdPwdNew').value;
      const n2  = document.getElementById('sdPwdConf').value;
      if(!n1 || n1 !== n2) { showToast('Passwords do not match.', 'error'); return; }
      const res = await fetch('/account/password', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': window.SGS.csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({ current_password: cur, password: n1, password_confirmation: n2 })
      });
      const data = await res.json();
      showToast(data.message || 'Password updated!');
      if(data.success) closeDrawer();
    });
  }, 50);
});

document.getElementById('btnBilling')?.addEventListener('click', () => {
  const tier = window.SGS?.userTier;
  const tierNames = { free: 'Free Access', web_access: 'Web Access', full_library: 'Full Download Package' };
  openDrawer('Billing', 'Manage your access and plan', `
    <div style="background:rgba(96,116,255,.07);border:1px solid rgba(96,116,255,.17);border-radius:10px;padding:14px;margin-bottom:14px;">
      <div style="font-size:10px;text-transform:uppercase;letter-spacing:.1em;color:var(--acc);margin-bottom:4px;">Current Plan</div>
      <div style="font-family:'Exo 2';font-size:1.15rem;text-transform:uppercase;color:var(--tx);">${tierNames[tier] || 'Free Access'}</div>
    </div>
    ${tier === 'full_library' ? '<p style="font-size:13px;color:var(--mu);">You own the full library. Nothing else to purchase.</p>' : `
    <button class="btn btn-accent" style="width:100%;height:38px;font-size:13px;margin-bottom:8px;" id="billingUpgradeBtn">
      ${tier === 'web_access' ? 'Upgrade to Full Library ($20)' : 'Upgrade to Web Access ($35)'}
    </button>`}
  `);
  setTimeout(() => {
    document.getElementById('billingUpgradeBtn')?.addEventListener('click', () => {
      closeDrawer();
      authThenCheckout(tier === 'web_access' ? 'full' : 'web');
    });
  }, 50);
});

// Delete account
document.getElementById('deleteBtn')?.addEventListener('click', () => openModal('deleteModal'));

// ============================================================
// 10. ADMIN PANEL — Real API calls
// ============================================================
document.getElementById('adminViewSiteBtn')?.addEventListener('click', () => {
  document.getElementById('page-admin').style.display = 'none';
});

// Admin tabs
document.querySelectorAll('.admin-tab').forEach(tab => {
  tab.addEventListener('click', () => {
    document.querySelectorAll('.admin-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.admin-pane').forEach(p => p.classList.remove('active'));
    tab.classList.add('active');
    const pane = document.getElementById('adminPane-' + tab.getAttribute('data-atab'));
    if(pane) pane.classList.add('active');

    // Load data when tab switched
    if(tab.getAttribute('data-atab') === 'customers') loadAdminCustomers();
    if(tab.getAttribute('data-atab') === 'stems') loadAdminStems();
  });
});

// ── Admin Customers ──
let adminCustPage = 1;
let selectedUserIds = [];

async function loadAdminCustomers() {
  const search = document.getElementById('adminCustSearch')?.value || '';
  const filter = document.getElementById('adminCustFilter')?.value || '';
  const tbody = document.getElementById('adminCustTbody');

  try {
    const params = new URLSearchParams({ page: adminCustPage, search, tier: filter });
    const res = await fetch(`/admin/api/customers?${params}`, {
      headers: { 'X-CSRF-TOKEN': window.SGS.csrfToken, 'Accept': 'application/json' }
    });
    const data = await res.json();
    renderAdminCustomers(data.data || []);
  } catch(err) {
    if(tbody) tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;padding:20px;color:#e05050;">Failed to load customers.</td></tr>';
  }
}

function tierBadgeHtml(tier) {
  if(tier === 'free') return '<span class="tier-badge tier-free">Free</span>';
  if(tier === 'web_access') return '<span class="tier-badge tier-web">Web Access</span>';
  return '<span class="tier-badge tier-full">Full Download</span>';
}

function renderAdminCustomers(customers) {
  const tbody = document.getElementById('adminCustTbody');
  if(!tbody) return;
  tbody.innerHTML = '';

  customers.forEach(c => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td><input type="checkbox" class="admin-check cust-check" value="${c.id}"/></td>
      <td style="font-size:13px;">${c.email}</td>
      <td style="font-size:13px;color:var(--mu);">${c.name || '—'}</td>
      <td>${tierBadgeHtml(c.plan_tier)}</td>
      <td style="font-size:13px;color:var(--mu);">${c.created_at?.split('T')[0] || '—'}</td>
      <td>
        <div class="admin-actions">
          <button class="aact del" title="Suspend" data-suspend="${c.id}">
            <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6">
              <circle cx="8" cy="8" r="6"/><path d="M6 6l4 4M10 6l-4 4"/>
            </svg>
          </button>
        </div>
      </td>`;
    tbody.appendChild(tr);
  });

  // Checkbox selection tracking
  document.querySelectorAll('.cust-check').forEach(cb => {
    cb.addEventListener('change', () => {
      selectedUserIds = Array.from(document.querySelectorAll('.cust-check:checked')).map(c => parseInt(c.value));
      const emailBtn = document.getElementById('adminEmailSelectedBtn');
      if(emailBtn) emailBtn.style.display = selectedUserIds.length > 0 ? 'flex' : 'none';
    });
  });
}

// Select all customers
document.getElementById('custCheckAll')?.addEventListener('change', e => {
  document.querySelectorAll('.cust-check').forEach(cb => cb.checked = e.target.checked);
  selectedUserIds = e.target.checked
    ? Array.from(document.querySelectorAll('.cust-check')).map(c => parseInt(c.value))
    : [];
  const emailBtn = document.getElementById('adminEmailSelectedBtn');
  if(emailBtn) emailBtn.style.display = selectedUserIds.length > 0 ? 'flex' : 'none';
});

// Email selected users
document.getElementById('adminEmailSelectedBtn')?.addEventListener('click', () => {
  if(!selectedUserIds.length) return;
  document.getElementById('emailRecipientCount').textContent = selectedUserIds.length;
  document.getElementById('emailUserIds').value = JSON.stringify(selectedUserIds);
  openModal('sendEmailModal');
});

// Send email form
document.getElementById('sendEmailForm')?.addEventListener('submit', async e => {
  e.preventDefault();
  const subject = document.getElementById('emailSubject').value.trim();
  const body    = document.getElementById('emailBody').value.trim();
  const userIds = JSON.parse(document.getElementById('emailUserIds').value || '[]');

  try {
    const res = await fetch('/admin/email/send', {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': window.SGS.csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
      body: JSON.stringify({ subject, body, user_ids: userIds })
    });
    const data = await res.json();
    showToast(`Sent: ${data.sent}, Failed: ${data.failed}`);
    closeModal('sendEmailModal');
  } catch(err) {
    showToast('Email send failed.', 'error');
  }
});

// ── Admin Stems ──
let adminStemPage = 1;
let selectedStemIds = [];

async function loadAdminStems() {
  const search = document.getElementById('adminStemSearch')?.value || '';
  const type   = document.getElementById('adminStemTypeFilter')?.value || '';
  const sort   = document.getElementById('adminStemSort')?.value || 'recent';
  const tbody  = document.getElementById('adminStemTbody');

  try {
    const params = new URLSearchParams({ page: adminStemPage, search, stem_type: type, sort });
    const res = await fetch(`/admin/api/stems?${params}`, {
      headers: { 'X-CSRF-TOKEN': window.SGS.csrfToken, 'Accept': 'application/json' }
    });
    const data = await res.json();
    renderAdminStems(data.data || []);
    renderAdminStemPag(data.last_page || 1);
  } catch(err) {
    if(tbody) tbody.innerHTML = '<tr><td colspan="9" style="text-align:center;padding:20px;color:#e05050;">Failed to load stems.</td></tr>';
  }
}

function getTypeClass(t) {
  return { Acapella:'atype-acapella', Drums:'atype-drums', Bass:'atype-bass', Melody:'atype-melody', Instrumental:'atype-instrumental' }[t] || 'atype-acapella';
}

function renderAdminStems(stems) {
  const tbody = document.getElementById('adminStemTbody');
  if(!tbody) return;
  tbody.innerHTML = '';

  stems.forEach(stem => {
    const tr = document.createElement('tr');
    if(!stem.is_visible) tr.classList.add('row-hidden');
    tr.innerHTML = `
      <td><input type="checkbox" class="admin-check stem-check" value="${stem.id}"/></td>
      <td style="font-weight:500;font-size:13px;">${stem.title}</td>
      <td style="font-size:13px;color:var(--mu);">${stem.artist}</td>
      <td><span class="atype-badge ${getTypeClass(stem.stem_type)}">${stem.stem_type}</span></td>
      <td style="font-size:13px;">${stem.bpm || '—'}</td>
      <td style="font-size:13px;color:var(--mu);">${stem.musical_key || '—'}</td>
      <td style="font-size:13px;color:var(--mu);">${stem.genre || '—'}</td>
      <td>${!stem.is_visible ? '<span class="astatus-hidden">Hidden</span>' : ''}</td>
      <td>
        <div class="admin-actions">
          <button class="aact" title="Edit" data-edit-stem="${stem.id}" data-stem='${JSON.stringify(stem)}'>
            <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M11.5 2.5a2.12 2.12 0 0 1 3 3L5 15H1v-4z"/></svg>
          </button>
          <button class="aact" title="${stem.is_visible ? 'Hide' : 'Show'}" data-toggle-stem="${stem.id}">
            ${stem.is_visible
              ? `<svg width="12" height="12" viewBox="0 0 20 18" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M1 1l18 16M8.5 3.2A7 7 0 0 1 10 3c6 0 9 6 9 6a16.4 16.4 0 0 1-2.5 3.3M5.2 5.2A16.4 16.4 0 0 0 1 9s3 6 9 6a7 7 0 0 0 4.8-1.8"/></svg>`
              : `<svg width="12" height="12" viewBox="0 0 20 14" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M1 7S4 1 10 1s9 6 9 6-3 6-9 6-9-6-9-6z"/><circle cx="10" cy="7" r="2.5"/></svg>`
            }
          </button>
        </div>
      </td>`;
    tbody.appendChild(tr);
  });
}

// Admin stem table click events
document.getElementById('adminStemTbody')?.addEventListener('click', async e => {
  const editBtn   = e.target.closest('[data-edit-stem]');
  const toggleBtn = e.target.closest('[data-toggle-stem]');

  if(editBtn) {
    const stemData = JSON.parse(editBtn.getAttribute('data-stem'));
    openEditStemModal(stemData);
  }

  if(toggleBtn) {
    const id = parseInt(toggleBtn.getAttribute('data-toggle-stem'));
    await toggleStemVisibility(id);
  }
});

// Edit stem modal
function openEditStemModal(stem) {
  document.getElementById('editStemId').value = stem.id;
  document.getElementById('editStemTitle').value = stem.title;
  document.getElementById('editStemArtist').value = stem.artist;
  document.getElementById('editStemType').value = stem.stem_type;
  document.getElementById('editStemBpm').value = stem.bpm || '';
  document.getElementById('editStemKey').value = stem.musical_key || '';
  document.getElementById('editStemGenre').value = stem.genre || '';
  openModal('editStemModal');
}

document.getElementById('editStemForm')?.addEventListener('submit', async e => {
  e.preventDefault();
  const id = document.getElementById('editStemId').value;
  const payload = {
    title:       document.getElementById('editStemTitle').value,
    artist:      document.getElementById('editStemArtist').value,
    stem_type:   document.getElementById('editStemType').value,
    bpm:         document.getElementById('editStemBpm').value,
    musical_key: document.getElementById('editStemKey').value,
    genre:       document.getElementById('editStemGenre').value,
  };

  try {
    const res = await fetch(`/admin/stems/${id}`, {
      method: 'PUT',
      headers: { 'X-CSRF-TOKEN': window.SGS.csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
      body: JSON.stringify(payload)
    });
    const data = await res.json();
    if(data.success) {
      showToast('Stem updated!');
      closeModal('editStemModal');
      loadAdminStems();
    }
  } catch(err) {
    showToast('Update failed.', 'error');
  }
});

async function toggleStemVisibility(id) {
  try {
    const res = await fetch(`/admin/stems/${id}/visibility`, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': window.SGS.csrfToken, 'Accept': 'application/json' }
    });
    const data = await res.json();
    if(data.success) {
      showToast(data.is_visible ? 'Stem shown.' : 'Stem hidden.');
      loadAdminStems();
    }
  } catch(err) {
    showToast('Toggle failed.', 'error');
  }
}

// Bulk visibility
document.getElementById('adminBulkShowBtn')?.addEventListener('click', () => bulkVisibility(true));
document.getElementById('adminBulkHideBtn')?.addEventListener('click', () => bulkVisibility(false));

async function bulkVisibility(visible) {
  const ids = Array.from(document.querySelectorAll('.stem-check:checked')).map(c => parseInt(c.value));
  if(!ids.length) { showToast('Select stems first.', 'error'); return; }

  try {
    const res = await fetch('/admin/stems/bulk-visibility', {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': window.SGS.csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
      body: JSON.stringify({ stem_ids: ids, visible })
    });
    const data = await res.json();
    showToast(`${data.count} stems ${visible ? 'shown' : 'hidden'}.`);
    loadAdminStems();
  } catch(err) {
    showToast('Bulk action failed.', 'error');
  }
}

// Admin search inputs
let adminSearchTimer;
document.getElementById('adminCustSearch')?.addEventListener('input', () => {
  clearTimeout(adminSearchTimer);
  adminSearchTimer = setTimeout(() => { adminCustPage = 1; loadAdminCustomers(); }, 400);
});
document.getElementById('adminCustFilter')?.addEventListener('change', () => { adminCustPage = 1; loadAdminCustomers(); });
document.getElementById('adminStemSearch')?.addEventListener('input', () => {
  clearTimeout(adminSearchTimer);
  adminSearchTimer = setTimeout(() => { adminStemPage = 1; loadAdminStems(); }, 400);
});
document.getElementById('adminStemTypeFilter')?.addEventListener('change', () => { adminStemPage = 1; loadAdminStems(); });
document.getElementById('adminStemSort')?.addEventListener('change', () => { adminStemPage = 1; loadAdminStems(); });

function renderAdminStemPag(tp) {
  const el = document.getElementById('adminStemPag');
  if(!el) return;
  el.innerHTML = '';
  if(tp <= 1) return;

  const prev = document.createElement('button');
  prev.className = 'pag-arr';
  prev.textContent = '←';
  prev.disabled = adminStemPage <= 1;
  prev.addEventListener('click', () => { if(adminStemPage > 1) { adminStemPage--; loadAdminStems(); } });
  el.appendChild(prev);

  for(let i = Math.max(1, adminStemPage-2); i <= Math.min(tp, adminStemPage+2); i++) {
    const b = document.createElement('button');
    b.className = 'pag-num' + (i === adminStemPage ? ' active' : '');
    b.textContent = i;
    const _i = i;
    b.addEventListener('click', () => { adminStemPage = _i; loadAdminStems(); });
    el.appendChild(b);
  }

  const next = document.createElement('button');
  next.className = 'pag-arr';
  next.textContent = '→';
  next.disabled = adminStemPage >= tp;
  next.addEventListener('click', () => { if(adminStemPage < tp) { adminStemPage++; loadAdminStems(); } });
  el.appendChild(next);
}

// ============================================================
// 11. TOAST NOTIFICATION
// ============================================================
function showToast(msg, type = 'success') {
  let t = document.getElementById('dlToast');
  if(!t) {
    t = document.createElement('div');
    t.id = 'dlToast';
    t.style.cssText = 'position:fixed;bottom:calc(var(--ph)+16px);left:50%;transform:translateX(-50%);border-radius:10px;padding:10px 18px;font-size:13px;z-index:500;transition:opacity .3s;white-space:nowrap;pointer-events:none;box-shadow:0 4px 20px rgba(0,0,0,.4);';
    document.body.appendChild(t);
  }
  const colors = { success: 'rgba(20,30,60,.97)', error: 'rgba(60,10,10,.97)', info: 'rgba(10,30,60,.97)' };
  const borders = { success: 'rgba(96,116,255,.25)', error: 'rgba(220,50,50,.35)', info: 'rgba(50,120,220,.25)' };
  t.style.background = colors[type] || colors.success;
  t.style.border = `1px solid ${borders[type] || borders.success}`;
  t.style.color = '#e8ecff';
  t.textContent = msg;
  t.style.opacity = '1';
  clearTimeout(t._hide);
  t._hide = setTimeout(() => { t.style.opacity = '0'; }, 2800);
}