<section id="page-library" class="page">
  <div class="lw" style="max-width:1160px;margin:0 auto;padding:20px 24px calc(var(--ph) + 24px);">

    {{-- Access Strip --}}
    <div class="access-strip" id="accessStrip"
      style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;background:rgba(96,116,255,.055);border:1px solid rgba(96,116,255,.13);border-radius:7px;padding:7px 14px;margin-bottom:12px;">
      <span class="access-strip-txt" style="font-size:12px;color:var(--mu);flex:1;">
        <strong style="color:var(--tx);">Free Access</strong>. Browse a limited selection. Stems past the free limit are locked.
        <span id="downloadCounterDisplay" style="display:inline-block;margin-left:12px;background:rgba(96,116,255,.15);padding:2px 8px;border-radius:20px;font-size:11px;font-weight:600;"></span>
      </span>
    </div>

    {{-- Top Bar --}}
    <div class="lib-topbar" style="display:flex;align-items:center;gap:9px;margin-bottom:12px;flex-wrap:wrap;">
      <input type="search" class="lib-search" id="stemSearch" placeholder="Search stems, artists, genres…"
        style="flex:1;min-width:190px;height:44px;background:rgba(255,255,255,.05);border:1px solid var(--me);border-radius:9px;padding:10px 12px 10px 36px;color:var(--tx);font-size:13px;outline:none;background-image:url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'15\' height=\'15\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'%238f9abf\' stroke-width=\'2.2\'%3E%3Ccircle cx=\'11\' cy=\'11\' r=\'8\'/%3E%3Cpath d=\'m21 21-4.35-4.35\'/%3E%3C/svg%3E');background-repeat:no-repeat;background-position:12px center;">

      <select class="lib-sort" id="stemSort"
        style="height:44px;padding:0 10px;background:rgba(255,255,255,.05);border:1px solid var(--me);border-radius:9px;color:var(--tx);font-size:13px;outline:none;cursor:pointer;min-width:150px;">
        <option value="recent">Most Recent</option>
        <option value="genre">Sort by Genre</option>
        <option value="key">Sort by Key</option>
        <option value="bpmAsc">BPM: Low to High</option>
        <option value="bpmDesc">BPM: High to Low</option>
        <option value="title">Title A to Z</option>
      </select>

<div id="topButtonContainer">
    <button class="lib-unlock-glass" id="topUnlockBtn" onclick="goTo('pricing')">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" style="margin-right:6px;vertical-align:middle;">
            <rect x="3" y="11" width="18" height="11" rx="2"/>
            <path d="M7 11V7a5 5 0 0 1 9.9-1"/>
        </svg>
        Unlock Full Library
    </button>
