
<section id="page-pricing" class="page">
  <div class="pw" style="max-width:1060px;margin:0 auto;padding:0 24px 60px;">

    {{-- Hero --}}
    <div class="phero" style="text-align:center;padding:50px 20px 32px;">
      <div class="eyebrow" style="display:inline-block;font-family:'Exo 2';font-size:.65rem;letter-spacing:.18em;text-transform:uppercase;color:var(--acc);border:1px solid rgba(96,116,255,.22);border-radius:20px;padding:5px 16px;background:rgba(96,116,255,.07);margin-bottom:14px;">
        Choose Your Access
      </div>
      <h1 class="phero-h1" style="font-family:'Exo 2';font-weight:200;font-size:clamp(26px,4vw,46px);letter-spacing:.02em;margin:0 0 10px;color:var(--tx);">
        One-Time Access. No Subscriptions.
      </h1>
      <p style="font-size:15px;color:var(--mu);max-width:400px;margin:0 auto;font-weight:300;">
        Pay once, no renewals. Get into the library your way.
      </p>
    </div>

{{-- Pricing Grid --}}
<div class="pricing-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:48px;">

  {{-- TIER 01: Free --}}
  <div class="price-card" style="background:linear-gradient(180deg,var(--pb),var(--pb2));border:1px solid rgba(96,116,255,.15);border-radius:14px;padding:26px 20px 22px;display:flex;flex-direction:column;position:relative;overflow:hidden;transition:all 0.3s ease;">
    <div style="font-family:'Exo 2';font-size:.6rem;letter-spacing:.18em;text-transform:uppercase;color:var(--acc);margin-bottom:7px;">TIER 01</div>
    <div style="font-family:'Exo 2';font-weight:300;font-size:1.2rem;text-transform:uppercase;letter-spacing:.04em;color:var(--tx);">Free Access</div>
    <div style="font-size:2rem;font-weight:700;margin:12px 0 4px;color:var(--tx);letter-spacing:-.02em;">
      $0 <sub style="font-size:.85rem;font-weight:400;color:var(--mu);letter-spacing:0;">/ forever</sub>
    </div>
    <p style="font-size:12.5px;color:var(--mu);line-height:1.6;margin:9px 0 16px;flex:1;">
      Explore a curated selection with no commitment required.
    </p>
    <ul style="list-style:none;padding:0;margin:0 0 20px;">
      <li style="font-size:12px;color:var(--mu);padding:5px 0;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;gap:8px;"><span style="width:5px;height:5px;border-radius:50%;background:var(--acc);opacity:.6;flex-shrink:0;display:inline-block;"></span>Browse a selection of stems</li>
      <li style="font-size:12px;color:var(--mu);padding:5px 0;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;gap:8px;"><span style="width:5px;height:5px;border-radius:50%;background:var(--acc);opacity:.6;flex-shrink:0;display:inline-block;"></span>Preview before downloading</li>
      <li style="font-size:12px;color:var(--mu);padding:5px 0;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;gap:8px;"><span style="width:5px;height:5px;border-radius:50%;background:var(--acc);opacity:.6;flex-shrink:0;display:inline-block;"></span>Samples across all genres</li>
      <li style="font-size:12px;color:var(--mu);padding:5px 0;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;gap:8px;"><span style="width:5px;height:5px;border-radius:50%;background:var(--acc);opacity:.6;flex-shrink:0;display:inline-block;"></span>Limited download quota</li>
    </ul>
    <button id="freeBtn" class="price-btn" 
        onclick="goTo('library')"
        style="width:100%;height:40px;border-radius:9px;font-size:13px;font-weight:600;border:1px solid rgba(96,116,255,.26);background:rgba(96,116,255,.08);color:var(--tx);cursor:pointer;transition:all 0.3s ease;">
        Explore Free Access
    </button>
  </div>

  {{-- TIER 02: Web Access --}}
  <div class="price-card" style="background:linear-gradient(180deg,var(--pb),var(--pb2));border:1px solid rgba(96,116,255,.15);border-radius:14px;padding:26px 20px 22px;display:flex;flex-direction:column;position:relative;overflow:hidden;transition:all 0.3s ease;">
    <div style="font-family:'Exo 2';font-size:.6rem;letter-spacing:.18em;text-transform:uppercase;color:var(--acc);margin-bottom:7px;">TIER 02</div>
    <div style="font-family:'Exo 2';font-weight:300;font-size:1.2rem;text-transform:uppercase;letter-spacing:.04em;color:var(--tx);">Web Access</div>
    <div style="font-size:2rem;font-weight:700;margin:12px 0 4px;color:var(--tx);letter-spacing:-.02em;">
      $35 <sub style="font-size:.85rem;font-weight:400;color:var(--mu);letter-spacing:0;">/ one-time</sub>
    </div>
    <p style="font-size:12.5px;color:var(--mu);line-height:1.6;margin:9px 0 16px;flex:1;">
      Full website library access. Browse, preview, and download all raw stems.
    </p>
    <ul style="list-style:none;padding:0;margin:0 0 20px;">
      <li style="font-size:12px;color:var(--mu);padding:5px 0;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;gap:8px;"><span style="width:5px;height:5px;border-radius:50%;background:var(--acc);opacity:.6;flex-shrink:0;display:inline-block;"></span>Full website library access</li>
      <li style="font-size:12px;color:var(--mu);padding:5px 0;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;gap:8px;"><span style="width:5px;height:5px;border-radius:50%;background:var(--acc);opacity:.6;flex-shrink:0;display:inline-block;"></span>Browse and download all stems</li>
      <li style="font-size:12px;color:var(--mu);padding:5px 0;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;gap:8px;"><span style="width:5px;height:5px;border-radius:50%;background:var(--acc);opacity:.6;flex-shrink:0;display:inline-block;"></span>Filter by genre, BPM, key &amp; type</li>
      <li style="font-size:12px;color:var(--mu);padding:5px 0;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;gap:8px;"><span style="width:5px;height:5px;border-radius:50%;background:var(--acc);opacity:.6;flex-shrink:0;display:inline-block;"></span>One-time, no renewal</li>
    </ul>
