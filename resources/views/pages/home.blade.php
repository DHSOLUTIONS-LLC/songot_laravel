<section id="page-home" class="page active">
  <div class="hw" style="max-width:1060px;margin:0 auto;padding:0 24px 60px;">
    
    {{-- Hero Section --}}
    <div class="hero-section" style="min-height:calc(100vh - var(--hh));display:flex;align-items:center;justify-content:center;">
      <div class="hero" style="text-align:center;padding:50px 20px 30px;">
        <h1 class="hero-title" style="font-family:'Exo 2';font-weight:200;font-size:clamp(32px,5vw,60px);line-height:1.08;letter-spacing:-.01em;margin:0 0 13px;">
          Access <em style="color:var(--acc);font-style:normal;font-weight:300;">20,000+</em><br>Stems Instantly
        </h1>
        <p class="hero-sub" style="font-size:15px;color:var(--mu);max-width:430px;margin:0 auto 26px;line-height:1.65;font-weight:300;">
          Browse stems by genre, BPM, key, and stem type. Built for producers, DJs, and creatives.
        </p>
        <div class="hero-btns" style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
          <button class="hero-btn-primary" id="heroStartFree" onclick="goTo('library')" style="height:46px;padding:0 30px;border-radius:9px;font-size:14px;font-weight:600;cursor:pointer;">
            Start Free
          </button>
          <button class="hero-btn-sec" id="heroFullAccess" onclick="goTo('pricing')" style="height:46px;padding:0 30px;border-radius:9px;font-size:14px;font-weight:600;cursor:pointer;">
            Full Access
          </button>
        </div>
      </div>
    </div>

    {{-- What's Inside Section --}}
    <div class="whats-inside-section" style="padding:60px 0 20px;border-top:1px solid var(--di);">
      <div class="feat-intro" style="text-align:center;padding:10px 0 24px;">
        <h2 style="font-family:'Exo 2';font-weight:300;font-size:clamp(16px,2vw,21px);text-transform:uppercase;letter-spacing:.08em;margin:0 0 7px;">
          What's Inside
        </h2>
        <p style="font-size:13.5px;color:var(--mu);max-width:400px;margin:0 auto;">
          Organized, labeled, and instantly searchable for music creators.
        </p>
      </div>
      <div class="feat-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:13px;margin-bottom:48px;">
        
        <div class="feat-card" style="background:var(--pb);border:1px solid var(--di);border-radius:11px;padding:20px 16px;transition:transform 0.2s, border-color 0.2s;">
          <span class="fi" style="font-size:15px;margin-bottom:9px;display:block;opacity:.75;">◈</span>
          <div class="ft" style="font-family:'Exo 2';font-size:.75rem;text-transform:uppercase;letter-spacing:.1em;margin:0 0 6px;color:var(--tx);">5 Stem Types</div>
          <p class="fd" style="font-size:12.5px;color:var(--mu);line-height:1.6;">Acapellas, drums, bass, melody, and instrumentals, labeled for fast discovery.</p>
        </div>
        
        <div class="feat-card" style="background:var(--pb);border:1px solid var(--di);border-radius:11px;padding:20px 16px;transition:transform 0.2s, border-color 0.2s;">
          <span class="fi" style="font-size:15px;margin-bottom:9px;display:block;opacity:.75;">◉</span>
          <div class="ft" style="font-family:'Exo 2';font-size:.75rem;text-transform:uppercase;letter-spacing:.1em;margin:0 0 6px;color:var(--tx);">BPM &amp; Key Search</div>
          <p class="fd" style="font-size:12.5px;color:var(--mu);line-height:1.6;">Filter the entire library by tempo, musical key, genre, or stem type in seconds.</p>
        </div>
        
        <div class="feat-card" style="background:var(--pb);border:1px solid var(--di);border-radius:11px;padding:20px 16px;transition:transform 0.2s, border-color 0.2s;">
          <span class="fi" style="font-size:15px;margin-bottom:9px;display:block;opacity:.75;">▷</span>
          <div class="ft" style="font-family:'Exo 2';font-size:.75rem;text-transform:uppercase;letter-spacing:.1em;margin:0 0 6px;color:var(--tx);">Preview Before Download</div>
          <p class="fd" style="font-size:12.5px;color:var(--mu);line-height:1.6;">Listen in-browser before committing. Know exactly what you're getting.</p>
        </div>
        
        <div class="feat-card" style="background:var(--pb);border:1px solid var(--di);border-radius:11px;padding:20px 16px;transition:transform 0.2s, border-color 0.2s;">
          <span class="fi" style="font-size:15px;margin-bottom:9px;display:block;opacity:.75;">⬡</span>
          <div class="ft" style="font-family:'Exo 2';font-size:.75rem;text-transform:uppercase;letter-spacing:.1em;margin:0 0 6px;color:var(--tx);">8+ Genres</div>
          <p class="fd" style="font-size:12.5px;color:var(--mu);line-height:1.6;">Hip-hop, R&amp;B, house, trap, lo-fi, soul, afrobeats, and more.</p>
        </div>
        
        <div class="feat-card" style="background:var(--pb);border:1px solid var(--di);border-radius:11px;padding:20px 16px;transition:transform 0.2s, border-color 0.2s;">
          <span class="fi" style="font-size:15px;margin-bottom:9px;display:block;opacity:.75;">⊕</span>
          <div class="ft" style="font-family:'Exo 2';font-size:.75rem;text-transform:uppercase;letter-spacing:.1em;margin:0 0 6px;color:var(--tx);">Built for Producers</div>
          <p class="fd" style="font-size:12.5px;color:var(--mu);line-height:1.6;">For beatmakers, DJs, editors, and samplers who need clean, usable stems.</p>
        </div>
        
        <div class="feat-card" style="background:var(--pb);border:1px solid var(--di);border-radius:11px;padding:20px 16px;transition:transform 0.2s, border-color 0.2s;">
          <span class="fi" style="font-size:15px;margin-bottom:9px;display:block;opacity:.75;">◎</span>
          <div class="ft" style="font-family:'Exo 2';font-size:.75rem;text-transform:uppercase;letter-spacing:.1em;margin:0 0 6px;color:var(--tx);">One-Time Access</div>
          <p class="fd" style="font-size:12.5px;color:var(--mu);line-height:1.6;">No subscriptions. Pay once, access the library permanently on your terms.</p>
        </div>
      </div>
    </div>
  </div>
  
  <footer class="site-footer">
    <span>© Son Got Samples 2026</span>
    <span class="dot">•</span>
    <a data-modal="privacyModal">Privacy Policy</a>
    <span class="dot">•</span>
    <a data-modal="termsModal">Terms of Service</a>
  </footer>
</section>

<style>
/* ========== START FREE BUTTON - BLUEISH DARK + CONTINUOUS SWEEP ========== */
.hero-btn-primary {
  position: relative;
  overflow: hidden;
  transition: all 0.3s ease;
  z-index: 1;
  cursor: pointer;
  background: linear-gradient(135deg, var(--acc), #4a5ee8);
  border: 1px solid rgba(130, 148, 255, 0.5);
  color: #fff;
  box-shadow: 0 0 18px rgba(96, 116, 255, 0.25);
}

/* Hover effect - Blueish dark background (thora sa dark) + border dark */
.hero-btn-primary:hover {
  background: #0f1428;
  border-color: rgba(50, 55, 80, 0.8);
  transform: translateY(-2px);
  /* box-shadow: 0 0 22px rgba(96, 116, 255, 0.3); */
}

/* Continuous sweep animation - jab tak hover hai tab tak sweep hota rahega */
.hero-btn-primary::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, 
    transparent, 
    rgba(255, 255, 255, 0.08), 
    rgba(255, 255, 255, 0.2),
    rgba(255, 255, 255, 0.08), 
    transparent
  );
  z-index: -1;
}

/* Continuous sweeping animation on hover */
.hero-btn-primary:hover::before {
  animation: btnSweep 0.9s ease-in-out infinite;
}

@keyframes btnSweep {
  0% {
    left: -100%;
  }
  50% {
    left: 100%;
  }
  100% {
    left: 100%;
  }
}

/* Active click effect */
.hero-btn-primary:active {
  transform: translateY(0);
}
/* ========== FULL ACCESS BUTTON - BLUEISH DARK + CONTINUOUS SWEEP ========== */
.hero-btn-sec {
  position: relative;
  overflow: hidden;
  transition: all 0.3s ease;
  z-index: 1;
  cursor: pointer;
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid var(--me);
  color: var(--tx);
}

/* Hover effect - Blueish dark background + border dark */
.hero-btn-sec:hover {
  background: #0f1428;
  border-color: rgba(50, 55, 80, 0.8);
  color: #fff;
  transform: translateY(-2px);
  /* box-shadow: 0 0 22px rgba(96, 116, 255, 0.2); */
}

/* Continuous sweep animation - jab tak hover hai tab tak sweep hota rahega */
.hero-btn-sec::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, 
    transparent, 
    rgba(255, 255, 255, 0.08), 
    rgba(255, 255, 255, 0.2),
    rgba(255, 255, 255, 0.08), 
    transparent
  );
  z-index: -1;
}