</div>
    </div>

    {{-- Category Pills --}}
    <div class="cat-row flex flex-wrap gap-1.5 mb-3" id="catRow">
      <button class="cat-pill active" data-cat="Acapella">Acapella</button>
      <button class="cat-pill" data-cat="Drums">Drums</button>
      <button class="cat-pill" data-cat="Bass">Bass</button>
      <button class="cat-pill" data-cat="Melody">Melody</button>
      <button class="cat-pill" data-cat="Instrumental">Instrumental</button>
    </div>

    {{-- Pagination TOP --}}
    <div class="pagination" id="paginationTop"
      style="display:flex;align-items:center;justify-content:flex-end;gap:5px;padding:0 0 10px;flex-wrap:wrap;"></div>

    {{-- Table — mobile scroll fix --}}
  <div class="lib-table-wrap"
  style="background:linear-gradient(180deg,var(--pb),var(--pb2));border:1px solid var(--di);border-radius:12px;">
  <div class="lib-table-scroll">
        <table class="lib-table">
          <thead>
            <tr style="border-bottom:1px solid var(--di);">
              <th style="padding:8px 6px 8px 10px;"></th>
              <th style="padding:8px 10px;text-align:left;font-size:10px;text-transform:uppercase;letter-spacing:.1em;color:var(--mu2);">TITLE</th>
              <th style="padding:8px 10px;text-align:left;font-size:10px;text-transform:uppercase;letter-spacing:.1em;color:var(--mu2);">ARTIST</th>
              <th style="padding:8px 10px;text-align:left;font-size:10px;text-transform:uppercase;letter-spacing:.1em;color:var(--mu2);">TYPE</th>
              <th style="padding:8px 10px;text-align:left;font-size:10px;text-transform:uppercase;letter-spacing:.1em;color:var(--mu2);">BPM</th>
              <th style="padding:8px 10px;text-align:left;font-size:10px;text-transform:uppercase;letter-spacing:.1em;color:var(--mu2);">KEY</th>
              <th style="padding:8px 10px;text-align:left;font-size:10px;text-transform:uppercase;letter-spacing:.1em;color:var(--mu2);">GENRE</th>
              <th style="padding:8px 5px;text-align:right;font-size:10px;text-transform:uppercase;letter-spacing:.1em;color:var(--mu2);">DOWNLOAD</th>
            </tr>
          </thead>
          <tbody id="stemTbody"></tbody>
        </table>
      </div>
    </div>

    {{-- Pagination BOTTOM --}}
    <div class="pagination" id="pagination"
      style="display:flex;align-items:center;justify-content:center;gap:5px;padding:18px 0 6px;flex-wrap:wrap;"></div>
  </div>

  {{-- DOWNLOAD LIMIT MODAL --}}
  <div id="dlLimitModal" style="display:none;position:fixed;inset:0;z-index:200;align-items:center;justify-content:center;padding:20px;">
    <div id="dlLimitBackdrop" onclick="closeDlLimitModal()"
      style="position:absolute;inset:0;background:rgba(2,5,18,.82);backdrop-filter:blur(6px);"></div>
    <div style="position:relative;z-index:1;width:100%;max-width:420px;background:linear-gradient(160deg,#0c1535,#080f26);border:1px solid rgba(96,116,255,.22);border-radius:18px;padding:36px 32px 30px;text-align:center;box-shadow:0 32px 80px rgba(0,0,0,.6);">
      <div style="width:64px;height:64px;border-radius:50%;background:rgba(96,116,255,.12);border:1px solid rgba(96,116,255,.25);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#6074ff" stroke-width="1.8"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
      </div>
      <h2 style="font-size:20px;font-weight:700;color:#e8ecff;margin:0 0 10px;">Daily Limit Reached</h2>
      <p style="font-size:14px;color:#8f9abf;line-height:1.6;margin:0 0 6px;">You've used all <strong>5 free downloads</strong> for today.</p>
      <p style="font-size:13px;color:#6a73a0;margin:0 0 28px;">Create a free account to get more downloads and unlock extra features.</p>
      <div style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.07);border-radius:10px;padding:14px 18px;margin-bottom:26px;text-align:left;">
        <div style="font-size:11px;text-transform:uppercase;letter-spacing:.08em;color:#555e80;margin-bottom:10px;">Free account includes</div>
        <div style="display:flex;flex-direction:column;gap:8px;">
          <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:#b0badf;"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="7.5" stroke="rgba(96,116,255,.3)"/><path d="M5 8l2 2 4-4" stroke="#6074ff" stroke-width="1.5"/></svg>More daily free downloads</div>
          <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:#b0badf;"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="7.5" stroke="rgba(96,116,255,.3)"/><path d="M5 8l2 2 4-4" stroke="#6074ff" stroke-width="1.5"/></svg>Browse full stem catalog</div>
          <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:#b0badf;"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="7.5" stroke="rgba(96,116,255,.3)"/><path d="M5 8l2 2 4-4" stroke="#6074ff" stroke-width="1.5"/></svg>Save favorites &amp; history</div>
        </div>
      </div>
      <a href="/register" style="display:block;width:100%;padding:13px 0;border-radius:10px;background:linear-gradient(135deg,#6074ff,#4a5ee8);color:#fff;font-size:14px;font-weight:700;text-decoration:none;margin-bottom:10px;">Create Free Account</a>
      <a href="/login" style="display:block;width:100%;padding:12px 0;border-radius:10px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);color:#8f9abf;font-size:13px;font-weight:500;text-decoration:none;margin-bottom:18px;">Already have an account? Log in →</a>
      <button onclick="closeDlLimitModal()" style="background:none;border:none;color:#555e80;font-size:12px;cursor:pointer;padding:0;text-decoration:underline;">Continue browsing</button>
    </div>
  </div>

  {{-- RATE LIMIT MODAL --}}
  <div id="cooldownModal" style="display:none;position:fixed;inset:0;z-index:200;align-items:center;justify-content:center;padding:20px;">
    <div onclick="document.getElementById('cooldownModal').style.display='none'"
      style="position:absolute;inset:0;background:rgba(2,5,18,.82);backdrop-filter:blur(6px);"></div>
    <div style="position:relative;z-index:1;width:100%;max-width:380px;background:linear-gradient(160deg,#0c1535,#080f26);border:1px solid rgba(255,165,0,.2);border-radius:18px;padding:34px 28px 28px;text-align:center;">
      <div style="width:60px;height:60px;border-radius:50%;background:rgba(255,165,0,.1);border:1px solid rgba(255,165,0,.25);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ffa500" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </div>
      <h2 style="font-size:19px;font-weight:700;color:#e8ecff;margin:0 0 8px;">Slow Down!</h2>
      <p style="font-size:13px;color:#8f9abf;margin:0 0 20px;">Too many downloads at once. Please wait before trying again.</p>
      <div style="background:rgba(255,165,0,.08);border:1px solid rgba(255,165,0,.15);border-radius:10px;padding:16px;margin-bottom:22px;">
        <div style="font-size:11px;text-transform:uppercase;letter-spacing:.08em;color:#7a6030;margin-bottom:6px;">Time remaining</div>
        <div id="cooldownTimer" style="font-size:32px;font-weight:700;color:#ffa500;font-variant-numeric:tabular-nums;">0:30</div>
      </div>
      <button onclick="document.getElementById('cooldownModal').style.display='none'"
        style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);color:#8f9abf;font-size:13px;padding:10px 24px;border-radius:8px;cursor:pointer;">Close</button>
    </div>
  </div>

  {{-- Player Bar --}}