<button id="webBtn" class="price-btn" 
    style="width:100%;height:40px;border-radius:9px;font-size:13px;font-weight:600;border:1px solid rgba(96,116,255,.26);background:rgba(96,116,255,.08);color:var(--tx);cursor:pointer;transition:all 0.3s ease;">
    Unlock Web Access
</button>
  </div>

  {{-- TIER 03: Full Download --}}
  <div class="price-card feat" style="background:linear-gradient(180deg,rgba(96,116,255,.07),rgba(96,116,255,.025));border:1px solid rgba(96,116,255,.3);border-radius:14px;padding:26px 20px 22px;display:flex;flex-direction:column;position:relative;overflow:hidden;transition:all 0.3s ease;">
    <div style="position:absolute;top:14px;right:-26px;background:var(--acc);color:#fff;font-size:9px;letter-spacing:.1em;text-transform:uppercase;padding:4px 30px;transform:rotate(45deg);font-weight:700;">Best Value</div>
    <div style="font-family:'Exo 2';font-size:.6rem;letter-spacing:.18em;text-transform:uppercase;color:var(--acc);margin-bottom:7px;">TIER 03</div>
    <div style="font-family:'Exo 2';font-weight:300;font-size:1.2rem;text-transform:uppercase;letter-spacing:.04em;color:var(--tx);">Full Download Package</div>
    <div style="font-size:2rem;font-weight:700;margin:12px 0 4px;color:var(--tx);letter-spacing:-.02em;">
      $55 <sub style="font-size:.85rem;font-weight:400;color:var(--mu);letter-spacing:0;">/ one-time</sub>
    </div>
    <p style="font-size:12.5px;color:var(--mu);line-height:1.6;margin:9px 0 16px;flex:1;">
      Web access plus the complete library. Own 20,000+ stems permanently.
    </p>
    <ul style="list-style:none;padding:0;margin:0 0 20px;">
      <li style="font-size:12px;color:var(--mu);padding:5px 0;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;gap:8px;"><span style="width:5px;height:5px;border-radius:50%;background:var(--acc);opacity:.6;flex-shrink:0;display:inline-block;"></span>Full website library access</li>
      <li style="font-size:12px;color:var(--mu);padding:5px 0;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;gap:8px;"><span style="width:5px;height:5px;border-radius:50%;background:var(--acc);opacity:.6;flex-shrink:0;display:inline-block;"></span>Complete library package delivered</li>
      <li style="font-size:12px;color:var(--mu);padding:5px 0;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;gap:8px;"><span style="width:5px;height:5px;border-radius:50%;background:var(--acc);opacity:.6;flex-shrink:0;display:inline-block;"></span>20,000+ stems, yours forever</li>
      <li style="font-size:12px;color:var(--mu);padding:5px 0;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;gap:8px;"><span style="width:5px;height:5px;border-radius:50%;background:var(--acc);opacity:.6;flex-shrink:0;display:inline-block;"></span>All genres, BPMs, and stem types</li>
      <li style="font-size:12px;color:var(--mu);padding:5px 0;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;gap:8px;"><span style="width:5px;height:5px;border-radius:50%;background:var(--acc);opacity:.6;flex-shrink:0;display:inline-block;"></span>Permanent one-time ownership</li>
    </ul>
