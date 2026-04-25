<section id="page-vault" class="page">
  <div style="max-width:1100px;margin:0 auto;padding:40px 24px 80px;">

    {{-- Header --}}
    <div style="margin-bottom:40px;">
      <h1 style="font-family:'Exo 2',sans-serif;font-size:clamp(28px,4vw,48px);font-weight:200;letter-spacing:.02em;margin:0 0 12px;">The Vault</h1>
      <p style="font-size:14px;color:var(--mu);max-width:600px;line-height:1.7;margin:0;">
        The complete stem library, organized by genre for fast, streamlined access.<br>
        Each genre is sorted alphabetically by artist and every song folder contains five stem parts, labeled with BPM and key.
      </p>
      @if(!(auth()->check() && auth()->user()->plan_tier === 'full'))
        <div style="margin-top:16px;padding:10px 16px;background:rgba(240,200,96,.1);border:1px solid rgba(240,200,96,.2);border-radius:10px;display:inline-block;">
          <span style="font-size:13px;color:#f0c860;">🔒 Full Access required to download. <a href="/pricing" style="color:#6074ff;text-decoration:underline;">Upgrade now →</a></span>
        </div>
      @endif
    </div>

    {{-- Stats Row --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.07);border-radius:14px;overflow:hidden;margin-bottom:48px;">
      <div style="text-align:center;padding:20px 12px;background:var(--bg);">
        <div style="font-family:'Exo 2',sans-serif;font-size:2rem;font-weight:300;color:var(--tx);" id="statStems">—</div>
        <div style="font-size:10px;text-transform:uppercase;letter-spacing:.1em;color:var(--mu);margin-top:4px;">Total Stems</div>
      </div>
      <div style="text-align:center;padding:20px 12px;background:var(--bg);border-left:1px solid rgba(255,255,255,.07);border-right:1px solid rgba(255,255,255,.07);">
        <div style="font-family:'Exo 2',sans-serif;font-size:2rem;font-weight:300;color:var(--tx);" id="statGenres">—</div>
        <div style="font-size:10px;text-transform:uppercase;letter-spacing:.1em;color:var(--mu);margin-top:4px;">Genres</div>
      </div>
      <div style="text-align:center;padding:20px 12px;background:var(--bg);">
        <div style="font-family:'Exo 2',sans-serif;font-size:2rem;font-weight:300;color:var(--tx);" id="statSize">—</div>
        <div style="font-size:10px;text-transform:uppercase;letter-spacing:.1em;color:var(--mu);margin-top:4px;">Library Size</div>
      </div>
    </div>

    {{-- Genre Grid --}}
    <div id="genreGrid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;"></div>

    {{-- Live Sync --}}
    <div style="display:flex;align-items:center;gap:12px;margin-top:48px;padding:14px 20px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06);border-radius:12px;">
      <div style="width:8px;height:8px;border-radius:50%;background:#23c99a;flex-shrink:0;animation:vaultPulse 2s infinite;"></div>
      <span style="font-size:12.5px;color:var(--mu);"><strong style="color:var(--tx);font-weight:500;">Live sync.</strong> Every stem uploaded populates here automatically. Nothing manual, nothing missed.</span>
    </div>

    {{-- Footer --}}
    <div style="margin-top:50px;padding-top:20px;border-top:1px solid rgba(255,255,255,.06);text-align:center;font-size:11px;color:var(--mu2);">
      <span>© Son Got Samples 2026</span>
      <span style="margin:0 8px;">·</span>
      <a href="#" style="color:var(--mu2);">Privacy Policy</a>
      <span style="margin:0 8px;">·</span>
      <a href="#" style="color:var(--mu2);">Terms of Service</a>
    </div>
  </div>
</section>

<style>
@keyframes vaultPulse {
  0%,100%{opacity:1;transform:scale(1);}
  50%{opacity:.5;transform:scale(.85);}
}

.vault-card {
  background: linear-gradient(180deg, rgba(255, 255, 255, .03), rgba(255, 255, 255, .015));
  border: 1px solid var(--di);
  border-radius: 14px;
  padding: 22px 22px 20px;
  display: flex;
  flex-direction: column;
  min-height: 320px;
  transition: border-color .2s, transform .2s;
}
.vault-card:hover {
  border-color: var(--me);
  transform: translateY(-2px);
}



.vault-card:hover {
  border-color: #6074ff;
  transform: translateY(-2px);
}
.vault-card-top {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 14px;
}
.vault-card-name {
  font-family: 'Exo 2', sans-serif;
  font-size: 20px;
  font-weight: 400;
  letter-spacing: .05em;
  text-transform: uppercase;
  color: var(--tx);
}
.vault-card-meta {
  text-align: right;
  font-family: 'Share Tech Mono', monospace;
  font-size: 11.5px;
  color: var(--mu);
  line-height: 1.7;
}
.vault-card-desc {
  font-size: 13px;
  color: var(--mu);
  line-height: 1.65;
  margin-bottom: 18px;
  flex: 1;
}
.vault-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 7px;
  margin-bottom: 20px;
}
.vault-tag {
  font-size: 9.5px;
  font-family: 'Exo 2', sans-serif;
  letter-spacing: .08em;
  text-transform: uppercase;
  padding: 4px 11px;
  background: var(--pb);
  border: 1px solid var(--di);
  border-radius: 20px;
  color: var(--mu2);
}
.vault-divider {
  height: 1px;
  background: var(--di);
  margin-bottom: 18px;
}
.vault-dl-btn {
  width: 100%;
  height: 44px;
  border-radius: 9px;
  background: var(--pb);
  border: 1px solid var(--di);
  color: var(--tx);
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 9px;
  transition: background .2s, border-color .2s;
  position: relative;
  overflow: hidden;
  font-family: inherit;
  margin-top: auto;
}
.vault-dl-btn:hover { background: var(--hg); border-color: var(--me); }