<div class="player-bar" style="position:fixed;bottom:0;left:0;right:0;height:var(--ph);background:var(--bg);border-top:1px solid var(--di);backdrop-filter:blur(20px);display:flex;align-items:center;gap:20px;padding:0 24px;z-index:60;">
    <div class="p-info" style="display:flex;flex-direction:column;min-width:140px;">
      <div class="p-title" id="pTitle" style="font-size:12.5px;font-weight:600;color:var(--tx);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">No track selected</div>
      <div class="p-artist" id="pArtist" style="font-size:11px;color:var(--mu);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">—</div>
    </div>
    <div class="p-controls" style="display:flex;align-items:center;gap:8px;">
      <button id="prevBtn" style="width:32px;height:32px;border-radius:50%;background:var(--pb);border:1px solid var(--di);cursor:pointer;display:flex;align-items:center;justify-content:center;padding:0;flex-shrink:0;">
        <svg width="12" height="12" viewBox="0 0 16 16" fill="var(--tx)"><rect x="2" y="2" width="2.5" height="12" rx="1"/><path d="M14 2.5 5.5 8 14 13.5z"/></svg>
      </button>
      <button class="pc-play" id="playBtn" style="width:38px;height:38px;border-radius:50%;background:var(--acc);border:1px solid var(--acc);cursor:pointer;display:flex;align-items:center;justify-content:center;padding:0;flex-shrink:0;">
        <svg class="iplay" width="14" height="14" viewBox="0 0 16 16" fill="#fff" style="margin-left:2px;"><path d="M4 2.5 13.5 8 4 13.5z"/></svg>
        <svg class="ipause" width="14" height="14" viewBox="0 0 16 16" fill="#fff" style="display:none;"><rect x="3" y="2" width="3.5" height="12" rx="1"/><rect x="9.5" y="2" width="3.5" height="12" rx="1"/></svg>
      </button>
      <button id="nextBtn" style="width:32px;height:32px;border-radius:50%;background:var(--pb);border:1px solid var(--di);cursor:pointer;display:flex;align-items:center;justify-content:center;padding:0;flex-shrink:0;">
        <svg width="12" height="12" viewBox="0 0 16 16" fill="var(--tx)"><rect x="11.5" y="2" width="2.5" height="12" rx="1"/><path d="M2 2.5 10.5 8 2 13.5z"/></svg>
      </button>
    </div>
    <div class="p-prog" style="flex:1;display:flex;align-items:center;gap:10px;">
      <span id="pCur" style="font-family:'Share Tech Mono',monospace;font-size:12.5px;color:var(--tx);min-width:34px;">0:00</span>
      <div id="pTrackBar" style="flex:1;height:3px;background:var(--me);border-radius:2px;cursor:pointer;">
        <div id="pFill" style="height:100%;border-radius:2px;background:linear-gradient(90deg,var(--acc),#8097ff);width:0%;"></div>
      </div>
      <span id="pTotal" style="font-family:'Share Tech Mono',monospace;font-size:12.5px;color:var(--tx);min-width:34px;">0:00</span>
    </div>
  </div>

  @include('partials.footer')
</section>