<button id="fullBtn" class="price-btn" 
    style="width:100%;height:40px;border-radius:9px;font-size:13px;font-weight:600;background:var(--acc);border:1px solid var(--acc);color:#fff;cursor:pointer;transition:all 0.3s ease;">
    Get Full Library
</button>
  </div>
</div>
  </div>

  @include('partials.footer')

  {{-- Toast --}}
  <div id="pToast" style="display:none;position:fixed;bottom:28px;left:50%;transform:translateX(-50%);padding:12px 24px;border-radius:10px;font-size:13.5px;color:#fff;z-index:500;white-space:nowrap;box-shadow:0 8px 24px rgba(0,0,0,.5);pointer-events:none;"></div>

{{-- Login Modal --}}
<div id="pLoginModal" style="display:none;position:fixed;inset:0;z-index:300;align-items:center;justify-content:center;padding:20px;">
  <div onclick="closePM('pLoginModal')" style="position:absolute;inset:0;background:rgba(2,5,18,.85);backdrop-filter:blur(6px);"></div>
  <div style="position:relative;z-index:1;width:100%;max-width:360px;background:linear-gradient(160deg,#0c1535,#080f26);border:1px solid rgba(96,116,255,.22);border-radius:16px;padding:28px 24px 24px;text-align:center;box-shadow:0 24px 60px rgba(0,0,0,.6);">
    <div style="font-size:36px;margin-bottom:10px;">🔐</div>
    <h3 style="font-family:'Exo 2';font-size:17px;font-weight:600;color:var(--tx);margin:0 0 6px;">Login Required</h3>
    <p style="font-size:12px;color:var(--mu);line-height:1.5;margin:0 0 20px;">Please login or create an account to purchase.</p>
    
    {{-- Buttons Container --}}
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
      <button onclick="closePM('pLoginModal')" style="flex:1;height:38px;border-radius:8px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.12);color:var(--mu);font-size:12px;cursor:pointer;font-family:inherit;white-space:nowrap;">Cancel</button>
      <button onclick="window.location.href='/register'" style="flex:1;height:38px;border-radius:8px;background:linear-gradient(135deg,var(--acc),#4a5ee8);border:none;color:#fff;font-size:12px;font-weight:500;cursor:pointer;font-family:inherit;white-space:nowrap;">Create free account →</button>
    </div>
  </div>
