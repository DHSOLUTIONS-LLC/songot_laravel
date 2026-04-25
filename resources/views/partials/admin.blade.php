<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Admin Panel - Son Got Samples</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@200;300;400;600&family=Poppins:wght@300;400;500;600&family=Share+Tech+Mono&display=swap" rel="stylesheet">
  <style>
    :root {
      --hh: 68px;
      --bg: #000510; --bg2: #00030a; --acc: #6074ff;
      --tx: #e8ecff; --mu: #8f9abf; --mu2: #5a6488;
      --di: rgba(255,255,255,.07); --me: rgba(255,255,255,.12);
      --pb: rgba(255,255,255,.03); --pb2: rgba(255,255,255,.015);
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Poppins', system-ui, sans-serif; background: var(--bg); color: var(--tx); overflow-x: hidden; }
    a { color: inherit; text-decoration: none; }
    button { font-family: inherit; cursor: pointer; }
    input, select, textarea { font-family: inherit; }

    @keyframes fadeIn { from { opacity: 0; transform: scale(.97) } to { opacity: 1; transform: scale(1) } }
    @keyframes spin { from { transform: rotate(0deg) } to { transform: rotate(360deg) } }

    /* ── HEADER ── */
    .admin-header {
      position: fixed; top: 0; left: 0; right: 0; height: var(--hh);
      background: rgba(0,5,18,.95); backdrop-filter: blur(14px);
      border-bottom: 1px solid rgba(255,255,255,.07);
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 32px; z-index: 100;
    }
    .admin-brand {
      font-family: 'Exo 2'; font-size: .88rem; letter-spacing: .11em;
      text-transform: uppercase; display: flex; align-items: center; gap: 10px;
    }
    .admin-badge {
      font-size: .6rem; letter-spacing: .12em;
      background: rgba(96,116,255,.15); border: 1px solid rgba(96,116,255,.3);
      color: var(--acc); border-radius: 4px; padding: 2px 8px; text-transform: uppercase;
    }
    .admin-header-right { display: flex; align-items: center; gap: 10px; }
    .admin-hbtn {
      height: 32px; padding: 0 14px; border-radius: 7px;
      background: rgba(255,255,255,.04); border: 1px solid var(--me);
      color: var(--mu); font-size: 12px; font-family: inherit; cursor: pointer;
      transition: .15s; text-transform: uppercase; letter-spacing: .06em;
    }
    .admin-hbtn:hover { background: rgba(255,255,255,.08); color: var(--tx); }
    .admin-hbtn.danger:hover { color: #e05050; border-color: rgba(180,30,30,.35); }

    /* ── MAIN CONTAINER ── */
    .aw2 { max-width: 1240px; margin: 0 auto; padding: calc(var(--hh) + 32px) 24px 60px; }
    .admin-title { font-family: 'Exo 2'; font-weight: 200; font-size: clamp(22px,3vw,34px); letter-spacing: .02em; margin: 0 0 4px; }
    .admin-sub { font-size: 13px; color: var(--mu); margin: 0 0 24px; }

    /* ── TABS ── */
    .admin-tabs { display: flex; gap: 0; border-bottom: 1px solid var(--di); margin-bottom: 22px; flex-wrap: wrap; }
    .admin-tab {
      height: 40px; padding: 0 20px;
      background: transparent; border: 1px solid transparent; border-bottom: none;
      color: var(--mu); font-size: .75rem; font-family: 'Exo 2'; letter-spacing: .09em;
      text-transform: uppercase; cursor: pointer; transition: .15s;
      display: flex; align-items: center; gap: 7px;
      position: relative; bottom: -1px; border-radius: 7px 7px 0 0;
    }
    .admin-tab:hover { color: var(--tx); }
    .admin-tab.active {
      border-color: var(--di); border-bottom-color: var(--bg);
      background: var(--pb); color: var(--tx);
    }

    /* ── PANES ── */
    .admin-pane { display: none; }
    .admin-pane.active { display: block; animation: fadeIn .22s ease; }

    /* ── TOOLBAR ── */
    .admin-toolbar { display: flex; align-items: center; gap: 9px; margin-bottom: 16px; flex-wrap: wrap; }
    .admin-search {
      flex: 1; min-width: 200px; height: 40px;
      background: rgba(255,255,255,.05); border: 1px solid var(--me);
      border-radius: 9px; padding: 0 12px 0 36px; color: var(--tx);
      font-size: 13px; outline: none; transition: border-color .2s;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='15' height='15' fill='none' viewBox='0 0 24 24' stroke='%238f9abf' stroke-width='2.2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E");
      background-repeat: no-repeat; background-position: 12px center;
    }
    .admin-search:focus { border-color: rgba(96,116,255,.45); }
    .admin-search::placeholder { color: var(--mu2); }
    .admin-select {
      height: 40px; padding: 0 10px;
      background: rgba(255,255,255,.05); border: 1px solid var(--me);
      border-radius: 9px; color: var(--tx); font-size: 13px; outline: none;
      cursor: pointer; min-width: 130px; -webkit-appearance: auto; font-family: inherit;
    }
    .admin-select option { background: #08122a; color: #e8ecff; }
    .admin-import-btn {
      height: 40px; padding: 0 16px; border-radius: 9px;
      background: rgba(255,255,255,.04); border: 1px solid var(--me);
      color: var(--tx); font-size: 13px; font-family: inherit; cursor: pointer;
      display: flex; align-items: center; gap: 7px; white-space: nowrap; transition: .15s;
    }
    .admin-import-btn:hover { background: rgba(255,255,255,.08); }
    .admin-import-btn.accent {
      background: linear-gradient(135deg,var(--acc),#4a5ee8);
      border-color: rgba(130,148,255,.4); color: #fff;
      box-shadow: 0 0 12px rgba(96,116,255,.26);
    }
    .admin-import-btn.accent:hover { opacity: .88; }
    .admin-import-btn.danger-btn {
      background: rgba(180,30,30,.12); border-color: rgba(180,30,30,.35); color: #e05050;
    }
    .admin-import-btn.danger-btn:hover { background: rgba(180,30,30,.22); }

    /* ── TABLE ── */
    .admin-table-wrap { border: 1px solid var(--di); border-radius: 11px; overflow: hidden; margin-bottom: 16px; }
    .admin-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .admin-table thead tr { background: rgba(255,255,255,.025); }
    .admin-table th {
      padding: 11px 14px; text-align: left;
      font-family: 'Exo 2'; font-size: .65rem; letter-spacing: .1em; text-transform: uppercase;
      color: var(--mu); border-bottom: 1px solid var(--di); font-weight: 400;
    }
    .admin-table td { padding: 12px 14px; border-bottom: 1px solid var(--di); color: var(--tx); vertical-align: middle; }
    .admin-table tbody tr:last-child td { border-bottom: none; }
    .admin-table tbody tr:hover td { background: rgba(255,255,255,.025); }

    /* ── BADGES ── */
    .tier-badge, .atype-badge, .status-badge {
      display: inline-flex; align-items: center; height: 22px; padding: 0 9px;
      border-radius: 5px; font-size: 10px; font-family: 'Exo 2';
      letter-spacing: .09em; text-transform: uppercase; font-weight: 600; border: 1px solid transparent;
    }
    .tier-free { background: rgba(255,255,255,.06); border-color: rgba(255,255,255,.1); color: var(--mu); }
    .tier-web { background: rgba(96,116,255,.14); border-color: rgba(96,116,255,.3); color: #8097ff; }
    .tier-full { background: rgba(30,185,145,.13); border-color: #1eb991; color: #23c99a; }
    .atype-acapella { background: rgba(220,40,40,.13); border-color: #d82828; color: #ff5555; }
    .atype-drums { background: rgba(96,116,255,.15); border-color: var(--acc); color: #8097ff; }
    .atype-bass { background: rgba(30,185,145,.13); border-color: #1eb991; color: #23c99a; }
    .atype-melody { background: rgba(230,170,10,.13); border-color: #e6aa0a; color: #f0bf2a; }
    .atype-instrumental { background: rgba(180,90,220,.13); border-color: #b45adc; color: #cc7df5; }
    .status-active { background: rgba(34,197,94,.12); border-color: rgba(34,197,94,.25); color: #4ade80; }
    .status-banned { background: rgba(239,68,68,.12); border-color: rgba(239,68,68,.25); color: #f87171; }
    .status-suspended { background: rgba(245,158,11,.12); border-color: rgba(245,158,11,.25); color: #fbbf24; }
    .astatus-hidden { display: inline-flex; align-items: center; height: 22px; padding: 0 9px; border-radius: 5px; font-size: 10px; font-family: 'Exo 2'; letter-spacing: .09em; text-transform: uppercase; background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.1); color: var(--mu2); }

    /* ── ROW ACTIONS ── */
    .admin-actions { display: flex; align-items: center; gap: 6px; justify-content: flex-end; }
    .aact {
      width: 30px; height: 30px; border-radius: 7px;
      background: rgba(255,255,255,.04); border: 1px solid var(--me);
      color: var(--mu); display: flex; align-items: center; justify-content: center;
      cursor: pointer; transition: .15s; flex-shrink: 0;
    }
    .aact:hover { background: rgba(255,255,255,.1); color: var(--tx); }
    .aact.del:hover { background: rgba(180,30,30,.14); border-color: rgba(180,30,30,.3); color: #e05050; }

    /* ── CHECKBOX ── */
    .admin-check { width: 16px; height: 16px; border-radius: 4px; border: 1px solid var(--me); background: rgba(255,255,255,.04); cursor: pointer; accent-color: var(--acc); }

    /* ── PAGINATION ── */
    .pagination { display: flex; align-items: center; justify-content: center; gap: 5px; padding: 18px 0 6px; flex-wrap: wrap; }
    .pag-num, .pag-arr {
      min-width: 32px; height: 32px; border-radius: 7px; border: 1px solid var(--di);
      background: var(--pb); color: var(--tx); font-size: 12.5px; cursor: pointer;
      display: inline-flex; align-items: center; justify-content: center;
      font-family: 'Exo 2'; letter-spacing: .04em; transition: .15s;
    }
    .pag-num:hover:not(.active), .pag-arr:hover:not([disabled]) { background: rgba(96,116,255,.12); border-color: rgba(96,116,255,.3); }
    .pag-num.active { background: var(--acc); border-color: var(--acc); color: #fff; }
    .pag-arr[disabled] { opacity: .28; cursor: default; pointer-events: none; }

    /* ── MODAL ── */
    .modal-backdrop { position: fixed; inset: 0; background: rgba(0,3,16,.7); backdrop-filter: blur(10px); display: none; align-items: center; justify-content: center; z-index: 200; }
    .modal {
      width: min(500px,92vw); background: linear-gradient(160deg,#030b22,#010510);
      border: 1px solid rgba(96,116,255,.18); border-radius: 16px; padding: 28px;
      position: relative; animation: fadeIn .22s ease; color: #e8ecff;
    }
    .modal.wide { width: min(600px,92vw); }
    .modal.scroll { max-height: 80vh; overflow-y: auto; }
    .mtitle { font-family: 'Exo 2'; font-weight: 300; font-size: 1rem; text-transform: uppercase; letter-spacing: .09em; margin: 0 0 18px; }
    .mclose { position: absolute; top: 13px; right: 13px; width: 30px; height: 30px; border-radius: 8px; border: 1px solid var(--me); background: transparent; color: var(--tx); display: flex; align-items: center; justify-content: center; font-size: 13px; cursor: pointer; }
    .mclose:hover { background: rgba(255,255,255,.07); }
    .mfield { margin-bottom: 13px; }
    .mfield label { display: block; font-size: 10px; text-transform: uppercase; letter-spacing: .09em; color: var(--mu); margin-bottom: 5px; font-family: 'Exo 2'; }
    .minput {
      width: 100%; background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.13);
      border-radius: 8px; padding: 10px 13px; color: #fff; font-size: 13px;
      font-family: 'Poppins', sans-serif; outline: none; transition: border-color .2s;
    }
    .minput:focus { border-color: rgba(96,116,255,.5); }
    .minput::placeholder { color: rgba(255,255,255,.25); }
    select.minput option { background: #08122a; }
    .modal-btns { display: flex; gap: 9px; flex-wrap: wrap; margin-top: 4px; }
    .mbtn {
      height: 38px; padding: 0 18px; border-radius: 8px; font-size: 13px; font-weight: 500;
      border: 1px solid var(--me); background: rgba(255,255,255,.04); color: var(--tx); cursor: pointer; transition: .15s;
    }
    .mbtn:hover { background: rgba(255,255,255,.08); }
    .mbtn.accent { background: linear-gradient(135deg,var(--acc),#4a5ee8); border-color: rgba(130,148,255,.4); color: #fff; }
    .mbtn.accent:hover { opacity: .88; }
    .mbtn.danger { background: rgba(180,30,30,.12); border-color: rgba(180,30,30,.35); color: #e05050; }

    /* ── TOAST ── */
    .toast {
      position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%);
      background: rgba(20,30,60,.97); border: 1px solid rgba(96,116,255,.25);
      border-radius: 10px; padding: 10px 20px; font-size: 13px; color: #e8ecff;
      z-index: 500; display: none; white-space: nowrap;
      box-shadow: 0 4px 20px rgba(0,0,0,.4); animation: fadeIn .2s ease;
    }
    .toast.success { border-color: rgba(30,185,145,.3); }
    .toast.error { border-color: rgba(239,68,68,.3); color: #f87171; }

    /* ── EMAIL PANE SPECIFIC ── */
    .email-compose-area { background: var(--pb); border: 1px solid var(--di); border-radius: 12px; padding: 20px; }

    /* ── AUDIT LOG BADGES ── */
    .log-action { display: inline-flex; align-items: center; height: 22px; padding: 0 9px; border-radius: 5px; font-size: 10px; font-family: 'Exo 2'; letter-spacing: .07em; text-transform: uppercase; border: 1px solid transparent; }
    .log-edit { background: rgba(96,116,255,.14); border-color: rgba(96,116,255,.3); color: #8097ff; }
    .log-visibility { background: rgba(245,158,11,.12); border-color: rgba(245,158,11,.25); color: #fbbf24; }
    .log-user { background: rgba(34,197,94,.12); border-color: rgba(34,197,94,.25); color: #4ade80; }
    .log-email { background: rgba(30,185,145,.12); border-color: rgba(30,185,145,.25); color: #23c99a; }
    .log-bulk { background: rgba(139,92,246,.12); border-color: rgba(139,92,246,.25); color: #a78bfa; }

    /* ── FILE MANAGER ── */
    .file-folder-row { cursor: pointer; }
    .file-folder-row:hover td { background: rgba(96,116,255,.04) !important; }

    /* ── STATS CARDS ── */
    .mini-stats { display: flex; gap: 12px; margin-top: 16px; flex-wrap: wrap; }
    .mini-stat { background: var(--pb); border: 1px solid var(--di); border-radius: 10px; padding: 14px 18px; flex: 1; min-width: 140px; }
    .mini-stat-val { font-family: 'Exo 2'; font-size: 1.6rem; font-weight: 300; color: var(--acc); }
    .mini-stat-label { font-size: 10px; text-transform: uppercase; letter-spacing: .09em; color: var(--mu); margin-top: 4px; }

    @media (max-width: 860px) {
      .admin-header { padding: 0 16px; }
      .aw2 { padding-left: 12px; padding-right: 12px; }
      .admin-tab { padding: 0 12px; font-size: .68rem; }
    }

/* Modern dim effect with blur */
.stem-row-hidden {
  opacity: 0.45;
  background: linear-gradient(135deg, rgba(220, 60, 60, 0.1), rgba(220, 60, 60, 0.05)) !important;
  filter: blur(0.3px);
  transition: all 0.25s ease;
  position: relative;
}

.stem-row-hidden td {
  color: #9e9e9e !important;
}

.stem-row-hidden:hover {
  opacity: 0.65;
  filter: blur(0px);
  background: linear-gradient(135deg, rgba(220, 60, 60, 0.15), rgba(220, 60, 60, 0.08)) !important;
}

/* Overlay pattern for hidden rows */
.stem-row-hidden {
  background-blend-mode: multiply;
}

.stem-row-hidden td:first-child {
  border-left: 3px solid #f08080;
}

/* Hidden badge with glow */
.astatus-hidden {
  background: rgba(220, 60, 60, 0.35);
  color: #ffb5b5;
  padding: 5px 12px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 700;
  display: inline-block;
  backdrop-filter: blur(4px);
  box-shadow: 0 0 8px rgba(220, 60, 60, 0.3);
  letter-spacing: 0.5px;
}

/* Bulk Action Bar */
.bulk-bar {
  display:none;align-items:center;gap:10px;flex-wrap:wrap;
  background:rgba(96,116,255,.08);border:1px solid rgba(96,116,255,.2);
  border-radius:9px;padding:10px 14px;margin-bottom:12px;
}
.bulk-bar.visible { display:flex; }
.bulk-bar-info { font-size:13px;color:var(--acc);font-weight:600;flex:1; }




/* ── VAULT ADMIN ── */
.admin-table tbody tr.row-hidden td { opacity: .42; }
.admin-table tbody tr.editing td { background: rgba(96,116,255,.05); }
.edit-input {
  background: rgba(255,255,255,.07); border: 1px solid rgba(96,116,255,.35);
  border-radius: 6px; padding: 5px 9px; color: var(--tx); font-size: 12.5px;
  outline: none; font-family: inherit; transition: border-color .2s; width: 100%;
}
.edit-input:focus { border-color: rgba(96,116,255,.7); background: rgba(96,116,255,.08); }
.edit-input.sm { width: 72px; }
.edit-input.md { width: 110px; }
.vbadge {
  display: inline-flex; align-items: center; height: 22px; padding: 0 9px;
  border-radius: 5px; font-size: 10px; font-family: 'Exo 2'; letter-spacing: .09em;
  text-transform: uppercase; font-weight: 600; border: 1px solid transparent; margin-right: 3px; margin-bottom: 2px;
}
.vbadge-active { background: rgba(30,185,145,.2); border-color: rgba(30,185,145,.55); color: #1eb991; }
.vbadge-hidden { background: rgba(120,130,150,.12); border-color: rgba(120,130,150,.3); color: var(--mu2); }
.vbadge-tag    { background: rgba(96,116,255,.14); border-color: rgba(96,116,255,.3); color: #8097ff; }
.aact.save  { border-color: rgba(30,185,145,.4); color: #23c99a; }
.aact.save:hover { background: rgba(30,185,145,.15); }
  </style>
</head>
<body>

<!-- HEADER -->
<div class="admin-header">
  <div class="admin-brand">
    <span>Son Got Samples</span>
    <span class="admin-badge">Admin</span>
  </div>
  <div class="admin-header-right">
    <button class="admin-hbtn" id="adminViewSiteBtn">View Site</button>
    <button class="admin-hbtn danger" id="adminLogoutBtn">Logout</button>
  </div>
</div>

<!-- MAIN -->
<div class="aw2">
  <div class="admin-title">Admin Dashboard</div>
  <div class="admin-sub">Manage customers and stem library</div>

  <!-- TABS -->
  <div class="admin-tabs">
    <button class="admin-tab active" data-atab="customers">
      <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="8" cy="5" r="3"/><path d="M2 14c0-3.31 2.69-6 6-6s6 2.69 6 6"/></svg>
      Customers
    </button>
    <button class="admin-tab" data-atab="stems">
      <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 12V4l5-2 7 3v8"/><circle cx="7" cy="10" r="2"/></svg>
      Stems
    </button>
    <button class="admin-tab" data-atab="logs">
      <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 4h12M2 8h8M2 12h5"/></svg>
      Audit Logs
    </button>
        <button class="admin-tab" data-atab="vault">
      <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 4h12M2 8h8M2 12h5"/></svg>
      Vault Admin
    </button>
  </div>

  <!-- CUSTOMERS PANE -->
  <div class="admin-pane active" id="adminPane-customers">
    <div class="admin-toolbar">
      <input type="search" class="admin-search" id="adminCustSearch" placeholder="Search by email…"/>
      <select class="admin-select" id="adminCustFilter">
        <option value="">All Tiers</option>
        <option value="free">Free</option>
        <option value="web">Web Access</option>
        <option value="full">Full Download</option>
      </select>
      <button class="admin-import-btn accent" id="bulkEmailBtn" style="display:none;">
        <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="1" y="3" width="14" height="10" rx="1.5"/><path d="m1 5 7 5 7-5"/></svg>
        Email Selected (<span id="selectedCount">0</span>)
      </button>
      <button class="admin-import-btn" id="adminImportCSV">
        <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M8 2v8M5 7l3 3 3-3M3 12h10"/></svg>
        Import CSV
      </button>
    </div>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead><tr>
          <th style="width:36px;"><input type="checkbox" class="admin-check" id="custCheckAll"/></th>
          <th>Email</th><th>Tier</th><th>Joined</th>
          <th style="text-align:right;">Actions</th>
        </tr></thead>
        <tbody id="adminCustTbody"></tbody>
      </table>
    </div>
    <div class="pagination" id="adminCustPag"></div>
  </div>

  <!-- STEMS PANE -->
  <div class="admin-pane" id="adminPane-stems">
    <div class="admin-toolbar">
      <input type="search" class="admin-search" id="adminStemSearch" placeholder="Search by title, artist, genre…"/>
      <select class="admin-select" id="adminStemTypeFilter">
        <option value="">All Types</option>
        <option value="Acapella">Acapella</option>
        <option value="Drums">Drums</option>
        <option value="Bass">Bass</option>
        <option value="Melody">Melody</option>
        <option value="Instrumental">Instrumental</option>
      </select>
      <select class="admin-select" id="adminStemSort">
        <option value="recent">Most Recent</option>
        <option value="title">Title A–Z</option>
        <option value="bpmAsc">BPM Low–High</option>
        <option value="bpmDesc">BPM High–Low</option>
      </select>
    </div>
    <!-- Bulk Action Bar -->
<div class="bulk-bar" id="stemBulkBar">
  <span class="bulk-bar-info" id="stemBulkInfo">0 stems selected</span>

  <button class="admin-import-btn" id="bulkEditGenreBtn">
    <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M11.5 2.5a2.12 2.12 0 0 1 3 3L5 15H1v-4z"/></svg>
    Edit Genre
  </button>

  <button class="admin-import-btn" id="bulkEditTypeBtn">
    <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M11.5 2.5a2.12 2.12 0 0 1 3 3L5 15H1v-4z"/></svg>
    Edit Type
  </button>
{{--
  <button class="admin-import-btn" id="bulkHideBtn">
    <svg width="13" height="13" viewBox="0 0 20 18" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M1 1l18 16M8.5 3.2A7 7 0 0 1 10 3c6 0 9 6 9 6a16.4 16.4 0 0 1-2.5 3.3M5.2 5.2A16.4 16.4 0 0 0 1 9s3 6 9 6a7 7 0 0 0 4.8-1.8"/></svg>
    Hide Selected
  </button>

  <button class="admin-import-btn" id="bulkShowBtn">
    <svg width="13" height="13" viewBox="0 0 20 14" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M1 7S4 1 10 1s9 6 9 6-3 6-9 6-9-6-9-6z"/><circle cx="10" cy="7" r="2.5"/></svg>
    Show Selected
  </button> --}}

  <button class="admin-import-btn danger-btn" id="bulkDeleteBtn">
    <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6"><polyline points="3 6 4.5 14 11.5 14 13 6"/><path d="M1 4h14M6 4V2h4v2"/></svg>
    Delete Selected
  </button>
</div>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead><tr>
          <th style="width:36px;"><input type="checkbox" class="admin-check" id="stemCheckAll"/></th>
          <th>Title</th><th>Artist</th><th>Type</th><th>BPM</th>
          <th>Key</th><th>Genre</th><th>Status</th>
          <th style="text-align:right;">Actions</th>
        </tr></thead>
        <tbody id="adminStemTbody"></tbody>
      </table>
    </div>
    <div class="pagination" id="adminStemPag"></div>
  </div>

  <!-- EMAIL PANE -->
  <div class="admin-pane" id="adminPane-email">
    <div class="admin-toolbar">
      <button class="admin-import-btn accent" id="newEmailBtn">
        <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M8 2v12M2 8h12"/></svg>
        Compose New Email
      </button>
    </div>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead><tr>
          <th>ID</th><th>Subject</th><th>Recipients</th>
          <th>Sent</th><th>Failed</th><th>Status</th><th>Created</th>
        </tr></thead>
        <tbody id="emailJobsBody">
          <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--mu2);">No email jobs found</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- AUDIT LOGS PANE -->
  <div class="admin-pane" id="adminPane-logs">
    <div class="admin-toolbar">
      <select class="admin-select" id="actionFilter">
        <option value="">All Actions</option>
        <option value="edit_stem">Edit Stem</option>
        <option value="toggle_visibility">Toggle Visibility</option>
        <option value="bulk_visibility">Bulk Visibility</option>
        <option value="update_user_status">Update User Status</option>
        <option value="send_email">Send Email</option>
      </select>
    </div>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead><tr>
          <th>Admin</th><th>Action</th><th>Target</th><th>Details</th><th>Time</th>
        </tr></thead>
        <tbody id="auditLogsBody"></tbody>
      </table>
    </div>
  </div>


  <!-- VAULT ADMIN PANE -->
<div class="admin-pane" id="adminPane-vault">
  <div class="admin-toolbar">
    <input class="admin-search" id="vaultGenreSearch" type="search" placeholder="Search genres or tags…"/>
    <select class="admin-select" id="vaultGenreStatusFilter">
      <option value="">All Status</option>
      <option value="active">Active</option>
      <option value="hidden">Hidden</option>
    </select>
  </div>
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr>
        <th>Genre</th>
        <th>Description</th>
        <th>Stems</th>
        <th>Size</th>
        <th>Tags</th>
        <th>Status</th>
        <th style="text-align:right">Actions</th>
      </tr></thead>
      <tbody id="vaultGenreTbody"></tbody>
    </table>
  </div>
</div>

</div><!-- /aw2 -->

<!-- ════ MODALS ════ -->
<!-- Edit Customer -->
<!-- Bulk Edit Genre Modal -->
<div class="modal-backdrop" id="bulkEditGenreModal">
  <div class="modal">
    <button class="mclose" data-close="bulkEditGenreModal">✕</button>
    <div class="mtitle">Bulk Edit Genre</div>
    <p style="font-size:13px;color:var(--mu);margin-bottom:16px;" id="bulkEditGenreInfo"></p>
    <div class="mfield">
      <label>New Genre</label>
      <input type="text" class="minput" id="bulkGenreInput" placeholder="e.g. Hip Hop, Afrobeat, R&B…"/>
    </div>
    <div class="modal-btns">
      <button class="mbtn accent" id="bulkGenreSaveBtn">Apply to All Selected</button>
      <button class="mbtn" data-close="bulkEditGenreModal">Cancel</button>
    </div>
  </div>
</div>
<!-- Bulk Delete Confirm Modal -->
<!-- Delete Confirm Modal — Bulk + Single -->
<div class="modal-backdrop" id="bulkDeleteModal">
  <div class="modal" style="text-align:center;padding:36px 32px 28px;">
    <div style="width:56px;height:56px;border-radius:16px;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#f87171" stroke-width="1.8" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
    </div>
    <h3 style="font-family:'Exo 2';font-size:16px;font-weight:500;color:var(--tx);margin:0 0 8px;letter-spacing:.04em;">Confirm Delete</h3>
    <p id="bulkDeleteModalInfo" style="font-size:13px;color:var(--mu);margin:0 0 6px;line-height:1.6;"></p>
    <p style="font-size:12px;color:var(--mu2);margin:0 0 28px;">This action is permanent and cannot be undone.</p>
    <div style="display:flex;gap:10px;justify-content:center;">
      <button class="mbtn danger" id="bulkDeleteConfirmBtn" style="min-width:100px;height:40px;border-radius:9px;font-weight:600;">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="margin-right:6px;vertical-align:middle;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
        Delete
      </button>
      <button class="mbtn" data-close="bulkDeleteModal" style="min-width:100px;height:40px;border-radius:9px;">Cancel</button>
    </div>
  </div>
</div>

<!-- Bulk Edit Type Modal -->
<div class="modal-backdrop" id="bulkEditTypeModal">
  <div class="modal">
    <button class="mclose" data-close="bulkEditTypeModal">✕</button>
    <div class="mtitle">Bulk Edit Stem Type</div>
    <p style="font-size:13px;color:var(--mu);margin-bottom:16px;" id="bulkEditTypeInfo"></p>
    <div class="mfield">
      <label>New Type</label>
      <select class="minput" id="bulkTypeInput">
        <option value="Acapella">Acapella</option>
        <option value="Drums">Drums</option>
        <option value="Bass">Bass</option>
        <option value="Melody">Melody</option>
        <option value="Instrumental">Instrumental</option>
      </select>
    </div>
    <div class="modal-btns">
      <button class="mbtn accent" id="bulkTypeSaveBtn">Apply to All Selected</button>
      <button class="mbtn" data-close="bulkEditTypeModal">Cancel</button>
    </div>
  </div>
</div>
<div class="modal-backdrop" id="editCustomerModal">
  <div class="modal">
    <button class="mclose" data-close="editCustomerModal">✕</button>
    <div class="mtitle">Edit Customer</div>
    <input type="hidden" id="editCustomerId"/>
    <div class="mfield"><label>Full Name</label><input type="text" class="minput" id="editCustomerName" placeholder="Full name"/></div>
    <div class="mfield"><label>Email</label><input type="email" class="minput" id="editCustomerEmail" placeholder="Email address"/></div>
    <div class="mfield"><label>Tier</label>
      <select class="minput" id="editCustomerTier">
        <option value="free">Free</option>
        <option value="web">Web Access</option>
        <option value="full">Full Download</option>
      </select>
    </div>
    <div class="mfield"><label>Status</label>
      <select class="minput" id="editCustomerStatus">
        <option value="active">Active</option>
        <option value="banned">Banned</option>
        <option value="suspended">Suspended</option>
      </select>
    </div>
    <div class="mfield"><label>New Password (leave empty to keep current)</label><input type="password" class="minput" id="editCustomerPassword" placeholder="New password"/></div>
    <div class="modal-btns">
      <button class="mbtn accent" id="saveCustomerBtn">Save Changes</button>
      <button class="mbtn" data-close="editCustomerModal">Cancel</button>
    </div>
  </div>
</div>

<!-- Edit Stem -->
<div class="modal-backdrop" id="editStemModal">
  <div class="modal">
    <button class="mclose" data-close="editStemModal">✕</button>
    <div class="mtitle">Edit Stem</div>
    <input type="hidden" id="editStemId"/>
    <div class="mfield"><label>Title</label><input type="text" class="minput" id="editStemTitle" placeholder="Title"/></div>
    <div class="mfield"><label>Artist</label><input type="text" class="minput" id="editStemArtist" placeholder="Artist"/></div>
    <div class="mfield"><label>Type</label>
      <select class="minput" id="editStemType">
        <option value="Acapella">Acapella</option>
        <option value="Drums">Drums</option>
        <option value="Bass">Bass</option>
        <option value="Melody">Melody</option>
        <option value="Instrumental">Instrumental</option>
      </select>
    </div>
    <div class="mfield"><label>BPM</label><input type="number" class="minput" id="editStemBpm" placeholder="BPM"/></div>
    <div class="mfield"><label>Key</label><input type="text" class="minput" id="editStemKey" placeholder="e.g. C Maj"/></div>
    <div class="mfield"><label>Genre</label><input type="text" class="minput" id="editStemGenre" placeholder="Genre"/></div>
    <div class="modal-btns">
      <button class="mbtn accent" id="saveStemBtn">Save Changes</button>
      <button class="mbtn" data-close="editStemModal">Cancel</button>
    </div>
  </div>
</div>

<!-- Email Compose -->
<div class="modal-backdrop" id="emailModal">
  <div class="modal wide">
    <button class="mclose" data-close="emailModal">✕</button>
    <div class="mtitle">Send Email</div>
    <p id="emailRecipientsInfo" style="font-size:12.5px;color:var(--mu);margin-bottom:14px;"></p>
    <div class="mfield"><label>Subject</label><input type="text" class="minput" id="emailSubject" placeholder="Email subject…"/></div>
    <div class="mfield"><label>Message</label><textarea class="minput" id="emailMessage" rows="6" placeholder="Write your message…" style="height:140px;resize:vertical;line-height:1.6;"></textarea></div>
    <div class="modal-btns">
      <button class="mbtn accent" id="sendEmailBtn">Send Email</button>
      <button class="mbtn" data-close="emailModal">Cancel</button>
    </div>
  </div>
</div>

<!-- Toast -->
<div class="toast" id="toast"></div>

@include('partials.delete-modal')

<script>
const API_BASE = '/manage-panel-x9k/api';
const CSRF     = document.querySelector('meta[name=csrf-token]')?.content || '';

let CUSTOMERS_CACHE = {};
let STEMS_CACHE     = {};

// ── UTILITIES ──────────────────────────────────────────
function showToast(msg, type='success'){
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.className   = 'toast ' + (type==='error' ? 'error' : 'success');
  t.style.display = 'block';
  clearTimeout(t._h);
  t._h = setTimeout(() => t.style.display='none', 3000);
}
function escHtml(s){
  if(s==null) return '';
  const d=document.createElement('div'); d.textContent=String(s); return d.innerHTML;
}
function openModal(id){ const e=document.getElementById(id); if(e) e.style.display='flex'; }
function closeModal(id){ const e=document.getElementById(id); if(!e) return; e.style.display='none'; }
function closeAudioModal(){
  const m=document.getElementById('audioPlayerModal');
  const a=document.getElementById('audioPlayer');
  if(a){ a.pause(); a.currentTime=0; }
  if(m) m.style.display='none';
}
function setLoading(tbodyId, cols){
  const el = document.getElementById(tbodyId);
  if(!el) return;
  el.innerHTML=`<tr><td colspan="${cols}" style="text-align:center;padding:40px;color:var(--mu2);">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--acc)" stroke-width="2"
      style="animation:spin .8s linear infinite;display:inline-block;vertical-align:middle;margin-right:8px">
      <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
    </svg>Loading…</td></tr>`;
}
async function apiPost(url, body={}){
  const res=await fetch(url,{method:'POST',headers:{'X-CSRF-TOKEN':CSRF,'Content-Type':'application/json'},body:JSON.stringify(body)});
  return res.json();
}
async function apiPut(url, body={}){
  const res=await fetch(url,{method:'PUT',headers:{'X-CSRF-TOKEN':CSRF,'Content-Type':'application/json'},body:JSON.stringify(body)});
  return res.json();
}
async function apiDelete(url){
  const res=await fetch(url,{method:'DELETE',headers:{'X-CSRF-TOKEN':CSRF,'Content-Type':'application/json'}});
  return res.json();
}

// Close modal on backdrop click
document.addEventListener('click', e => {
  const c=e.target.closest('[data-close]');
  if(c) closeModal(c.getAttribute('data-close'));
  if(e.target.classList.contains('modal-backdrop')) closeModal(e.target.id);
});

// ── TABS ──────────────────────────────────────────────
document.querySelectorAll('.admin-tab').forEach(tab => {
  tab.addEventListener('click', () => {
    document.querySelectorAll('.admin-tab').forEach(t=>t.classList.remove('active'));
    document.querySelectorAll('.admin-pane').forEach(p=>p.classList.remove('active'));
    tab.classList.add('active');
    const pane=document.getElementById('adminPane-'+tab.getAttribute('data-atab'));
    if(pane) pane.classList.add('active');
    const id=tab.getAttribute('data-atab');
    if(id==='customers') renderCustomers();
    if(id==='stems')     renderAdminStems();
    if(id==='email')     renderEmailJobs();
    if(id==='logs')      renderAuditLogs();
    if(id==='vault')     loadVaultGenres();
  });
});

// ── CUSTOMERS ─────────────────────────────────────────
let custPage=1;

function getTierBadge(t){
  if(t==='free') return '<span class="tier-badge tier-free">Free</span>';
  if(t==='web')  return '<span class="tier-badge tier-web">Web Access</span>';
  return '<span class="tier-badge tier-full">Full Download</span>';
}
function getStatusBadge(s){
  if(!s||s==='active') return '';
  if(s==='banned') return ' <span class="status-badge status-banned">Banned</span>';
  return ' <span class="status-badge status-suspended">Suspended</span>';
}
function updateBulkEmailBtn(){
  const checked=document.querySelectorAll('.cust-check:checked');
  const btn=document.getElementById('bulkEmailBtn');
  const cnt=document.getElementById('selectedCount');
  btn.style.display=checked.length>0?'flex':'none';
  if(cnt) cnt.textContent=checked.length;
}

async function renderCustomers(){
  setLoading('adminCustTbody',5);
  const search=(document.getElementById('adminCustSearch').value||'').trim();
  const tier=document.getElementById('adminCustFilter').value||'';
  let url=`${API_BASE}/customers?page=${custPage}&per_page=25`;
  if(search) url+=`&search=${encodeURIComponent(search)}`;
  if(tier)   url+=`&tier=${encodeURIComponent(tier)}`;
  try {
    const res=await fetch(url);
    if(!res.ok) throw new Error('HTTP '+res.status);
    const data=await res.json();
    const users=data.data||[];
    const lastPg=data.last_page||1;
    const tbody=document.getElementById('adminCustTbody');
    tbody.innerHTML=''; CUSTOMERS_CACHE={};
    if(!users.length){
      tbody.innerHTML='<tr><td colspan="5" style="text-align:center;padding:40px;color:var(--mu2);">No customers found</td></tr>';
      buildPag('adminCustPag',lastPg,custPage,p=>{custPage=p;renderCustomers();});
      return;
    }
    users.forEach(u=>{
      const tier=u.plan_tier||u.tier||'free';
      const status=u.status||'active';
      const joined=u.joined||(u.created_at?u.created_at.slice(0,10):'—');
      CUSTOMERS_CACHE[u.id]={...u,tier,status,joined};
      const tr=document.createElement('tr');
      tr.innerHTML=`
        <td><input type="checkbox" class="admin-check cust-check" value="${u.id}" data-email="${escHtml(u.email)}"/></td>
        <td style="font-size:13px;">${escHtml(u.email)}${getStatusBadge(status)}</td>
        <td>${getTierBadge(tier)}</td>
        <td style="font-size:13px;color:var(--mu);">${joined}</td>
        <td><div class="admin-actions">
          <button class="aact" title="Email" onclick="emailSingleCustomer(${u.id},'${escHtml(u.email)}')">
            <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="14" height="10" rx="1.2"/><path d="m1 5 7 5 7-5"/></svg>
          </button>
          <button class="aact" title="Edit" onclick="openEditCustomer(${u.id})">
            <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M11.5 2.5a2.12 2.12 0 0 1 3 3L5 15H1v-4z"/></svg>
          </button>
          <button class="aact del" title="Delete" onclick="deleteCustomer(${u.id},'${u.email}')">
            <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6"><polyline points="3 6 4.5 14 11.5 14 13 6"/><path d="M1 4h14M6 4V2h4v2"/></svg>
          </button>
        </div></td>`;
      tbody.appendChild(tr);
    });
    document.querySelectorAll('.cust-check').forEach(cb=>cb.addEventListener('change',updateBulkEmailBtn));
    document.getElementById('custCheckAll').checked=false;
    updateBulkEmailBtn();
    buildPag('adminCustPag',lastPg,custPage,p=>{custPage=p;renderCustomers();});
  } catch(err){
    console.error(err);
    document.getElementById('adminCustTbody').innerHTML=
      `<tr><td colspan="5" style="text-align:center;padding:40px;color:#e05050;">❌ Failed to load customers.</td></tr>`;
  }
}

function openEditCustomer(id){
  const u=CUSTOMERS_CACHE[id];
  if(!u){showToast('Data not found — refresh page','error');return;}
  document.getElementById('editCustomerId').value=u.id;
  document.getElementById('editCustomerName').value=u.name||'';
  document.getElementById('editCustomerEmail').value=u.email||'';
  document.getElementById('editCustomerTier').value=u.tier||u.plan_tier||'free';
  document.getElementById('editCustomerStatus').value=u.status||'active';
  document.getElementById('editCustomerPassword').value='';
  openModal('editCustomerModal');
}

document.getElementById('saveCustomerBtn').addEventListener('click', async()=>{
  const id=parseInt(document.getElementById('editCustomerId').value);
  const payload={
    name:     document.getElementById('editCustomerName').value.trim(),
    email:    document.getElementById('editCustomerEmail').value.trim(),
    plan_tier:document.getElementById('editCustomerTier').value,
    status:   document.getElementById('editCustomerStatus').value,
  };
  const pwd=document.getElementById('editCustomerPassword').value;
  if(pwd&&pwd.length>=8) payload.password=pwd;
  else if(pwd&&pwd.length){showToast('Password must be 8+ characters','error');return;}
  try {
    const data=await apiPut(`${API_BASE}/customers/${id}`,payload);
    if(data.success){closeModal('editCustomerModal');showToast('Customer updated');renderCustomers();}
    else showToast(data.message||'Update failed','error');
  } catch(e){showToast('Update failed — check connection','error');}
});

let custTimer;
document.getElementById('adminCustSearch').addEventListener('input',()=>{
  clearTimeout(custTimer); custTimer=setTimeout(()=>{custPage=1;renderCustomers();},350);
});
document.getElementById('adminCustFilter').addEventListener('change',()=>{custPage=1;renderCustomers();});
document.getElementById('custCheckAll').addEventListener('change',function(){
  document.querySelectorAll('.cust-check').forEach(cb=>cb.checked=this.checked);
  updateBulkEmailBtn();
});

document.getElementById('bulkEmailBtn').addEventListener('click',()=>{
  const checked=document.querySelectorAll('.cust-check:checked');
  const ids=Array.from(checked).map(cb=>parseInt(cb.value));
  const emails=Array.from(checked).map(cb=>cb.getAttribute('data-email'));
  if(!ids.length){showToast('Select at least one customer','error');return;}
  emailRecipients=ids;
  const preview=emails.slice(0,3).join(', ')+(emails.length>3?` +${emails.length-3} more`:'');
  document.getElementById('emailRecipientsInfo').textContent=`Sending to ${ids.length} customer(s): ${preview}`;
  document.getElementById('emailSubject').value='';
  document.getElementById('emailMessage').value='';
  openModal('emailModal');
});

function emailSingleCustomer(id,email){
  emailRecipients=[id];
  document.getElementById('emailRecipientsInfo').textContent='Sending to: '+email;
  document.getElementById('emailSubject').value='';
  document.getElementById('emailMessage').value='';
  openModal('emailModal');
}

document.getElementById('adminImportCSV').addEventListener('click',()=>{
  let fi=document.getElementById('csvFileInput');
  if(!fi){
    fi=document.createElement('input');
    fi.type='file';fi.id='csvFileInput';fi.accept='.csv';fi.style.display='none';
    document.body.appendChild(fi);
    fi.addEventListener('change',handleCsvImport);
  }
  fi.value='';fi.click();
});

async function handleCsvImport(e){
  const file=e.target.files[0];
  if(!file) return;
  const ext=file.name.split('.').pop().toLowerCase();
  if(ext!=='csv'){showToast('Please upload a .csv file','error');return;}
  showToast('Uploading CSV…');
  const fd=new FormData(); fd.append('csv',file);
  try {
    const res=await fetch(`${API_BASE}/customers/import-csv`,{method:'POST',headers:{'X-CSRF-TOKEN':CSRF},body:fd});
    let data;
    try{data=await res.json();}catch(jsonErr){
      showToast(`Server error ${res.status} — check Laravel logs`,'error');return;
    }
    if(res.status===422){showToast('Validation: '+(data.errors?.csv?.[0]||data.message||'Validation failed'),'error');return;}
    if(res.status===404){showToast('Route not found (404)','error');return;}
    if(!res.ok&&!data.success){showToast(data.message||`Server error ${res.status}`,'error');return;}
    showToast(`✓ ${data.imported||0} imported · ${data.skipped||0} skipped · ${data.failed||0} failed`);
    custPage=1;renderCustomers();
  }catch(err){showToast('Network error — check console','error');}
}

renderCustomers();

// ── STEMS ─────────────────────────────────────────────
let stemPage=1;

function getStemTypeBadge(t){
  const cls={Acapella:'atype-acapella',Drums:'atype-drums',Bass:'atype-bass',Melody:'atype-melody',Instrumental:'atype-instrumental'}[t]||'atype-acapella';
  return `<span class="atype-badge ${cls}">${t}</span>`;
}

// ── BULK STEMS LOGIC ──────────────────────────────────
function getSelectedStemIds() {
  return Array.from(document.querySelectorAll('.stem-check:checked')).map(cb => parseInt(cb.value));
}

function updateBulkStemBar() {
  const ids  = getSelectedStemIds();
  const bar  = document.getElementById('stemBulkBar');
  const info = document.getElementById('stemBulkInfo');
  if (ids.length > 0) {
    bar.classList.add('visible');
    info.textContent = `${ids.length} stem${ids.length > 1 ? 's' : ''} selected`;
  } else {
    bar.classList.remove('visible');
  }
}

// Checkbox change listener — renderAdminStems ke baad attach hoga
function attachStemCheckListeners() {
  document.querySelectorAll('.stem-check').forEach(cb => {
    cb.addEventListener('change', updateBulkStemBar);
  });
  document.getElementById('stemCheckAll').addEventListener('change', function() {
    document.querySelectorAll('.stem-check').forEach(cb => cb.checked = this.checked);
    updateBulkStemBar();
  });
}

// Bulk Delete
// Delete state
let bulkDeletePendingIds = [];

// Bulk Delete — button click
document.getElementById('bulkDeleteBtn').addEventListener('click', () => {
  const ids = getSelectedStemIds();
  if (!ids.length) return;
  bulkDeletePendingIds = ids;
  document.getElementById('bulkDeleteModalInfo').textContent =
    `You are about to permanently delete ${ids.length} stem${ids.length > 1 ? 's' : ''}.`;
  openModal('bulkDeleteModal');
});

// Single Delete
function deleteStem(id) {
  bulkDeletePendingIds = [id];
  const s = STEMS_CACHE[id];
  document.getElementById('bulkDeleteModalInfo').textContent =
    `You are about to permanently delete "${s?.title || 'this stem'}".`;
  openModal('bulkDeleteModal');
}

// Confirm button — handles both bulk and single
document.getElementById('bulkDeleteConfirmBtn').addEventListener('click', async () => {
  const ids = bulkDeletePendingIds;
  if (!ids.length) return;
  const btn = document.getElementById('bulkDeleteConfirmBtn');
  btn.disabled = true;
  btn.innerHTML = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation:spin .7s linear infinite;display:inline-block;vertical-align:middle;margin-right:6px;"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4"/></svg>Deleting…';
  try {
    const data = await apiPost(`${API_BASE}/stems/bulk-delete`, { stem_ids: ids });
    closeModal('bulkDeleteModal');
    if (data.success) {
      showToast(`✓ ${ids.length === 1 ? 'Stem' : ids.length + ' stems'} deleted`);
      stemPage = 1;
      renderAdminStems();
    } else {
      showToast(data.message || 'Delete failed', 'error');
    }
  } catch(e) {
    showToast('Delete failed', 'error');
  } finally {
    btn.disabled = false;
    btn.innerHTML = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="margin-right:6px;vertical-align:middle;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>Delete';
    bulkDeletePendingIds = [];
  }
});

// Bulk Hide
// document.getElementById('bulkHideBtn').addEventListener('click', async () => {
//   const ids = getSelectedStemIds();
//   if (!ids.length) { showToast('No stems selected', 'error'); return; }
//   try {
//     const data = await apiPost(`${API_BASE}/stems/bulk-visibility`, { stem_ids: ids, is_visible: false });
//     if (data.success) { showToast(`✓ ${ids.length} stem(s) hidden`); renderAdminStems(); }
//     else showToast(data.message || 'Failed', 'error');
//   } catch(e) { showToast('Failed', 'error'); }
// });

// Bulk Show
// document.getElementById('bulkShowBtn').addEventListener('click', async () => {
//   const ids = getSelectedStemIds();
//   if (!ids.length) { showToast('No stems selected', 'error'); return; }
//   try {
//     const data = await apiPost(`${API_BASE}/stems/bulk-visibility`, { stem_ids: ids, is_visible: true });
//     if (data.success) { showToast(`✓ ${ids.length} stem(s) visible`); renderAdminStems(); }
//     else showToast(data.message || 'Failed', 'error');
//   } catch(e) { showToast('Failed', 'error'); }
// });

// Bulk Edit Genre — button click
document.getElementById('bulkEditGenreBtn').addEventListener('click', () => {
  const ids = getSelectedStemIds();
  if (!ids.length) { showToast('No stems selected', 'error'); return; }
  document.getElementById('bulkEditGenreInfo').textContent = `Editing genre for ${ids.length} stem(s)`;
  document.getElementById('bulkGenreInput').value = '';
  openModal('bulkEditGenreModal');
});

// Bulk Edit Genre — save
document.getElementById('bulkGenreSaveBtn').addEventListener('click', async () => {
  const ids   = getSelectedStemIds();
  const genre = document.getElementById('bulkGenreInput').value.trim();
  if (!genre) { showToast('Please enter a genre', 'error'); return; }
  const btn = document.getElementById('bulkGenreSaveBtn');
  btn.disabled = true; btn.textContent = 'Saving…';
  try {
    // Har stem update karo ek ek karke
    let success = 0;
    for (const id of ids) {
      const s = STEMS_CACHE[id];
      if (!s) continue;
      const data = await apiPut(`${API_BASE}/stems/${id}`, {
        title: s.title, artist: s.artist,
        stem_type: s.stem_type || s.type,
        bpm: s.bpm, musical_key: s.musical_key || s.key,
        genre: genre
      });
      if (data.success) success++;
    }
    closeModal('bulkEditGenreModal');
    showToast(`✓ ${success} stem(s) genre updated to "${genre}"`);
    renderAdminStems();
  } catch(e) { showToast('Update failed', 'error'); }
  finally { btn.disabled = false; btn.textContent = 'Apply to All Selected'; }
});

// Bulk Edit Type — button click
document.getElementById('bulkEditTypeBtn').addEventListener('click', () => {
  const ids = getSelectedStemIds();
  if (!ids.length) { showToast('No stems selected', 'error'); return; }
  document.getElementById('bulkEditTypeInfo').textContent = `Editing type for ${ids.length} stem(s)`;
  openModal('bulkEditTypeModal');
});

// Bulk Edit Type — save
document.getElementById('bulkTypeSaveBtn').addEventListener('click', async () => {
  const ids  = getSelectedStemIds();
  const type = document.getElementById('bulkTypeInput').value;
  const btn  = document.getElementById('bulkTypeSaveBtn');
  btn.disabled = true; btn.textContent = 'Saving…';
  try {
    let success = 0;
    for (const id of ids) {
      const s = STEMS_CACHE[id];
      if (!s) continue;
      const data = await apiPut(`${API_BASE}/stems/${id}`, {
        title: s.title, artist: s.artist,
        stem_type: type,
        bpm: s.bpm, musical_key: s.musical_key || s.key,
        genre: s.genre
      });
      if (data.success) success++;
    }
    closeModal('bulkEditTypeModal');
    showToast(`✓ ${success} stem(s) type updated to "${type}"`);
    renderAdminStems();
  } catch(e) { showToast('Update failed', 'error'); }
  finally { btn.disabled = false; btn.textContent = 'Apply to All Selected'; }
});

async function renderAdminStems(){
  setLoading('adminStemTbody',9);
  const search=(document.getElementById('adminStemSearch').value||'').trim();
  const stemType=document.getElementById('adminStemTypeFilter').value||'';
  const sort=document.getElementById('adminStemSort').value||'recent';
  let url=`${API_BASE}/stems?page=${stemPage}&per_page=25&sort=${sort}`;
  if(search)   url+=`&search=${encodeURIComponent(search)}`;
  if(stemType) url+=`&stem_type=${encodeURIComponent(stemType)}`;
  try {
    const res=await fetch(url);
    if(!res.ok) throw new Error('HTTP '+res.status);
    const data=await res.json();
    const stems=data.data||[];
    const lastPg=data.last_page||1;
    const tbody=document.getElementById('adminStemTbody');
    tbody.innerHTML='';STEMS_CACHE={};
    if(!stems.length){
      tbody.innerHTML='<tr><td colspan="9" style="text-align:center;padding:40px;color:var(--mu2);">No stems found</td></tr>';
      buildPag('adminStemPag',lastPg,stemPage,p=>{stemPage=p;renderAdminStems();});
      return;
    }
    stems.forEach(s=>{
      const isHidden=s.is_visible===false||s.is_visible===0;
      const key=s.musical_key||s.key||'—';
      const type=s.stem_type||s.type||'—';
      STEMS_CACHE[s.id]={...s,key,type,isHidden};
      const tr=document.createElement('tr');

      // Add hidden class to entire row if stem is hidden
      if(isHidden) {
        tr.classList.add('stem-row-hidden');
      }

      tr.innerHTML=`
        <td><input type="checkbox" class="admin-check stem-check" value="${s.id}"/></td>
        <td style="font-weight:500;font-size:13px;">${escHtml(s.title)}</td>
        <td style="font-size:13px;color:var(--mu);">${escHtml(s.artist)}</td>
        <td>${getStemTypeBadge(type)}</td>
        <td style="font-family:'Share Tech Mono',monospace;font-size:13px;">${s.bpm}</td>
        <td style="font-size:13px;color:var(--mu);">${key}</td>
        <td style="font-size:13px;color:var(--mu);">${escHtml(s.genre)}</td>
        <td>${isHidden ? '<span class="astatus-hidden">Hidden</span>' : ''}</td>
        <td><div class="admin-actions">
          <button class="aact" title="Edit" onclick="openEditStem(${s.id})">
            <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M11.5 2.5a2.12 2.12 0 0 1 3 3L5 15H1v-4z"/></svg>
          </button>
          <button class="aact" title="${isHidden?'Show':'Hide'}" onclick="toggleStemVisibility(${s.id})">
            ${isHidden
              ? '<svg width="12" height="12" viewBox="0 0 20 14" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M1 7S4 1 10 1s9 6 9 6-3 6-9 6-9-6-9-6z"/><circle cx="10" cy="7" r="2.5"/></svg>'
              : '<svg width="12" height="12" viewBox="0 0 20 18" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M1 1l18 16M8.5 3.2A7 7 0 0 1 10 3c6 0 9 6 9 6a16.4 16.4 0 0 1-2.5 3.3M5.2 5.2A16.4 16.4 0 0 0 1 9s3 6 9 6a7 7 0 0 0 4.8-1.8"/></svg>'
            }
          </button>
          <button class="aact del" title="Delete" onclick="deleteStem(${s.id})">
            <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6"><polyline points="3 6 4.5 14 11.5 14 13 6"/><path d="M1 4h14M6 4V2h4v2"/></svg>
          </button>
        </div></td>
      `;
      tbody.appendChild(tr);
    });

    const checkAll = document.getElementById('stemCheckAll');
    if(checkAll) checkAll.checked = false;
    attachStemCheckListeners();
updateBulkStemBar();

    buildPag('adminStemPag',lastPg,stemPage,p=>{stemPage=p;renderAdminStems();});
  }catch(err){
    console.error(err);
    document.getElementById('adminStemTbody').innerHTML=
      `<tr><td colspan="9" style="text-align:center;padding:40px;color:#e05050;">❌ Failed to load stems.</td></tr>`;
  }
}

function openEditStem(id){
  const s=STEMS_CACHE[id];
  if(!s){showToast('Stem data not found','error');return;}
  document.getElementById('editStemId').value=s.id;
  document.getElementById('editStemTitle').value=s.title||'';
  document.getElementById('editStemArtist').value=s.artist||'';
  document.getElementById('editStemType').value=s.stem_type||s.type||'Acapella';
  document.getElementById('editStemBpm').value=s.bpm||'';
  document.getElementById('editStemKey').value=s.musical_key||s.key||'';
  document.getElementById('editStemGenre').value=s.genre||'';
  openModal('editStemModal');
}

document.getElementById('saveStemBtn').addEventListener('click',async()=>{
  const id=parseInt(document.getElementById('editStemId').value);
  const payload={
    title:      document.getElementById('editStemTitle').value.trim(),
    artist:     document.getElementById('editStemArtist').value.trim(),
    stem_type:  document.getElementById('editStemType').value,
    bpm:        parseInt(document.getElementById('editStemBpm').value)||0,
    musical_key:document.getElementById('editStemKey').value.trim(),
    genre:      document.getElementById('editStemGenre').value.trim(),
  };
  try {
    const data=await apiPut(`${API_BASE}/stems/${id}`,payload);
    if(data.success){closeModal('editStemModal');showToast('Stem updated');renderAdminStems();}
    else showToast(data.message||'Update failed','error');
  }catch(e){showToast('Update failed','error');}
});

async function toggleStemVisibility(id){
  try {
    const data=await apiPost(`${API_BASE}/stems/${id}/toggle-visibility`);
    if(data.success){showToast(data.message);renderAdminStems();}
    else showToast(data.message||'Failed','error');
  }catch(e){showToast('Failed','error');}
}

// async function deleteStem(id){
//   if(!confirm('Delete this stem? Cannot be undone.')) return;
//   try {
//     const data=await apiPost(`${API_BASE}/stems/bulk-delete`,{stem_ids:[id]});
//     if(data.success){showToast('Stem deleted');renderAdminStems();}
//     else showToast(data.message||'Delete failed','error');
//   }catch(e){showToast('Delete failed','error');}
// }

let stemTimer;
document.getElementById('adminStemSearch').addEventListener('input',()=>{
  clearTimeout(stemTimer);stemTimer=setTimeout(()=>{stemPage=1;renderAdminStems();},350);
});
document.getElementById('adminStemTypeFilter').addEventListener('change',()=>{stemPage=1;renderAdminStems();});
document.getElementById('adminStemSort').addEventListener('change',()=>{stemPage=1;renderAdminStems();});
// document.getElementById('stemCheckAll').addEventListener('change',function(){
//   document.querySelectorAll('.stem-check').forEach(cb=>cb.checked=this.checked);
// });

// ── EMAIL ─────────────────────────────────────────────
let emailRecipients=[];

document.getElementById('newEmailBtn').addEventListener('click',async()=>{
  emailRecipients='all';
  document.getElementById('emailRecipientsInfo').textContent='Sending to ALL customers';
  document.getElementById('emailSubject').value='';
  document.getElementById('emailMessage').value='';
  openModal('emailModal');
});

document.getElementById('sendEmailBtn').addEventListener('click',async()=>{
  const subject=document.getElementById('emailSubject').value.trim();
  const message=document.getElementById('emailMessage').value.trim();
  if(!subject){showToast('Please enter a subject','error');return;}
  if(!message){showToast('Please enter a message','error');return;}
  const btn=document.getElementById('sendEmailBtn');
  btn.disabled=true;btn.textContent='Sending…';
  try {
    let payload;
    if(emailRecipients==='all'){
      const res=await fetch(`${API_BASE}/customers?per_page=1000`);
      const d=await res.json();
      const ids=(d.data||[]).map(u=>u.id);
      payload={subject,message,user_ids:ids};
    }else{
      payload={subject,message,user_ids:emailRecipients};
    }
    const data=await apiPost(`${API_BASE}/email/send`,payload);
    if(data.success){
      closeModal('emailModal');
      document.querySelectorAll('.cust-check').forEach(cb=>cb.checked=false);
      document.getElementById('custCheckAll').checked=false;
      updateBulkEmailBtn();
      showToast(data.message||'Email sent!');
      emailRecipients=[];
      renderEmailJobs();
    }else showToast(data.message||'Send failed','error');
  }catch(e){showToast('Send failed — check connection','error');}
  finally{btn.disabled=false;btn.textContent='Send Email';}
});

async function renderEmailJobs(){
  const tbody=document.getElementById('emailJobsBody');
  if(!tbody) return;
  tbody.innerHTML='<tr><td colspan="7" style="text-align:center;padding:24px;color:var(--mu2);">Loading…</td></tr>';
  try {
    const res=await fetch(`${API_BASE}/email/jobs`);
    const data=await res.json();
    const jobs=data.data||[];
    if(!jobs.length){tbody.innerHTML='<tr><td colspan="7" style="text-align:center;padding:40px;color:var(--mu2);">No email jobs found</td></tr>';return;}
    tbody.innerHTML='';
    jobs.forEach(j=>{
      const tr=document.createElement('tr');
      const created=j.created_at?j.created_at.slice(0,16).replace('T',' '):'—';
      tr.innerHTML=`
        <td style="color:var(--mu);font-family:'Share Tech Mono',monospace;">#${j.id}</td>
        <td style="font-size:13px;">${escHtml(j.subject)}</td>
        <td style="font-size:13px;">${Array.isArray(j.recipient_scope)?j.recipient_scope.length:'—'}</td>
        <td style="font-size:13px;color:#4ade80;">${j.sent_count??'—'}</td>
        <td style="font-size:13px;color:var(--mu2);">${j.failed_count??0}</td>
        <td><span class="status-badge status-active">${escHtml(j.status||'sent')}</span></td>
        <td style="color:var(--mu);font-size:12px;">${created}</td>`;
      tbody.appendChild(tr);
    });
  }catch(e){tbody.innerHTML='<tr><td colspan="7" style="text-align:center;padding:40px;color:#e05050;">❌ Failed to load email jobs</td></tr>';}
}

// ── AUDIT LOGS ────────────────────────────────────────
function getLogActionBadge(a){
  const map={
    'edit_stem':         '<span class="log-action log-edit">✏ Edit Stem</span>',
    'toggle_visibility': '<span class="log-action log-visibility">👁 Toggle Visibility</span>',
    'bulk_visibility':   '<span class="log-action log-bulk">📦 Bulk Visibility</span>',
    'bulk_delete':       '<span class="log-action log-bulk">🗑 Bulk Delete</span>',
    'update_user_status':'<span class="log-action log-user">👤 User Status</span>',
    'update_user_tier':  '<span class="log-action log-user">⭐ User Tier</span>',
    'update_user':       '<span class="log-action log-edit">✏ Edit User</span>',
    'send_email':        '<span class="log-action log-email">📧 Send Email</span>',
    'reset_password':    '<span class="log-action log-user">🔑 Reset Password</span>',
  };
  return map[a]||`<span class="log-action">${escHtml(a)}</span>`;
}

async function renderAuditLogs(){
  setLoading('auditLogsBody',5);
  const filter=document.getElementById('actionFilter').value||'';
  let url=`${API_BASE}/audit-logs?per_page=50`;
  if(filter) url+=`&action_type=${encodeURIComponent(filter)}`;
  try {
    const res=await fetch(url);
    const data=await res.json();
    const logs=data.data||[];
    const tbody=document.getElementById('auditLogsBody');
    tbody.innerHTML='';
    if(!logs.length){tbody.innerHTML='<tr><td colspan="5" style="text-align:center;padding:40px;color:var(--mu2);">No audit logs found</td></tr>';return;}
    logs.forEach(l=>{
      const adminName=l.admin?(l.admin.name||l.admin.email||'—'):'—';
      const details=l.details?(typeof l.details==='object'?JSON.stringify(l.details).slice(0,80):String(l.details).slice(0,80)):'—';
      const time=l.created_at?l.created_at.slice(0,16).replace('T',' '):'—';
      const tr=document.createElement('tr');
      tr.innerHTML=`
        <td style="font-size:13px;">${escHtml(adminName)}</td>
        <td>${getLogActionBadge(l.action_type)}</td>
        <td style="font-size:12px;color:var(--mu);">${escHtml(l.target_type||'—')} ${l.target_id?'#'+l.target_id:''}</td>
        <td style="font-size:12px;color:var(--mu2);">${escHtml(details)}</td>
        <td style="font-size:12px;color:var(--mu);">${time}</td>`;
      tbody.appendChild(tr);
    });
  }catch(e){
    document.getElementById('auditLogsBody').innerHTML=
      '<tr><td colspan="5" style="text-align:center;padding:40px;color:#e05050;">❌ Failed to load logs</td></tr>';
  }
}
document.getElementById('actionFilter').addEventListener('change',renderAuditLogs);

// ── HEADER BUTTONS ────────────────────────────────────
document.getElementById('adminViewSiteBtn')?.addEventListener('click', () => {
  // Home page par redirect karein
  window.location.href = '/';
});

document.getElementById('adminLogoutBtn')?.addEventListener('click', async () => {
  showToast('Logging you out...', 'info');

  try {
    const response = await fetch('/logout', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': CSRF,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      credentials: 'same-origin'
    });

    if (response.ok) {
      showToast('Logged out successfully! Redirecting...', 'success');
      setTimeout(() => {
        window.location.href = '/';
      }, 1200);
    } else {
      showToast('Logout failed. Please try again.', 'error');
    }
  } catch(e) {
    console.error('Logout error:', e);
    showToast('Network error. Please try again.', 'error');
  }
});

document.getElementById('adminLogoutBtn')?.addEventListener('click', async () => {
  // Show toast instead of confirm
  showToast('Logging out...', 'info');

  try {
    const response = await fetch('/logout', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': CSRF,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      credentials: 'same-origin'
    });

    if (response.ok) {
      showToast('Logged out successfully!', 'success');
      setTimeout(() => {
        window.location.href = '/';
      }, 1000);
    } else {
      showToast('Logout failed. Please try again.', 'error');
    }
  } catch(e) {
    console.error('Logout error:', e);
    showToast('Something went wrong!', 'error');
  }
});

// ── PAGINATION ────────────────────────────────────────
function buildPag(containerId, totalPages, current, onPage){
  const pag=document.getElementById(containerId);
  if(!pag) return;
  pag.innerHTML='';
  if(totalPages<=1) return;
  const prev=document.createElement('button');
  prev.className='pag-arr';prev.textContent='←';prev.disabled=current<=1;
  prev.addEventListener('click',()=>{if(current>1) onPage(current-1);});
  pag.appendChild(prev);
  const start=Math.max(1,current-2),end=Math.min(totalPages,current+2);
  if(start>1){
    const b=document.createElement('button');b.className='pag-num';b.textContent='1';
    b.addEventListener('click',()=>onPage(1));pag.appendChild(b);
    if(start>2){const d=document.createElement('span');d.textContent='…';d.style.cssText='padding:0 4px;opacity:.4;font-size:13px;';pag.appendChild(d);}
  }
  for(let i=start;i<=end;i++){
    const b=document.createElement('button');b.className='pag-num'+(i===current?' active':'');
    b.textContent=i;const _i=i;b.addEventListener('click',()=>onPage(_i));pag.appendChild(b);
  }
  if(end<totalPages){
    if(end<totalPages-1){const d=document.createElement('span');d.textContent='…';d.style.cssText='padding:0 4px;opacity:.4;font-size:13px;';pag.appendChild(d);}
    const b=document.createElement('button');b.className='pag-num';b.textContent=totalPages;
    b.addEventListener('click',()=>onPage(totalPages));pag.appendChild(b);
  }
  const next=document.createElement('button');
  next.className='pag-arr';next.textContent='→';next.disabled=current>=totalPages;
  next.addEventListener('click',()=>{if(current<totalPages) onPage(current+1);});
  pag.appendChild(next);
}


// ── VAULT ADMIN ──────────────────────────────────────
var VAULT_GENRES = []; // populated from API

async function loadVaultGenres() {
  setLoading('vaultGenreTbody', 7);
  try {
    const res  = await fetch('https://songotsamples.com/api/vault/genres');
    if (!res.ok) throw new Error('HTTP ' + res.status);
    const data = await res.json();

    // Merge with DB meta (hidden/desc/tags overrides)
    const metaRes  = await fetch(`${API_BASE}/vault/genres/meta`);
    const metaData = metaRes.ok ? await metaRes.json() : { meta: {} };
    const metaMap  = metaData.meta || {};

    VAULT_GENRES = (data.genres || []).map(g => ({
      ...g,
      desc:   metaMap[g.id]?.description ?? g.desc ?? '',
      tags:   metaMap[g.id]?.tags        ?? g.tags ?? [],
      hidden: metaMap[g.id]?.is_hidden   ?? false,
    }));

    renderVaultGenreTable();
  } catch(e) {
    document.getElementById('vaultGenreTbody').innerHTML =
      '<tr><td colspan="7" style="text-align:center;padding:40px;color:#e05050;">❌ Failed to load vault genres.</td></tr>';
  }
}

function renderVaultGenreTable() {
  const q  = (document.getElementById('vaultGenreSearch').value || '').toLowerCase();
  const sf = document.getElementById('vaultGenreStatusFilter').value;
  const list = VAULT_GENRES.filter(g => {
    const mq = !q || g.name.toLowerCase().includes(q) ||
               (g.tags||[]).join(' ').toLowerCase().includes(q) ||
               (g.desc||'').toLowerCase().includes(q);
    const ms = !sf || (sf === 'active' && !g.hidden) || (sf === 'hidden' && g.hidden);
    return mq && ms;
  });
  const tb = document.getElementById('vaultGenreTbody');
  if (!tb) return;
  tb.innerHTML = '';
  if (!list.length) {
    tb.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:40px;color:var(--mu2);">No genres found</td></tr>';
    return;
  }
  list.forEach(g => tb.appendChild(makeVaultGenreRow(g, false)));
}

function makeVaultGenreRow(g, isEditing) {
  const tr = document.createElement('tr');
  if (g.hidden)  tr.classList.add('row-hidden');
  if (isEditing) tr.classList.add('editing');

  if (isEditing) {
    tr.innerHTML = `
      <td><input class="edit-input md" id="vi-name-${g.id}" value="${escHtml(g.name)}" readonly style="opacity:.5;cursor:not-allowed;" title="Genre name comes from music library"></td>
      <td style="min-width:220px;">
        <input class="edit-input" id="vi-desc-${g.id}" value="${escHtml(g.desc||'')}" maxlength="240" oninput="vaultCharCount('${g.id}')">
        <div style="font-size:10px;color:var(--mu2);margin-top:3px;text-align:right;" id="vcc-${g.id}">${(g.desc||'').length} / 240</div>
      </td>
      <td style="font-family:'Share Tech Mono',monospace;font-size:12px;">${(g.stems||0).toLocaleString()}</td>
      <td style="font-size:12px;color:var(--mu);">${escHtml(g.size||'—')}</td>
      <td><input class="edit-input" id="vi-tags-${g.id}" value="${escHtml((g.tags||[]).join(', '))}" style="min-width:150px;"></td>
      <td><span class="vbadge ${g.hidden?'vbadge-hidden':'vbadge-active'}">${g.hidden?'Hidden':'Active'}</span></td>
      <td><div class="admin-actions">
        <button class="aact save" title="Save" onclick="saveVaultGenre('${g.id}')">
          <svg width="11" height="11" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 8l4 4 8-8"/></svg>
        </button>
        <button class="aact cancel" title="Cancel" onclick="renderVaultGenreTable()">
          <svg width="11" height="11" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3l10 10M13 3L3 13"/></svg>
        </button>
      </div></td>`;
  } else {
    const tagsHtml = (g.tags||[]).map(t => `<span class="vbadge vbadge-tag">${escHtml(t)}</span>`).join('');
    tr.innerHTML = `
      <td style="font-weight:500;">${escHtml(g.name)}</td>
      <td style="font-size:12px;color:var(--mu);max-width:240px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="${escHtml(g.desc||'')}">${escHtml(g.desc||'—')}</td>
      <td style="font-family:'Share Tech Mono',monospace;font-size:12px;">${(g.stems||0).toLocaleString()}</td>
      <td style="font-size:12px;color:var(--mu);">${escHtml(g.size||'—')}</td>
      <td>${tagsHtml||'<span style="color:var(--mu2);font-size:12px;">—</span>'}</td>
      <td><span class="vbadge ${g.hidden?'vbadge-hidden':'vbadge-active'}">${g.hidden?'Hidden':'Active'}</span></td>
      <td><div class="admin-actions">
        <button class="aact" title="Edit" onclick="editVaultGenre('${g.id}')">
          <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M11.5 2.5a2.12 2.12 0 0 1 3 3L5 15H1v-4z"/></svg>
        </button>
        <button class="aact" title="${g.hidden?'Show':'Hide'}" onclick="toggleVaultGenre('${g.id}')">
          ${g.hidden
            ? '<svg width="12" height="12" viewBox="0 0 20 14" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M1 7S4 1 10 1s9 6 9 6-3 6-9 6-9-6-9-6z"/><circle cx="10" cy="7" r="2.5"/></svg>'
            : '<svg width="12" height="12" viewBox="0 0 20 18" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M1 1l18 16M8.5 3.2A7 7 0 0 1 10 3c6 0 9 6 9 6a16.4 16.4 0 0 1-2.5 3.3M5.2 5.2A16.4 16.4 0 0 0 1 9s3 6 9 6a7 7 0 0 0 4.8-1.8"/></svg>'}
        </button>
      </div></td>`;
  }
  return tr;
}

function editVaultGenre(id) {
  const g = VAULT_GENRES.find(x => x.id === id);
  if (!g) return;
  const tb   = document.getElementById('vaultGenreTbody');
  const rows = tb.querySelectorAll('tr');
  rows.forEach(row => {
    if (row.cells[0] && row.cells[0].textContent.trim() === g.name) {
      row.parentNode.replaceChild(makeVaultGenreRow(g, true), row);
    }
  });
}

async function saveVaultGenre(id) {
  const g = VAULT_GENRES.find(x => x.id === id);
  if (!g) return;
  const newDesc = document.getElementById('vi-desc-'+id).value.trim();
  const rawTags = document.getElementById('vi-tags-'+id).value;
  const newTags = rawTags.split(',').map(t => t.trim()).filter(Boolean);
  if (newDesc.length > 240) { showToast('Description over 240 chars', 'error'); return; }

  const btn = document.querySelector(`#vaultGenreTbody .aact.save`);
  if (btn) { btn.disabled = true; }

  try {
    const data = await apiPut(`${API_BASE}/vault/genres/${id}`, {
      description: newDesc,
      tags:        newTags,
    });
    if (data.success) {
      g.desc = newDesc;
      g.tags = newTags;
      showToast('Genre "' + g.name + '" saved');
      renderVaultGenreTable();
    } else {
      showToast(data.message || 'Save failed', 'error');
    }
  } catch(e) {
    showToast('Save failed — check connection', 'error');
  }
}

async function toggleVaultGenre(id) {
  const g = VAULT_GENRES.find(x => x.id === id);
  if (!g) return;
  try {
    const data = await apiPost(`${API_BASE}/vault/genres/${id}/toggle`);
    if (data.success) {
      g.hidden = data.is_hidden;
      showToast(data.message || (g.hidden ? 'Genre hidden' : 'Genre visible'));
      renderVaultGenreTable();
    } else {
      showToast(data.message || 'Toggle failed', 'error');
    }
  } catch(e) {
    showToast('Toggle failed', 'error');
  }
}

function vaultCharCount(id) {
  const el = document.getElementById('vi-desc-'+id);
  const cc = document.getElementById('vcc-'+id);
  if (!el || !cc) return;
  const len = el.value.length;
  cc.textContent = len + ' / 240';
  cc.style.color = len > 220 ? '#e05050' : 'var(--mu2)';
}

document.getElementById('vaultGenreSearch').addEventListener('input', renderVaultGenreTable);
document.getElementById('vaultGenreStatusFilter').addEventListener('change', renderVaultGenreTable);
</script>
</body>
</html>