.vault-dl-btn.accent {
  background: var(--pb2);
  border-color: var(--me);
  color: var(--tx);
  box-shadow: none;
}
.vault-dl-btn.accent:hover {
  background: var(--hg);
  border-color: var(--acc);
  box-shadow: none;
}
.vault-dl-btn::before {
  content: '';
  position: absolute;
  top: 0; left: -100%;
  width: 100%; height: 100%;
  background: linear-gradient(90deg,
    transparent,
    rgba(255,255,255,.12),
    rgba(255,255,255,.30),
    rgba(255,255,255,.12),
    transparent
  );
  pointer-events: none;
}

.vault-dl-btn:hover::before {
  animation: vaultShimmer 0.8s ease infinite;
}

@keyframes vaultShimmer {
  0%   { left: -100%; }
  100% { left: 100%; }
}
.vault-dl-btn:hover { background: rgba(255,255,255,.1); border-color: rgba(255,255,255,.22); }
.vault-dl-btn:hover::before { left: 100%; }
.vault-dl-btn.accent {
  background: #0d1117;
  border-color: rgba(255,255,255,.18);
  color: #fff;
  box-shadow: none;
}

.vault-dl-btn.accent:hover {
  background: #0a0e1a;
  border-color: rgba(255,255,255,.35);
  box-shadow: none;
}
@media(max-width:860px){
  #genreGrid { grid-template-columns: repeat(2,1fr) !important; }
}
@media(max-width:580px){
  #genreGrid { grid-template-columns: 1fr !important; }
}
</style>

<script>
let genres = [];
let totalStems = 0;
let totalGenres = 0;

const userPlanTier = '{{ auth()->user()->plan_tier ?? "free" }}';
const hasFullAccess = (userPlanTier === 'full');

const genreMeta = {
  'Hip-Hop':   { tags:['Trap','Boom Bap','Drill'],          desc:'Trap, boom bap, drill, and cloud rap. Acapellas, 808s, hi-hats, and full instrumentals ready to chop.' },
  'R&B':       { tags:['Neo Soul','Alt R&B','Contemporary'], desc:'Neo soul chords, silky vocal stems, lush melodies, and contemporary grooves built for late-night sessions.' },
  'Soul':      { tags:['Classic','Motown','Gospel'],         desc:'Classic soul, Motown-inspired stems, gospel-infused vocals, and warm vintage drum breaks.' },
  'Pop':       { tags:['Synth Pop','Indie Pop','Dark Pop'],  desc:'Polished synth-pop hooks, indie pop chord stacks, and dark pop vocal stems engineered for radio.' },
  'Rock':      { tags:['Alternative','Indie','Hard Rock'],   desc:'Alternative guitar stems, indie riffs, hard rock drum breaks, and full band instrumentals.' },
  'Afrobeats': { tags:['Amapiano','Highlife','Afropop'],     desc:'Amapiano piano loops, highlife percussion, and afropop vocal chops with authentic texture.' },
  'Lo-fi':     { tags:['Chill','Jazzy','Lofi Hip-Hop'],      desc:'Dusty samples, mellow chords, soft drums, and ambient textures for chill production.' },
  'House':     { tags:['Deep','Tech','Afro House'],          desc:'Deep house chords, tech house grooves, and afro house percussion stems.' },
  'Trap':      { tags:['Hi-Hats','808s','Melodic'],          desc:'Hard 808s, rolling hi-hat patterns, and melodic trap loops across all sub-genres.' },
  'Jazz':      { tags:['Bebop','Neo Jazz','Fusion'],         desc:'Live instrument stems, jazz chord voicings, brushed drums, and upright bass lines.' },
};