</div>
  {{-- Login Modal --}}
  <div id="pLoginModal" style="display:none;position:fixed;inset:0;z-index:300;align-items:center;justify-content:center;padding:20px;">
    <div onclick="closePM('pLoginModal')" style="position:absolute;inset:0;background:rgba(2,5,18,.85);backdrop-filter:blur(6px);"></div>
    <div style="position:relative;z-index:1;width:100%;max-width:360px;background:linear-gradient(160deg,#0c1535,#080f26);border:1px solid rgba(96,116,255,.22);border-radius:16px;padding:32px 28px 26px;text-align:center;box-shadow:0 24px 60px rgba(0,0,0,.6);">
      <div style="font-size:36px;margin-bottom:12px;">🔐</div>
      <h3 style="font-family:'Exo 2';font-size:17px;font-weight:600;color:var(--tx);margin:0 0 8px;">Login Required</h3>
      <p style="font-size:13px;color:var(--mu);line-height:1.6;margin:0 0 22px;">Please login or create an account to purchase.</p>
      <div style="display:flex;gap:10px;">
        <button onclick="closePM('pLoginModal')" style="flex:1;height:40px;border-radius:9px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.12);color:var(--mu);font-size:13px;cursor:pointer;font-family:inherit;">Cancel</button>
        <button onclick="window.location.href='/register'" style="flex:1;height:40px;border-radius:9px;background:linear-gradient(135deg,var(--acc),#4a5ee8);border:none;color:#fff;font-size:13px;font-weight:600;cursor:pointer;font-family:inherit;">Create free account instead →</button>
      </div>
    </div>
  </div>


  {{-- Confirm Purchase Modal --}}
  <div id="pConfirmModal" style="display:none;position:fixed;inset:0;z-index:300;align-items:center;justify-content:center;padding:20px;">
    <div onclick="closePM('pConfirmModal')" style="position:absolute;inset:0;background:rgba(2,5,18,.85);backdrop-filter:blur(6px);"></div>
    <div style="position:relative;z-index:1;width:100%;max-width:380px;background:linear-gradient(160deg,#0c1535,#080f26);border:1px solid rgba(96,116,255,.22);border-radius:16px;padding:32px 28px 26px;text-align:center;box-shadow:0 24px 60px rgba(0,0,0,.6);">
      <div id="pmIcon"  style="font-size:36px;margin-bottom:12px;"></div>
      <h3 id="pmTitle" style="font-family:'Exo 2';font-size:17px;font-weight:600;color:var(--tx);margin:0 0 6px;"></h3>
      <p  id="pmDesc"  style="font-size:13px;color:var(--mu);line-height:1.6;margin:0 0 24px;"></p>
      <div style="display:flex;gap:10px;">
        <button onclick="closePM('pConfirmModal')" style="flex:1;height:40px;border-radius:9px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.12);color:var(--mu);font-size:13px;cursor:pointer;font-family:inherit;">Cancel</button>
        <button id="pmOkBtn" style="flex:1;height:40px;border-radius:9px;background:linear-gradient(135deg,var(--acc),#4a5ee8);border:none;color:#fff;font-size:13px;font-weight:600;cursor:pointer;font-family:inherit;"></button>
      </div>
    </div>
  </div>

  {{-- Already Owned Modal --}}
  <div id="pOwnedModal" style="display:none;position:fixed;inset:0;z-index:300;align-items:center;justify-content:center;padding:20px;">
    <div onclick="closePM('pOwnedModal')" style="position:absolute;inset:0;background:rgba(2,5,18,.85);backdrop-filter:blur(6px);"></div>
    <div style="position:relative;z-index:1;width:100%;max-width:400px;background:linear-gradient(160deg,#0c1535,#080f26);border:1px solid rgba(35,201,154,.25);border-radius:18px;padding:36px 32px 28px;text-align:center;box-shadow:0 32px 80px rgba(0,0,0,.7);">
      <div style="width:68px;height:68px;border-radius:50%;background:rgba(35,201,154,.12);border:1px solid rgba(35,201,154,.3);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#23c99a" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
      </div>
      <h3 id="pmOwnTitle" style="font-family:'Exo 2';font-size:19px;font-weight:600;color:var(--tx);margin:0 0 10px;"></h3>
      <p  id="pmOwnDesc"  style="font-size:13.5px;color:var(--mu);line-height:1.7;margin:0 0 6px;"></p>
      <p  id="pmOwnSub"   style="font-size:12px;color:var(--mu2);margin:0 0 26px;"></p>
      <div style="display:flex;gap:10px;">
        <button onclick="goTo('library');closePM('pOwnedModal')" style="flex:1;height:40px;border-radius:9px;background:rgba(35,201,154,.12);border:1px solid rgba(35,201,154,.25);color:#23c99a;font-size:13px;font-weight:600;cursor:pointer;font-family:inherit;">Go to Library</button>
        <button onclick="closePM('pOwnedModal')" style="flex:1;height:40px;border-radius:9px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);color:var(--mu);font-size:13px;cursor:pointer;font-family:inherit;">Close</button>
      </div>
    </div>
  </div>

  {{-- Processing Modal --}}
  <div id="pProcessingModal" style="display:none;position:fixed;inset:0;z-index:400;align-items:center;justify-content:center;">
    <div style="position:absolute;inset:0;background:rgba(2,5,18,.92);backdrop-filter:blur(8px);"></div>
    <div style="position:relative;z-index:1;text-align:center;">
      <div style="width:48px;height:48px;border:3px solid rgba(96,116,255,.2);border-top-color:var(--acc);border-radius:50%;animation:pmspin .7s linear infinite;margin:0 auto 16px;"></div>
      <p style="font-size:14px;color:var(--mu);">Redirecting to checkout…</p>
    </div>
  </div>
