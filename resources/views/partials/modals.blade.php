{{-- Privacy Modal --}}
<div class="modal-backdrop" id="privacyModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.8);backdrop-filter:blur(8px);z-index:200;align-items:center;justify-content:center;">
  <div style="background:linear-gradient(160deg,#030b22,#010510);border:1px solid rgba(96,116,255,.18);border-radius:16px;padding:28px;max-width:500px;margin:20px;">
    <h3 style="font-family:'Exo 2';margin-bottom:16px;color:var(--tx);">Privacy Policy</h3>
    <p style="font-size:13px;color:var(--mu);line-height:1.6;">Son Got Samples collects minimal personal data. We do not sell your data. Payment is handled by secure third-party processors.</p>
    <button onclick="document.getElementById('privacyModal').style.display='none'" style="margin-top:20px;padding:8px 20px;background:var(--acc);border:none;border-radius:8px;color:#fff;cursor:pointer;">Close</button>
  </div>
</div>

{{-- Terms Modal --}}
<div class="modal-backdrop" id="termsModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.8);backdrop-filter:blur(8px);z-index:200;align-items:center;justify-content:center;">
  <div style="background:linear-gradient(160deg,#030b22,#010510);border:1px solid rgba(96,116,255,.18);border-radius:16px;padding:28px;max-width:500px;margin:20px;">
    <h3 style="font-family:'Exo 2';margin-bottom:16px;color:var(--tx);">Terms of Service</h3>
    <p style="font-size:13px;color:var(--mu);line-height:1.6;">By using Son Got Samples you agree to these terms. Purchases grant a personal, non-exclusive license for music production. Redistribution of stems is prohibited.</p>
    <button onclick="document.getElementById('termsModal').style.display='none'" style="margin-top:20px;padding:8px 20px;background:var(--acc);border:none;border-radius:8px;color:#fff;cursor:pointer;">Close</button>
  </div>
</div>
<!-- Upgrade Prompt Modal -->
<div class="modal-backdrop" id="upgradePromptModal" style="display:none;">
    <div class="modal" style="max-width: 400px; text-align: center;">
        <button class="mclose" onclick="closeModal('upgradePromptModal')">✕</button>
        <div style="font-size: 48px; margin-bottom: 16px;">🔒</div>
        <div class="mtitle">Stem Locked</div>
        <p style="margin-bottom: 20px; color: #8f9abf;">
            This stem is beyond the free tier limit.
            Upgrade to unlock all 20,000+ stems!
        </p>
        <div style="display: flex; gap: 12px; justify-content: center;">
            <button class="btn" onclick="closeModal('upgradePromptModal')">Cancel</button>
            <button class="btn btn-accent" onclick="window.location.href='/pricing'">Upgrade Now</button>
        </div>
    </div>
</div>



<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-modal]').forEach(trigger => {
      trigger.addEventListener('click', function(e) {
        e.preventDefault();
        const modal = document.getElementById(this.getAttribute('data-modal'));
        if(modal) modal.style.display = 'flex';
      });
    });
    
    document.querySelectorAll('.modal-backdrop').forEach(modal => {
      modal.addEventListener('click', function(e) {
        if(e.target === this) this.style.display = 'none';
      });
    });
  });
</script>