/* Continuous sweeping animation on hover */
.hero-btn-sec:hover::before {
  animation: btnSweepSec 0.9s ease-in-out infinite;
}

@keyframes btnSweepSec {
  0% {
    left: -100%;
  }
  50% {
    left: 100%;
  }
  100% {
    left: 100%;
  }
}

/* Active click effect */
.hero-btn-sec:active {
  transform: translateY(0);
}
=======
  /* ========== START FREE BUTTON ========== */
  .hero-btn-primary {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    z-index: 1;
    cursor: pointer;
    background: linear-gradient(135deg, var(--acc), #4a5ee8);
    border: 1px solid rgba(130,148,255,.5);
    color: #fff;
    box-shadow: 0 0 18px rgba(96,116,255,.25);
  }

  .hero-btn-primary:hover {
    background: #0a0a1a;
    border-color: rgba(30,40,60,.8);
    transform: translateY(-2px);
    box-shadow: 0 0 20px rgba(96,116,255,.2);
  }

  .hero-btn-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, 
      transparent, 
      rgba(255,255,255,0.1), 
      rgba(255,255,255,0.25),
      rgba(255,255,255,0.1), 
      transparent
    );
    transition: left 0.5s ease;
    z-index: -1;
  }

  .hero-btn-primary:hover::before {
    left: 100%;
  }

  /* ========== FULL ACCESS BUTTON ========== */
  .hero-btn-sec {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    z-index: 1;
    cursor: pointer;
    background: rgba(255,255,255,.05);
    border: 1px solid var(--me);
    color: var(--tx);
  }

  .hero-btn-sec:hover {
    background: rgba(30,40,80,.6);
    border-color: rgba(30,40,60,.8);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 0 20px rgba(96,116,255,.15);
  }

  .hero-btn-sec::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, 
      transparent, 
      rgba(255,255,255,0.08), 
      rgba(255,255,255,0.2),
      rgba(255,255,255,0.08), 
      transparent
    );
    transition: left 0.5s ease;
    z-index: -1;
  }

  .hero-btn-sec:hover::before {
    left: 100%;
  }

  /* Button active/click effect */
  .hero-btn-primary:active,
  .hero-btn-sec:active {
    transform: translateY(0px);
  }

  /* Feature Cards Hover */
  .feat-card:hover {
    transform: translateY(-3px);
    border-color: rgba(96,116,255,.3);
  }

  /* Responsive */
  @media (max-width: 1024px) {
    .feat-grid {
      gap: 12px;
    }
  }

  @media (max-width: 768px) {
    .hw {
      padding: 0 16px 40px !important;
    }
    
    .hero-section {
      padding: 20px;
    }
    
    .hero {
      padding: 30px 16px 20px !important;
    }
    
    .hero-title {
      font-size: 28px !important;
    }
    
    .hero-sub {
      font-size: 13px !important;
      padding: 0 10px;
    }
    
    .hero-btns {
      gap: 10px;
    }
    
    .hero-btn-primary,
    .hero-btn-sec {
      height: 40px !important;
      padding: 0 20px !important;
      font-size: 12px !important;
    }
    
    .whats-inside-section {
      padding: 30px 0 15px !important;
    }
    
    .feat-intro h2 {
      font-size: 18px !important;
    }
    
    .feat-intro p {
      font-size: 12px !important;
    }
    
    .feat-grid {
      grid-template-columns: 1fr !important;
      gap: 12px;
      padding: 0 16px;
    }
    
    .feat-card {
      padding: 16px !important;
    }
    
    .ft {
      font-size: 0.7rem !important;
    }
    
    .fd {
      font-size: 11px !important;
    }
  }

  @media (max-width: 480px) {
    .hero-title {
      font-size: 24px !important;
    }
    
    .hero-sub {
      font-size: 11px !important;
    }
    
    .hero-btn-primary,
    .hero-btn-sec {
      height: 36px !important;
      padding: 0 16px !important;
      font-size: 11px !important;
    }
    
    .ft {
      font-size: 0.65rem !important;
    }
    
    .fd {
      font-size: 10px !important;
    }
  }

  @media (min-width: 769px) and (max-width: 1024px) {
    .feat-grid {
      grid-template-columns: repeat(2, 1fr) !important;
    }
  }
</style>