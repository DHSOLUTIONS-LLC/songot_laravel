{{-- ── DELETE CONFIRM MODAL ─────────────────────────────── --}}
<div id="deleteCustModal" style="display:none;position:fixed;inset:0;z-index:500;align-items:center;justify-content:center;padding:20px;">
  <div onclick="closeDeleteModal()" style="position:absolute;inset:0;background:rgba(2,5,18,.85);backdrop-filter:blur(6px);"></div>
  <div style="position:relative;z-index:1;width:100%;max-width:380px;background:linear-gradient(160deg,#0c1535,#080f26);border:1px solid rgba(220,50,50,.25);border-radius:16px;padding:32px 28px 26px;text-align:center;box-shadow:0 24px 60px rgba(0,0,0,.7);">

    {{-- Icon --}}
    <div style="width:60px;height:60px;border-radius:50%;background:rgba(220,50,50,.1);border:1px solid rgba(220,50,50,.25);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#e05050" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
      </svg>
    </div>

    <h3 style="font-family:'Exo 2';font-size:17px;font-weight:600;color:var(--tx);margin:0 0 8px;">Delete Customer?</h3>
    <p style="font-size:13px;color:var(--mu);line-height:1.6;margin:0 0 6px;">You are about to permanently delete:</p>
    <p id="deleteCustEmail" style="font-size:13px;color:#e8ecff;font-weight:600;margin:0 0 22px;word-break:break-all;"></p>
    <p style="font-size:11.5px;color:var(--mu2);margin:0 0 24px;">This action cannot be undone. All their data will be removed.</p>

    <div style="display:flex;gap:10px;">
      <button onclick="closeDeleteModal()" style="flex:1;height:40px;border-radius:9px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.12);color:var(--mu);font-size:13px;cursor:pointer;font-family:inherit;">Cancel</button>
      <button id="deleteCustConfirmBtn" style="flex:1;height:40px;border-radius:9px;background:rgba(180,30,30,.85);border:1px solid rgba(220,50,50,.4);color:#fff;font-size:13px;font-weight:600;cursor:pointer;font-family:inherit;">Delete</button>
    </div>
  </div>
</div>

<script>
// ── Delete Modal State ────────────────────────────────
let _deleteCustomerId = null;

function openDeleteModal(id, email) {
    _deleteCustomerId = id;
    document.getElementById('deleteCustEmail').textContent = email || 'this customer';
    document.getElementById('deleteCustModal').style.display = 'flex';
}

function closeDeleteModal() {
    document.getElementById('deleteCustModal').style.display = 'none';
    _deleteCustomerId = null;
}

// Confirm button
document.getElementById('deleteCustConfirmBtn').addEventListener('click', async function () {
    if (!_deleteCustomerId) return;

    const btn = this;
    btn.textContent = 'Deleting…';
    btn.disabled = true;

    try {
        const data = await apiDelete(`${API_BASE}/customers/${_deleteCustomerId}`);
        closeDeleteModal();
        if (data.success) {
            showToast('Customer deleted successfully');
            renderCustomers();
        } else {
            showToast(data.message || 'Delete failed', 'error');
        }
    } catch (e) {
        closeDeleteModal();
        showToast('Delete failed', 'error');
    }

    btn.textContent = 'Delete';
    btn.disabled = false;
});

// Escape key
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeDeleteModal();
});

// ── Updated deleteCustomer — opens modal instead of confirm() ──
function deleteCustomer(id, email) {
    openDeleteModal(id, email);
}
</script>