</section>

<style>
  @keyframes pmspin { to { transform:rotate(360deg); } }
  .price-card:hover { transform:translateY(-2px);border-color:rgba(96,116,255,.4) !important; }
  .price-card.feat:hover { border-color:rgba(96,116,255,.6) !important; }
  .price-btn:hover { opacity:.9;transform:translateY(-1px); }
  #pLoginModal[style*="flex"],#pConfirmModal[style*="flex"],
  #pOwnedModal[style*="flex"],#pProcessingModal[style*="flex"] { display:flex !important; }

  @media (max-width:860px) { .pricing-grid { grid-template-columns:1fr !important;max-width:400px;margin-left:auto;margin-right:auto; } }
  @media (max-width:768px) { .pw{padding:0 16px 40px !important;} .phero{padding:30px 16px 20px !important;} .phero-h1{font-size:28px !important;} .price-card{padding:20px 16px !important;} }
  @media (max-width:480px) { .phero-h1{font-size:24px !important;} }

  /* Pricing Card Styles - No White Border */
.price-card {
  background: linear-gradient(180deg, var(--pb), var(--pb2));
  border: 1px solid rgba(96,116,255,.08);  /* Very subtle - almost invisible */
  border-radius: 14px;
  padding: 26px 20px 22px;
  display: flex;
  flex-direction: column;
  position: relative;
  overflow: hidden;
  transition: all 0.3s ease;
}

/* Featured Card - Slightly more visible border */
.price-card.feat {
  background: linear-gradient(180deg, rgba(96,116,255,.07), rgba(96,116,255,.025));
  border: 1px solid rgba(96,116,255,.15);
}

/* Hover Effect - Light Blue Border Appears */
.price-card:hover {
  transform: translateY(-4px);
  border-color: rgba(96,116,255,.5) !important;
  box-shadow: 0 8px 30px rgba(96,116,255,.15);
}

.price-card.feat:hover {
  border-color: rgba(96,116,255,.6) !important;
  box-shadow: 0 8px 35px rgba(96,116,255,.2);
}

/* Button Styles - No White Border */
.price-btn {
  width: 100%;
  height: 40px;
  border-radius: 9px;
  font-size: 13px;
  font-weight: 600;
  border: 1px solid rgba(96,116,255,.2);
  background: rgba(96,116,255,.08);
  color: var(--tx);
  cursor: pointer;
  transition: all 0.3s ease;
}

.price-card.feat .price-btn {
  background: var(--acc);
  border: 1px solid var(--acc);
  color: #fff;
}

/* Button Hover - Light Blue */
.price-btn:hover {
  background: rgba(96,116,255,.2) !important;
  border-color: rgba(96,116,255,.5) !important;
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(96,116,255,.2);
}

.price-card.feat .price-btn:hover {
  background: #7083ff !important;
  border-color: #7083ff !important;
}

/* ========== LOGIN MODAL FIXES ========== */
#pLoginModal .modal-buttons {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

#pLoginModal .modal-buttons button {
  flex: 1;
  min-width: 120px;
  white-space: nowrap;
}