function getGenreMeta(name) {
  return genreMeta[name] || {
    tags: ['Stems','Samples'],
    desc: name + ' stems collection. High-quality samples for music production.'
  };
}

async function fetchGenres() {
  const grid = document.getElementById('genreGrid');
  if (grid) grid.innerHTML = '<div style="text-align:center;padding:60px;color:var(--mu);grid-column:1/-1;">Loading...</div>';

  try {
    // Fetch both APIs in parallel
    const [genresRes, metaRes] = await Promise.all([
      fetch('https://songotsamples.com/api/vault/genres'),
      fetch('https://songotsamples.com/manage-panel-x9k/api/vault/genres/meta')
    ]);

    const genresData = await genresRes.json();
    const metaData   = metaRes.ok ? await metaRes.json() : { meta: {} };
    const metaMap    = metaData.meta || {};

    if (genresData.genres && genresData.genres.length > 0) {
      // Merge: filter hidden, override desc/tags from DB meta if available
      genres = genresData.genres
        .map(g => {
          const dbMeta  = metaMap[g.id];         // keyed by genre id e.g. "hip-hop"
          const fallback = getGenreMeta(g.name);  // local static fallback

          return {
            ...g,
            desc:   dbMeta?.description ?? fallback.desc,
            tags:   (dbMeta?.tags && dbMeta.tags.length) ? dbMeta.tags : fallback.tags,
            hidden: dbMeta?.is_hidden ?? false,
          };
        })
        .filter(g => !g.hidden); // remove hidden genres from customer view

      totalStems        = genresData.totalStems;
      totalGenres       = genres.length; // reflect visible count only
      window._totalSize = genresData.totalSize;
    }
  } catch(e) {
    console.error('Vault fetch error:', e);
  }

  buildGrid();
}

function buildGrid() {
  const grid = document.getElementById('genreGrid');
  if (!grid) return;
  if (!genres.length) {
    grid.innerHTML = '<div style="text-align:center;padding:60px;color:var(--mu);grid-column:1/-1;">No genres found.</div>';
    return;
  }
  grid.innerHTML = '';
  genres.forEach(g => {
    const card = document.createElement('div');
    card.className = 'vault-card';
    card.innerHTML = `
      <div class="vault-card-top">
        <div class="vault-card-name">${g.name}</div>
        <div class="vault-card-meta">
          ${(g.stems||0).toLocaleString()} stems<br>
          ${g.size || '—'}
        </div>
      </div>
      <div class="vault-card-desc">${g.desc}</div>
      <div class="vault-tags">${g.tags.map(t=>`<span class="vault-tag">${t}</span>`).join('')}</div>
      <div class="vault-divider"></div>
      <button class="vault-dl-btn ${hasFullAccess ? 'accent' : ''}"
        onclick="${hasFullAccess ? `downloadGenre('${g.id}','${g.name.replace(/'/g,"\\'")}')` : "window.location.href='/pricing'"}">
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" style="width:13px;height:13px;">
          <path d="M8 2v8M5 7l3 3 3-3M3 13h10"/>
        </svg>
        ${hasFullAccess ? 'Download ZIP' : '🔒 Unlock Full Access →'}
      </button>
    `;
    grid.appendChild(card);
  });
  updateStats();
}

function updateStats() {
  const s = document.getElementById('statStems');
  const g = document.getElementById('statGenres');
  const z = document.getElementById('statSize');
  if (s) s.textContent = totalStems.toLocaleString();
  if (g) g.textContent = totalGenres;
  if (z) z.textContent = window._totalSize || '—';
}

function downloadGenre(genreId, genreName) {
  showVaultToast(`📦 Preparing ${genreName} collection...`);
  window.location.href = `/vault/download/${encodeURIComponent(genreName)}`;
}

function showVaultToast(msg, isErr=false) {
  let t = document.getElementById('vaultToast');
  if (!t) {
    t = document.createElement('div');
    t.id = 'vaultToast';
    t.style.cssText = 'position:fixed;bottom:80px;left:50%;transform:translateX(-50%);color:#fff;padding:12px 24px;border-radius:8px;z-index:300;display:none;font-size:14px;white-space:nowrap;box-shadow:0 4px 20px rgba(0,0,0,.4);';
    document.body.appendChild(t);
  }
  t.textContent = msg;
  t.style.background = isErr ? '#ef4444' : '#22c55e';
  t.style.display = 'block';
  clearTimeout(t._h);
  t._h = setTimeout(() => t.style.display='none', 3000);
}

document.addEventListener('DOMContentLoaded', fetchGenres);
</script>