<style>
/* ========== UNLOCK LIBRARY BUTTON ========== */
.lib-unlock-glass {
  position:relative;overflow:hidden;transition:all .3s ease;z-index:1;cursor:pointer;
  display:inline-flex;align-items:center;
  background:linear-gradient(135deg,var(--acc),#4a5ee8);
  border:1px solid rgba(130,148,255,.5);color:#fff;
  box-shadow:0 0 18px rgba(96,116,255,.25);
  height:44px;padding:0 18px;border-radius:10px;font-size:13px;font-weight:600;white-space:nowrap;
}
.lib-unlock-glass:hover { background:linear-gradient(135deg,#1e1f24,#1e202c); }
.lib-unlock-glass:active { transform:translateY(0); }
.lib-unlock-glass::before {
  content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;
  background:linear-gradient(90deg,transparent,rgba(255,255,255,.12),rgba(141,132,132,.925),rgba(255,255,255,.12),transparent);
  transition:left .5s ease;z-index:-1;
}
.lib-unlock-glass:hover::before { left:100%; }

/* ========== DOWNLOAD BUTTON ========== */
.download-glass {
  position:relative;overflow:hidden;transition:all .3s ease;z-index:1;cursor:pointer;
  display:inline-flex;align-items:center;justify-content:center;
  width:32px;height:32px;border-radius:6px;
  background:rgba(255,255,255,.05);border:1px solid var(--me);color:var(--tx);
}
.download-glass:hover {
  background:rgba(96,116,255,.18);border-color:rgba(96,116,255,.5);color:#fff;
  transform:translateY(-2px);box-shadow:0 0 14px rgba(96,116,255,.25);
}
.download-glass:active { transform:translateY(0); }
.download-glass::before {
  content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;
  background:linear-gradient(90deg,transparent,rgba(255,255,255,.1),rgba(255,255,255,.22),rgba(255,255,255,.1),transparent);
  transition:left .5s ease;z-index:-1;
}
.download-glass:hover::before { left:100%; }

/* ========== UNLOCK BUTTON IN TABLE ========== */
.unlock-table-glass {
  display:inline-flex;align-items:center;justify-content:center;gap:4px;
  padding:5px 10px;min-width:60px;border-radius:6px;
  background:linear-gradient(135deg,var(--acc),#4a5ee8);
  border:1px solid rgba(130,148,255,.5);color:#fff;
  font-size:10px;font-weight:600;white-space:nowrap;cursor:pointer;
  transition:all .3s ease;position:relative;overflow:hidden;box-sizing:border-box;
}
.unlock-table-glass:hover {
  background:#0a0e1a;border-color:rgba(50,55,80,.8);
  transform:translateY(-1px);box-shadow:0 0 18px rgba(96,116,255,.3);
}
.unlock-table-glass:active { transform:translateY(0); }
.unlock-table-glass::before {
  content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;
  background:linear-gradient(90deg,transparent,rgba(255,255,255,.1),rgba(255,255,255,.25),rgba(255,255,255,.1),transparent);
  transition:left .5s ease;z-index:-1;
}
.unlock-table-glass:hover::before { left:100%; }

/* ========== CATEGORY PILLS ========== */
.cat-pill {
  height:32px;padding:0 14px;border-radius:7px;
  background:rgba(255,255,255,.04);border:1px solid var(--di);
  color:var(--mu);font-size:11px;font-family:'Exo 2',sans-serif;
  letter-spacing:.07em;text-transform:uppercase;cursor:pointer;
  font-weight:500;transition:all .18s;white-space:nowrap;
}
.cat-pill[data-cat="Acapella"]:hover,.cat-pill[data-cat="Acapella"].active { background:rgba(200,80,80,.18)!important;border-color:rgba(200,80,80,.55)!important;color:#f08080!important; }
.cat-pill[data-cat="Drums"]:hover,.cat-pill[data-cat="Drums"].active       { background:rgba(80,130,200,.18)!important;border-color:rgba(80,130,200,.55)!important;color:#80b0f0!important; }
.cat-pill[data-cat="Bass"]:hover,.cat-pill[data-cat="Bass"].active         { background:rgba(80,200,130,.18)!important;border-color:rgba(80,200,130,.55)!important;color:#80e0a0!important; }
.cat-pill[data-cat="Melody"]:hover,.cat-pill[data-cat="Melody"].active     { background:rgba(200,160,50,.18)!important;border-color:rgba(200,160,50,.55)!important;color:#f0c860!important; }
.cat-pill[data-cat="Instrumental"]:hover,.cat-pill[data-cat="Instrumental"].active { background:rgba(130,80,200,.18)!important;border-color:rgba(130,80,200,.55)!important;color:#c080f0!important; }

/* ========== TABLE WRAPPER ========== */
.lib-table-wrap {
  width:100%;
  border-radius:12px;
  overflow:hidden;
}
.lib-table-scroll {
  width:100%;
  overflow-x:auto;
  -webkit-overflow-scrolling:touch;
}

/* ========== TABLE ========== */
.lib-table {
  width:100%;
  border-collapse:collapse;
  /* NO table-layout:fixed — let columns size to content */
}
.lib-table thead th {
  padding:10px 12px;
  text-align:left;
  font-size:10px;
  text-transform:uppercase;
  letter-spacing:.1em;
  color:var(--mu2);
  white-space:nowrap;
  border-bottom:1px solid var(--di);
}
.lib-table thead th:first-child { padding-left:14px; }
.lib-table thead th:last-child  { text-align:right; padding-right:14px; }
.lib-table tbody tr { border-bottom:1px solid rgba(255,255,255,.04);transition:background .12s; }
.lib-table tbody tr:last-child { border-bottom:none; }
.lib-table tbody tr:hover { background:rgba(255,255,255,.03); }
.lib-table tbody tr.is-locked { opacity:.5; }
.lib-table td {
  padding:10px 12px;
  font-size:13px;
  color:var(--tx);
  vertical-align:middle;
  white-space:nowrap;
}
.lib-table td:first-child { padding-left:14px; }
.lib-table td:last-child  { text-align:right; padding-right:14px; }

.trk-title  { font-weight:600;font-size:13px;color:var(--tx);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:180px; }
.trk-artist { font-size:12px;color:var(--mu2);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:120px; }

/* ========== PLAY BUTTON ========== */
.play-btn-row {
  width:30px;height:30px;border-radius:50%;
  background:rgba(96,116,255,.18);border:1px solid rgba(96,116,255,.3);
  display:inline-flex;align-items:center;justify-content:center;cursor:pointer;transition:background .15s;
}
.play-btn-row:hover  { background:rgba(96,116,255,.35); }
.play-btn-row.playing { background:var(--acc);border-color:var(--acc); }

/* ========== BADGES ========== */
.sbadge { display:inline-block;padding:3px 9px;border-radius:4px;font-size:10px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;white-space:nowrap; }
.sa  { background:rgba(200,80,80,.2);   color:#f08080;border:1px solid rgba(200,80,80,.3); }
.sd  { background:rgba(80,130,200,.2);  color:#80b0f0;border:1px solid rgba(80,130,200,.3); }
.sb2 { background:rgba(80,200,130,.2);  color:#80e0a0;border:1px solid rgba(80,200,130,.3); }
.sm  { background:rgba(200,160,50,.2);  color:#f0c860;border:1px solid rgba(200,160,50,.3); }
.si2 { background:rgba(130,80,200,.2);  color:#c080f0;border:1px solid rgba(130,80,200,.3); }

.badge-hidden {
  display:inline-block;padding:2px 7px;border-radius:4px;font-size:9px;font-weight:700;
  letter-spacing:.06em;text-transform:uppercase;margin-left:6px;
  background:rgba(255,100,100,.15);color:#f08080;border:1px solid rgba(255,100,100,.3);vertical-align:middle;
}

/* ========== PAGINATION ========== */
.pag-num,.pag-arr {
  width:32px;height:32px;border-radius:6px;background:rgba(255,255,255,.04);
  border:1px solid var(--di);color:var(--mu);font-size:12px;cursor:pointer;
  display:inline-flex;align-items:center;justify-content:center;transition:all .12s;
}
.pag-num:hover { background:rgba(255,255,255,.08); }
.pag-num.active { background:rgba(96,116,255,.2);border-color:var(--acc);color:var(--acc);font-weight:600; }
.pag-arr:disabled { opacity:.3;cursor:default; }

/* ========== PLAYER ========== */
.pc-play.playing .iplay  { display:none; }
.pc-play.playing .ipause { display:block!important; }
.lib-sort option { background:#08122a;color:#e8ecff; }
.lib-search::placeholder { color:var(--mu);opacity:1; }
.lib-search::-webkit-search-cancel-button { display:none; }
#dlLimitModal[style*="flex"] { display:flex!important; }

/* ========== MOBILE ========== */
@media (max-width:768px) {
  .lw { padding-left:12px !important; padding-right:12px !important; }

  #accessStrip { margin-bottom:14px !important; }

  /* Top bar stacks vertically */
  .lib-topbar {
    display:flex !important;
    flex-direction:column !important;
    gap:8px !important;
  }
  .lib-search,
  .lib-sort,
  #topButtonContainer {
    width:100% !important;
    min-width:unset !important;
    box-sizing:border-box !important;
  }
  #topButtonContainer .lib-unlock-glass {
    width:100% !important;
    justify-content:center !important;
    display:flex !important;
    box-sizing:border-box !important;
  }

  /* Pills scroll horizontally */
  #catRow {
    display:flex !important;
    flex-wrap:nowrap !important;
    overflow-x:auto !important;
    gap:6px !important;
    padding-bottom:6px !important;
    margin-bottom:10px !important;
    scrollbar-width:none !important;
  }
  #catRow::-webkit-scrollbar { display:none !important; }
  .cat-pill { flex-shrink:0 !important; }

  /* Pagination */
  #paginationTop { padding:6px 0 !important; margin-bottom:6px !important; }
  #pagination    { padding:12px 0 !important; }
  .pagination    { justify-content:center !important; gap:4px !important; }
  .pag-num,.pag-arr { width:30px !important; height:30px !important; font-size:11px !important; }

  /* Table wrapper — full width, scrollable inside */
  .lib-table-wrap {
    width:100% !important;
    border-radius:10px !important;
  }
  .lib-table-scroll {
    overflow-x:auto !important;
    -webkit-overflow-scrolling:touch !important;
  }

  /* Table itself has a natural min-width so all columns stay visible on scroll */
  .lib-table {
    min-width:560px !important;
    width:100% !important;
  }
  .lib-table thead th {
    font-size:9px !important;
    padding:8px 8px !important;
    letter-spacing:.06em !important;
  }
  .lib-table td {
    padding:9px 8px !important;
    font-size:12px !important;
  }
  .lib-table thead th:first-child,
  .lib-table td:first-child { padding-left:10px !important; }
  .lib-table thead th:last-child,
  .lib-table td:last-child   { padding-right:10px !important; }

  .trk-title  { font-size:12px !important; max-width:140px !important; }
  .trk-artist { font-size:11px !important; max-width:100px !important; }
  .sbadge     { font-size:9px !important; padding:2px 6px !important; }
  .play-btn-row   { width:28px !important; height:28px !important; }
  .download-glass { width:28px !important; height:28px !important; }
  .unlock-table-glass { font-size:9px !important; padding:4px 7px !important; min-width:50px !important; }

  /* Player bar */
  .player-bar { padding:0 10px !important; gap:8px !important; }
  .p-info     { min-width:70px !important; max-width:90px !important; }
  .p-title    { font-size:10.5px !important; }
  .p-artist   { font-size:9px !important; }
  #prevBtn,#nextBtn { width:28px !important; height:28px !important; }
  #playBtn          { width:34px !important; height:34px !important; }
}

/* Light theme fixes */
body.theme-light .lib-search  { background:rgba(0,0,0,.04) !important; color:var(--tx) !important; }
body.theme-light .lib-sort    { background:rgba(0,0,0,.04) !important; color:var(--tx) !important; }
body.theme-light .lib-sort option { background:#e8eaf2 !important; color:#1a1d2e !important; }
body.theme-light .lib-table tbody tr { border-bottom:1px solid rgba(0,0,0,.06) !important; }
body.theme-light .lib-table tbody tr:hover { background:rgba(0,0,0,.03) !important; }
body.theme-light .pag-num,
body.theme-light .pag-arr     { background:rgba(0,0,0,.04) !important; border-color:rgba(0,0,0,.1) !important; }
body.theme-light .download-glass { background:rgba(0,0,0,.04) !important; border-color:rgba(0,0,0,.12) !important; color:var(--tx) !important; }
</style>

<script>
let currentCategory         = "Acapella";
let currentPage             = 1;
let currentSort             = "recent";
let currentSearch           = "";
let stemsData               = [];
let currentAudio            = null;
let isPlaying               = false;
let currentStemId           = null;
let userTier                = "free";
let isLoggedIn              = false;
let guestDownloadsRemaining = 5;
let totalPages              = 1;

async function loadStems() {
    const tbody = document.getElementById("stemTbody");
    if (tbody) tbody.innerHTML = '<tr><td colspan="8" style="text-align:center;padding:40px;color:var(--mu)">Loading stems…</td></tr>';
    try {
        let url = `/api/stems?page=${currentPage}&sort=${currentSort}`;
        if (currentCategory !== "All") url += `&stem_type=${encodeURIComponent(currentCategory)}`;
        if (currentSearch) url += `&search=${encodeURIComponent(currentSearch)}`;
        const response = await fetch(url);
        const data     = await response.json();
        if (data.user) {
            isLoggedIn = data.user.is_logged_in;
            userTier   = data.user.tier;
            if (!isLoggedIn && userTier === "free") {
                const savedCounter = localStorage.getItem('guestDownloadsRemaining');
                const savedTime    = localStorage.getItem('guestDownloadsLastUpdate');
                if (savedCounter !== null && savedTime !== null) {
                    const hoursPassed = (Date.now() - parseInt(savedTime)) / (1000 * 60 * 60);
                    if (hoursPassed < 24) {
                        guestDownloadsRemaining = parseInt(savedCounter);
                    } else {
                        guestDownloadsRemaining = 5;
                        localStorage.removeItem('guestDownloadsRemaining');
                        localStorage.removeItem('guestDownloadsLastUpdate');
                    }
                } else {
                    guestDownloadsRemaining = data.user.guest_downloads_remaining ?? 5;
                }
            } else {
                guestDownloadsRemaining = data.user.guest_downloads_remaining ?? 0;
            }
        }
        stemsData  = data.stems.data;
        totalPages = data.stems.last_page;
        updateAccessStrip();
        renderStemsTable(stemsData);
        renderPagination(totalPages);
        updateTopButton();
    } catch (error) {
        console.error("Error loading stems:", error);
        if (tbody) tbody.innerHTML = '<tr><td colspan="8" style="text-align:center;padding:40px;color:var(--mu)">Error loading stems. Please refresh.</td></tr>';
    }
}

function updateTopButton() {
    const container = document.getElementById('topButtonContainer');
    if (!container) return;
    if (isLoggedIn && (userTier === 'web' || userTier === 'full')) {
        container.innerHTML = `
            <button class="lib-unlock-glass" style="background: rgba(35,201,154,0.15); border: 1px solid rgba(35,201,154,0.3); color: #23c99a; cursor: default; box-shadow: none;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#23c99a" stroke-width="2.2" style="margin-right:6px;vertical-align:middle;">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                ${userTier === 'full' ? 'Full Package Active' : 'Web Access Active'}
            </button>
        `;
    } else {
        container.innerHTML = `
            <button class="lib-unlock-glass" id="topUnlockBtn" onclick="goTo('pricing')">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" style="margin-right:6px;vertical-align:middle;">
                    <rect x="3" y="11" width="18" height="11" rx="2"/>
                    <path d="M7 11V7a5 5 0 0 1 9.9-1"/>
                </svg>
                Unlock Full Library
            </button>
        `;
    }
}

function renderStemsTable(stems) {
    const tbody = document.getElementById("stemTbody");
    if (!tbody) return;
    if (!stems || stems.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center;padding:30px;color:var(--mu)">No stems found</td></tr>';
        return;
    }
    tbody.innerHTML = stems.map(stem => `
        <tr class="${stem.is_locked ? 'is-locked' : ''}" data-id="${stem.id}" style="border-bottom:1px solid rgba(255,255,255,.05);">

            <td style="padding:8px 6px 8px 10px;vertical-align:middle;">
                ${stem.is_locked
                    ? `<div class="play-btn-row" style="opacity:.3;cursor:default;">
                           <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="var(--mu)" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                       </div>`
                    : `<div class="play-btn-row ${currentStemId === stem.id && isPlaying ? 'playing' : ''}" onclick="togglePlay(${stem.id})">
                           ${currentStemId === stem.id && isPlaying
                               ? `<svg width="8" height="8" viewBox="0 0 16 16" fill="#fff"><rect x="3" y="2" width="3" height="12" rx="1"/><rect x="10" y="2" width="3" height="12" rx="1"/></svg>`
                               : `<svg width="8" height="8" viewBox="0 0 16 16" fill="var(--tx)"><path d="M4 2.5 13.5 8 4 13.5z"/></svg>`}
                       </div>`
                }
            </td>

            <td style="padding:8px 10px;vertical-align:middle;">
                <div class="trk-title">
                    ${escapeHtml(stem.title)}
                    ${!stem.is_visible ? `<span class="badge-hidden">Hidden</span>` : ''}
                </div>
            </td>

            <td style="padding:8px 10px;vertical-align:middle;">
                <div class="trk-artist">${escapeHtml(stem.artist)}</div>
            </td>

            <td style="padding:8px 10px;vertical-align:middle;">
                <span class="sbadge ${getTypeClass(stem.stem_type)}">${escapeHtml(stem.stem_type === 'ACAPPELLA' ? 'ACAPELLA' : stem.stem_type)}</span>
            </td>

            <td style="padding:8px 10px;vertical-align:middle;color:var(--mu);font-size:11px;">
                ${stem.is_locked ? '—' : (stem.bpm || '—')}
            </td>

            <td style="padding:8px 10px;vertical-align:middle;color:var(--mu);font-size:11px;">
                ${stem.is_locked ? '—' : escapeHtml(stem.musical_key || '—')}
            </td>

            <td style="padding:8px 10px;vertical-align:middle;color:var(--mu);font-size:11px;">
                ${stem.is_locked ? '—' : escapeHtml(stem.genre || '—')}
            </td>

            <td style="padding:8px 10px;text-align:right;vertical-align:middle;">
                ${stem.is_locked
                    ? `<button class="unlock-table-glass" onclick="showUpgradePrompt()">
                           <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 9.9-1"/></svg>
                           Unlock
                       </button>`
                    : `<button class="download-glass" onclick="downloadStem(${stem.id})" title="Download">
                           <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                               <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                               <polyline points="7 10 12 15 17 10"/>
                               <line x1="12" y1="15" x2="12" y2="3"/>
                           </svg>
                       </button>`
                }
            </td>
        </tr>
    `).join("");
}

function renderPagination(total) {
    ["paginationTop", "pagination"].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        if (total <= 1) { el.innerHTML = ""; return; }
        let html = `<button class="pag-arr" onclick="changePage(${currentPage-1})" ${currentPage===1?'disabled':''}>←</button>`;
        for (let i = 1; i <= total; i++) {
            if (i===1||i===total||(i>=currentPage-2&&i<=currentPage+2))
                html += `<button class="pag-num${i===currentPage?' active':''}" onclick="changePage(${i})">${i}</button>`;
            else if (i===currentPage-3||i===currentPage+3)
                html += `<span style="padding:0 4px;opacity:.4;">…</span>`;
        }
        html += `<button class="pag-arr" onclick="changePage(${currentPage+1})" ${currentPage===total?'disabled':''}>→</button>`;
        el.innerHTML = html;
    });
}

function changePage(page) {
    if (page < 1 || page > totalPages) return;
    currentPage = page;
    loadStems();
    window.scrollTo({ top: 0, behavior: "smooth" });
}

async function downloadStem(stemId) {
    if (!isLoggedIn && userTier === "free" && guestDownloadsRemaining <= 0) {
        openDlLimitModal(); return;
    }
    showToast("⏳ Preparing download…");
    try {
        const response    = await fetch(`/api/stems/${stemId}/download`, { method: "GET" });
        const contentType = response.headers.get("content-type") || "";
        if (contentType.includes("application/json")) {
            const data = await response.json();
            if (!data.success && data.requires_account) { hideToast(); openDlLimitModal(); return; }
            if (!data.success && data.cooldown_seconds)  { hideToast(); showRateLimitModal(data.cooldown_seconds); return; }
            showToast(data.message || "Download failed.", true); return;
        }
        const stem = stemsData.find(s => s.id === stemId);
        const a    = document.createElement("a");
        a.href     = `/api/stems/${stemId}/download`;
        a.download = '';
        document.body.appendChild(a);
        a.click();
        a.remove();
        if (!isLoggedIn && userTier === "free") {
            guestDownloadsRemaining = Math.max(0, guestDownloadsRemaining - 1);
            localStorage.setItem('guestDownloadsRemaining', guestDownloadsRemaining);
            localStorage.setItem('guestDownloadsLastUpdate', Date.now());
            updateAccessStrip();
            showToast(`✅ "${stem?.title || 'Stem'}" downloaded! ${guestDownloadsRemaining}/5 remaining`);
        } else {
            showToast(`✅ "${stem?.title || 'Stem'}" downloaded!`);
        }
        loadStems();
    } catch (error) {
        console.error("Download error:", error);
        showToast("❌ Download failed. Please try again.", true);
    }
}

function openDlLimitModal()  { const m = document.getElementById("dlLimitModal");  if (m) m.style.display = "flex"; }
function closeDlLimitModal() { const m = document.getElementById("dlLimitModal");  if (m) m.style.display = "none"; }

function showRateLimitModal(seconds) {
    const modal   = document.getElementById("cooldownModal");
    const timerEl = document.getElementById("cooldownTimer");
    if (!modal) return;
    const fmt = s => `${Math.floor(s/60)}:${(s%60).toString().padStart(2,"0")}`;
    if (timerEl) timerEl.textContent = fmt(seconds);
    modal.style.display = "flex";
    let rem = seconds;
    const iv = setInterval(() => {
        rem--;
        if (rem <= 0) { clearInterval(iv); modal.style.display = "none"; }
        else if (timerEl) timerEl.textContent = fmt(rem);
    }, 1000);
}

async function togglePlay(stemId) {
    const stem = stemsData.find(s => s.id === stemId);
    if (!stem || stem.is_locked) { showToast("This stem is locked. Upgrade to preview.", true); return; }
    if (currentStemId === stemId && isPlaying) {
        if (currentAudio) currentAudio.pause();
        isPlaying = false; updatePlayButton(false); renderStemsTable(stemsData); return;
    }
    if (currentAudio) { currentAudio.pause(); currentAudio = null; }
    try {
        const response = await fetch(`/api/stems/${stemId}/preview`);
        const blob     = await response.blob();
        const url      = window.URL.createObjectURL(blob);
        currentAudio   = new Audio(url);
        currentAudio.onended = () => { isPlaying = false; updatePlayButton(false); window.URL.revokeObjectURL(url); renderStemsTable(stemsData); };
        currentAudio.play();
        isPlaying = true; currentStemId = stemId;
        updatePlayButton(true); updatePlayerInfo(stem); renderStemsTable(stemsData);
    } catch (error) { showToast("Error playing preview", true); }
}

function escapeHtml(text) { const d = document.createElement("div"); d.textContent = text ?? ""; return d.innerHTML; }

function getTypeClass(type) {
    return { Acapella:"sa", Drums:"sd", Bass:"sb2", Melody:"sm", Instrumental:"si2" }[type] || "sa";
}

function updateAccessStrip() {
    const strip = document.getElementById("accessStrip");
    if (!strip) return;
    if (userTier === "web") {
        strip.innerHTML = `<span class="access-strip-txt"><strong style="color:#8097ff;">Web Access Active</strong> — Full library unlocked. Download anything!</span>`;
    } else if (userTier === "full") {
        strip.innerHTML = `<span class="access-strip-txt"><strong style="color:#23c99a;">Full Package</strong> — Complete library is yours forever!</span>`;
    } else if (isLoggedIn) {
        strip.innerHTML = `<span class="access-strip-txt"><strong style="color:var(--tx);">Free Account</strong> — First 200 stems unlocked. <a href="#" onclick="event.preventDefault(); goTo('pricing');" style="color:#6074ff;font-weight:600;cursor:pointer;">Upgrade to Web Access ($35)</a> for the full library.</span>`;
    } else {
        const c = guestDownloadsRemaining === 0 ? "#f08080" : guestDownloadsRemaining <= 2 ? "#f0c060" : "#80e0a0";
        strip.innerHTML = `<span class="access-strip-txt"><strong style="color:var(--tx);">Guest Access</strong> — <span style="color:${c};font-weight:600;">${guestDownloadsRemaining}/5 free downloads</span> remaining today. <a href="#" onclick="event.preventDefault(); window.location.href='/register';" style="color:#6074ff;font-weight:600;cursor:pointer;">Sign up free</a> to get more + first 200 stems!</span>`;
    }
}

function showUpgradePrompt() { window.location.href = '#pricing'; }
function updatePlayButton(on)  { const b = document.getElementById("playBtn"); if (!b) return; on ? b.classList.add("playing") : b.classList.remove("playing"); }
function updatePlayerInfo(stem) {
    const t = document.getElementById("pTitle"), a = document.getElementById("pArtist"), d = document.getElementById("pTotal");
    if (t) t.textContent = stem.title;
    if (a) a.textContent = `${stem.artist} · ${stem.genre}`;
    if (d) { const dur = stem.duration || 180; d.textContent = `${Math.floor(dur/60)}:${(dur%60).toString().padStart(2,"0")}`; }
}

function showToast(msg, isErr = false) {
    let t = document.getElementById("libraryToast");
    if (!t) {
        t = document.createElement("div");
        t.id = "libraryToast";
        t.style.cssText = "position:fixed;bottom:80px;left:50%;transform:translateX(-50%);color:#fff;padding:12px 24px;border-radius:8px;z-index:300;display:none;font-size:14px;white-space:nowrap;";
        document.body.appendChild(t);
    }
    t.textContent   = msg;
    t.style.background = isErr ? "#ef4444" : "#22c55e";
    t.style.display = "block";
    t._timeout && clearTimeout(t._timeout);
    t._timeout = setTimeout(() => { t.style.display = "none"; }, 3000);
}
function hideToast() { const t = document.getElementById("libraryToast"); if (t) t.style.display = "none"; }

document.addEventListener("DOMContentLoaded", function () {
    const lastReset = localStorage.getItem('guestDownloadsLastReset');
    const now       = Date.now();
    if (lastReset && (now - parseInt(lastReset)) >= 86400000) {
        guestDownloadsRemaining = 5;
        localStorage.removeItem('guestDownloadsRemaining');
        localStorage.removeItem('guestDownloadsLastUpdate');
        localStorage.setItem('guestDownloadsLastReset', now);
    } else if (!lastReset) {
        localStorage.setItem('guestDownloadsLastReset', now);
    }

    loadStems();

    document.querySelectorAll(".cat-pill").forEach(pill => {
        pill.addEventListener("click", function () {
            document.querySelectorAll(".cat-pill").forEach(p => p.classList.remove("active"));
            this.classList.add("active");
            currentCategory = this.getAttribute("data-cat");
            currentPage = 1;
            loadStems();
        });
    });

    document.getElementById("stemSearch")?.addEventListener("input", e => {
        currentSearch = e.target.value; currentPage = 1; loadStems();
    });
    document.getElementById("stemSort")?.addEventListener("change", e => {
        currentSort = e.target.value; currentPage = 1; loadStems();
    });
    document.getElementById("playBtn")?.addEventListener("click", () => {
        if (currentStemId) togglePlay(currentStemId);
    });
    document.getElementById("prevBtn")?.addEventListener("click", () => {
        const idx = stemsData.findIndex(s => s.id === currentStemId);
        if (idx > 0 && !stemsData[idx-1].is_locked) togglePlay(stemsData[idx-1].id);
    });
    document.getElementById("nextBtn")?.addEventListener("click", () => {
        const idx = stemsData.findIndex(s => s.id === currentStemId);
        if (idx < stemsData.length-1 && !stemsData[idx+1].is_locked) togglePlay(stemsData[idx+1].id);
    });
    document.getElementById("pTrackBar")?.addEventListener("click", function (e) {
        if (!currentAudio || !currentAudio.duration) return;
        currentAudio.currentTime = (e.offsetX / this.offsetWidth) * currentAudio.duration;
    });
    document.addEventListener("keydown", e => { if (e.key === "Escape") closeDlLimitModal(); });
});

setInterval(() => {
    if (isPlaying && currentAudio && currentAudio.duration) {
        const pct  = (currentAudio.currentTime / currentAudio.duration) * 100;
        const fill = document.getElementById("pFill");
        const cur  = document.getElementById("pCur");
        if (fill) fill.style.width = pct + "%";
        if (cur) {
            const m = Math.floor(currentAudio.currentTime / 60);
            const s = Math.floor(currentAudio.currentTime % 60);
            cur.textContent = `${m}:${s.toString().padStart(2,"0")}`;
        }
    }
}, 500);
</script>