/* Mobile view - buttons stack vertically */
@media (max-width: 480px) {
  #pLoginModal .modal-buttons {
    flex-direction: column;
    gap: 10px;
  }
  
  #pLoginModal .modal-buttons button {
    width: 100%;
    white-space: normal;
    word-break: keep-all;
  }
  
  #pLoginModal > div > div {
    padding: 24px 20px 20px;
    max-width: 320px;
  }
  
  #pLoginModal h3 {
    font-size: 16px;
  }
  
  #pLoginModal p {
    font-size: 12px;
    margin-bottom: 18px;
  }
}

</style>

<script>
(function () {
  // ── Config ───────────────────────────────────────────
  const LOGGED_IN  = {{ auth()->check() ? 'true' : 'false' }};
  const USER_TIER  = '{{ auth()->user()->plan_tier ?? "free" }}';
  const CSRF       = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';

  function openPM(id)  { const m=document.getElementById(id); if(m) m.style.display='flex'; }
  function closePM(id) { const m=document.getElementById(id); if(m) m.style.display='none'; }
  window.closePM = closePM;
  
  function showToast(msg, type) {
    const t = document.getElementById('pToast');
    if (!t) return;
    t.textContent = msg;
    t.style.background = type === 'error' ? '#ef4444' : '#22c55e';
    t.style.display = 'block';
    clearTimeout(t._t);
    t._t = setTimeout(() => { t.style.display='none'; }, 3500);
  }

  // Direct checkout without modal
  async function processDirectCheckout(tier) {
    openPM('pProcessingModal');
    
    try {
      const res = await fetch(`/checkout/${tier}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF }
      });
      const data = await res.json();
      
      if (data.checkout_url) {
        window.location.href = data.checkout_url;
      } else {
        closePM('pProcessingModal');
        showToast(data.error || 'Checkout failed', 'error');
      }
    } catch (e) {
      closePM('pProcessingModal');
      showToast('Something went wrong', 'error');
    }
  }


  // Main handler
  function handlePurchase(tier) {
    if (!LOGGED_IN) { 
      window.location.href = `/register?plan=${tier}`;
      return; 
    }

    if (tier === 'web' && (USER_TIER === 'web' || USER_TIER === 'full')) {
      document.getElementById('pmOwnTitle').textContent = 'Plan Already Purchased!';
      document.getElementById('pmOwnDesc').textContent  = 'You already have Web Access.';
      document.getElementById('pmOwnSub').textContent   = 'Head to the library and start downloading.';
      openPM('pOwnedModal'); 
      return;
    }
    
    if (tier === 'full' && USER_TIER === 'full') {
      document.getElementById('pmOwnTitle').textContent = 'Plan Already Purchased!';
      document.getElementById('pmOwnDesc').textContent  = 'You already own the Full Library Package.';
      document.getElementById('pmOwnSub').textContent   = 'Thank you for your support!';
      openPM('pOwnedModal'); 
      return;
    }

    // Direct checkout for logged in users
    processDirectCheckout(tier);
  }

  // DOM Ready
  document.addEventListener('DOMContentLoaded', function () {
    const freeBtn = document.getElementById('freeBtn');
    const webBtn = document.getElementById('webBtn');
    const fullBtn = document.getElementById('fullBtn');

  freeBtn.addEventListener('click', function(e) {
    window.goTo('library');
  });
    if (webBtn) webBtn.addEventListener('click', () => handlePurchase('web'));
    if (fullBtn) fullBtn.addEventListener('click', () => handlePurchase('full'));

    // Mark owned buttons
    function markOwned(btn, label) {
      if (!btn) return;
      btn.textContent = label;
      btn.style.background = 'rgba(30,185,145,.08)';
      btn.style.borderColor = 'rgba(30,185,145,.25)';
      btn.style.color = '#23c99a';
    }

    if (LOGGED_IN) {
      if (USER_TIER === 'web') {
        markOwned(webBtn, '✓ Web Access Active');
      }
      if (USER_TIER === 'full') {
        markOwned(webBtn, '✓ Included in Plan');
        markOwned(fullBtn, '✓ Full Library Owned');
      }
    }

    // Escape closes modals
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') {
        ['pLoginModal', 'pConfirmModal', 'pOwnedModal', 'pProcessingModal'].forEach(closePM);
      }
    });
  });
})();
</script>