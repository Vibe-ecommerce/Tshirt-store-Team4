@extends('layouts.admin')

@section('title', 'Promotions & Discounts')
@section('page-title', 'Promotions & Discount Codes')

@section('styles')
<style>
    .promo-header-box {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .promo-title-group h2 {
        font-size: 1.55rem;
        font-weight: 850;
        color: #0f172a;
        margin: 0 0 4px;
        letter-spacing: -0.02em;
    }

    .promo-title-group p {
        color: #64748b;
        font-size: 0.88rem;
        margin: 0;
    }

    /* Helpful Banner explaining Home Page Promo Visibility */
    .promo-tip-card {
        background: #f0fdf4;
        border: 1.5px solid #bbf7d0;
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.05);
    }

    .promo-tip-icon {
        font-size: 1.35rem;
        line-height: 1;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .promo-tip-text {
        font-size: 0.88rem;
        color: #166534;
        line-height: 1.55;
    }

    .promo-tip-text strong {
        color: #14532d;
        font-weight: 800;
    }

    /* Main Grid Layout */
    .promo-main-grid {
        display: grid;
        grid-template-columns: 1.8fr 1.2fr;
        gap: 24px;
        align-items: start;
    }

    /* Studio Card */
    .promo-studio-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 18px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.03);
        overflow: hidden;
    }

    .promo-card-header {
        padding: 18px 22px;
        border-bottom: 1.5px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8fafc;
    }

    .promo-card-header h3 {
        font-size: 1.05rem;
        font-weight: 850;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .promo-badge-counter {
        font-size: 0.72rem;
        font-weight: 800;
        background: #e2e8f0;
        color: #334155;
        padding: 2px 8px;
        border-radius: 9999px;
    }

    /* Table Styles */
    .promo-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .promo-table th {
        font-size: 0.72rem;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        background: #ffffff;
        padding: 12px 18px;
        border-bottom: 1.5px solid #e2e8f0;
    }

    .promo-table td {
        padding: 14px 18px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.88rem;
        color: #334155;
        vertical-align: middle;
    }

    .promo-table tr:hover td {
        background: #f8fafc;
    }

    .promo-code-chip {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.95rem;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .promo-discount-badge {
        display: inline-flex;
        align-items: center;
        font-weight: 850;
        font-size: 0.85rem;
        color: #047857;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        padding: 3px 10px;
        border-radius: 8px;
    }

    .promo-status-active {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #059669;
        font-size: 0.75rem;
        font-weight: 850;
        padding: 3px 9px;
        border-radius: 9999px;
    }

    .promo-status-disabled {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fef3c7;
        border: 1px solid #fde68a;
        color: #b45309;
        font-size: 0.75rem;
        font-weight: 850;
        padding: 3px 9px;
        border-radius: 9999px;
    }

    .promo-status-expired {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #dc2626;
        font-size: 0.75rem;
        font-weight: 850;
        padding: 3px 9px;
        border-radius: 9999px;
    }

    /* Action Buttons in Row */
    .promo-actions-group {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 6px;
    }

    .btn-promo-action {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 750;
        border: 1.5px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        cursor: pointer;
        transition: all 0.15s;
        text-decoration: none;
    }

    .btn-promo-action:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
        transform: translateY(-1px);
    }

    .btn-promo-pause {
        border-color: #fde68a;
        background: #fffbeb;
        color: #b45309;
    }

    .btn-promo-pause:hover {
        background: #fef3c7;
        border-color: #f59e0b;
        color: #92400e;
    }

    .btn-promo-enable {
        border-color: #a7f3d0;
        background: #ecfdf5;
        color: #059669;
    }

    .btn-promo-enable:hover {
        background: #d1fae5;
        border-color: #10b981;
        color: #047857;
    }

    .btn-promo-delete {
        border-color: #fecaca;
        background: #fff5f5;
        color: #dc2626;
    }

    .btn-promo-delete:hover {
        background: #fee2e2;
        border-color: #ef4444;
        color: #991b1b;
    }

    /* Form Card Styling */
    .promo-form-panel {
        padding: 24px;
    }

    .promo-form-group {
        margin-bottom: 16px;
    }

    .promo-form-label {
        display: block;
        font-size: 0.78rem;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #475569;
        margin-bottom: 6px;
    }

    .promo-input-ctrl {
        width: 100%;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1.5px solid #cbd5e1;
        background: #ffffff;
        color: #0f172a;
        font-size: 0.90rem;
        font-weight: 600;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .promo-input-ctrl:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
    }

    .promo-btn-submit {
        width: 100%;
        padding: 12px;
        border-radius: 12px;
        background: #0f172a;
        color: #ffffff;
        font-size: 0.92rem;
        font-weight: 850;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
        transition: all 0.2s;
    }

    .promo-btn-submit:hover {
        background: #1e293b;
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.22);
    }

    /* Edit Modal Card */
    .edit-modal-box {
        background: #ffffff;
        border-radius: 20px;
        border: 1.5px solid #e2e8f0;
        max-width: 500px;
        width: 90%;
        padding: 26px;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
        position: relative;
    }

    @media (max-width: 900px) {
        .promo-main-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

    <!-- Header Box -->
    <div class="promo-header-box">
        <div class="promo-title-group">
            <h2>Promotions & Discount Codes (ការបញ្ចុះតម្លៃ)</h2>
            <p>Create, pause, activate, or remove discount codes for customer checkout.</p>
        </div>
    </div>

    <!-- Helpful Tips & Visibility Banner -->
    <div class="promo-tip-card">
        <div class="promo-tip-icon">💡</div>
        <div class="promo-tip-text">
            <strong>វិធីបិទ/បើកផ្ទាំង Promotion លើ Home Page (How to Hide/Show Promo Banner):</strong><br>
            នៅថ្ងៃណាដែលហាង<strong>មិនមាន Promotion</strong> ឬអ្នកចង់<strong>លាក់ផ្ទាំងបញ្ចុះតម្លៃពីទំព័រមុខហាង (Home Page)</strong> អ្នកគ្រាន់តែចុចប៊ូតុង <strong>⏸️ Pause (ផ្អាក)</strong> លើកូដបញ្ចុះតម្លៃ នោះផ្ទាំង Banner នៅលើ Home Page និង Top Announcement Bar នឹងត្រូវ<strong>បិទលាក់ដោយស្វ័យប្រវត្តិភ្លាមៗ!</strong><br>
            នៅពេលចង់ដាក់ Promotion ឡើងវិញ គ្រាន់តែចុចប៊ូតុង <strong>▶️ Enable</strong> នោះផ្ទាំង Banner នឹងបង្ហាញឡើងវិញភ្លាមៗ។
        </div>
    </div>

    <div class="promo-main-grid">
        <!-- 1. All Promotions Table Card -->
        <div class="promo-studio-card">
            <div class="promo-card-header">
                <h3>
                    <span>🏷️ All Discount Codes</span>
                    <span class="promo-badge-counter">{{ $promotions->count() }} Codes</span>
                </h3>
                <span style="font-size:0.75rem; color:#64748b; font-weight:600;">Syncs live with checkout</span>
            </div>

            <div style="overflow-x:auto;">
                <table class="promo-table">
                    <thead>
                        <tr>
                            <th>Coupon Code</th>
                            <th>Discount</th>
                            <th>Min Spend</th>
                            <th>Uses</th>
                            <th>Status</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($promotions as $promo)
                            <tr>
                                <td>
                                    <div class="promo-code-chip">
                                        <span>🏷️</span>
                                        <span>{{ $promo->code }}</span>
                                    </div>
                                    <div style="font-size:0.75rem; color:#64748b; margin-top:3px;">
                                        {{ $promo->description ?: 'General checkout promotion' }}
                                        @if ($promo->expires_at)
                                            • <span style="color:{{ $promo->expires_at->isPast() ? '#dc2626' : '#64748b' }}; font-weight:600;">Exp: {{ $promo->expires_at->format('M d, Y') }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="promo-discount-badge">{{ $promo->discount_percent }}% OFF</span>
                                </td>
                                <td>
                                    <span style="font-weight:700; color:#0f172a;">${{ number_format($promo->min_spend, 2) }}</span>
                                </td>
                                <td>
                                    <span style="font-size:0.82rem; font-weight:600; color:#64748b;">{{ $promo->uses_count }} orders</span>
                                </td>
                                <td>
                                    @if ($promo->status == 'Active')
                                        <span class="promo-status-active">
                                            <span style="display:inline-block; width:6px; height:6px; border-radius:50%; background:#10b981;"></span>
                                            Active (កំពុងដំណើរការ)
                                        </span>
                                    @elseif ($promo->status == 'Disabled')
                                        <span class="promo-status-disabled">
                                            <span style="display:inline-block; width:6px; height:6px; border-radius:50%; background:#f59e0b;"></span>
                                            Disabled (ផ្អាក/បិទ)
                                        </span>
                                    @else
                                        <span class="promo-status-expired">
                                            <span style="display:inline-block; width:6px; height:6px; border-radius:50%; background:#ef4444;"></span>
                                            {{ $promo->status }}
                                        </span>
                                    @endif
                                </td>
                                <td style="text-align:right;">
                                    <div class="promo-actions-group">
                                        <!-- Edit Button -->
                                        <button type="button" class="btn-promo-action" onclick='openEditPromo(@json($promo))' title="Edit discount percentage or rules">
                                            ✏️ Edit
                                        </button>

                                        <!-- Quick Pause / Enable Toggle (បិទ ឬ បើក Promotion) -->
                                        <form action="{{ route('admin.promotions.toggle', $promo->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @if ($promo->status === 'Active')
                                                <button type="submit" class="btn-promo-action btn-promo-pause" title="Click to Pause: Hides promo from Homepage & Checkout">
                                                    ⏸️ Pause (បិទ)
                                                </button>
                                            @else
                                                <button type="submit" class="btn-promo-action btn-promo-enable" title="Click to Activate: Shows promo banner on Homepage">
                                                    ▶️ Enable (បើក)
                                                </button>
                                            @endif
                                        </form>

                                        <!-- Delete Button with Safety Modal Confirmation -->
                                        <form action="{{ route('admin.promotions.destroy', $promo->id) }}" method="POST"
                                              data-confirm="Are you sure you want to permanently delete this discount code? Customers holding this code will no longer be able to use it."
                                              data-confirm-title="Delete Promotion?"
                                              data-confirm-item="🏷️ {{ $promo->code }} ({{ $promo->discount_percent }}% OFF)"
                                              data-confirm-badge="MARKETING PROMOTION"
                                              data-confirm-btn="Delete Promo"
                                              data-confirm-type="danger"
                                              data-confirm-icon="🏷️"
                                              style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-promo-action btn-promo-delete" title="Delete promotion code">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center; padding:36px; color:#64748b;">
                                    No promotions found. You can create a new promotion using the form on the right.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 2. Create Promotion Form Card -->
        <div class="promo-studio-card promo-form-panel">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:20px; padding-bottom:12px; border-bottom:1.5px solid #f1f5f9;">
                <span style="font-size:1.3rem;">✨</span>
                <h3 style="font-size:1.1rem; font-weight:850; color:#0f172a; margin:0;">Create New Promo Code</h3>
            </div>

            <form action="{{ route('admin.promotions.store') }}" method="POST">
                @csrf

                <div class="promo-form-group">
                    <label class="promo-form-label">Coupon Code (កូដបញ្ចុះតម្លៃ) *</label>
                    <input type="text" name="code" required class="promo-input-ctrl" style="text-transform:uppercase; font-family:'JetBrains Mono', monospace; font-weight:800;" placeholder="e.g. SUMMER25">
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;" class="promo-form-group">
                    <div>
                        <label class="promo-form-label">Discount % *</label>
                        <input type="number" name="discount_percent" min="1" max="100" required class="promo-input-ctrl" placeholder="20">
                    </div>

                    <div>
                        <label class="promo-form-label">Min Spend ($)</label>
                        <input type="number" step="0.01" name="min_spend" class="promo-input-ctrl" placeholder="0.00">
                    </div>
                </div>

                <div class="promo-form-group">
                    <label class="promo-form-label">Campaign Description (ការពិពណ៌នា)</label>
                    <input type="text" name="description" class="promo-input-ctrl" placeholder="e.g. Special weekend flash sale">
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;" class="promo-form-group">
                    <div>
                        <label class="promo-form-label">Initial Status</label>
                        <select name="status" class="promo-input-ctrl">
                            <option value="Active">Active (បើកដំណើរការ)</option>
                            <option value="Disabled">Disabled (បិទ/ផ្អាក)</option>
                        </select>
                    </div>

                    <div>
                        <label class="promo-form-label">Expiry Date (ថ្ងៃផុតកំណត់)</label>
                        <input type="date" name="expires_at" class="promo-input-ctrl">
                    </div>
                </div>

                <button type="submit" class="promo-btn-submit">
                    <span>Create Promotion Code →</span>
                </button>
            </form>
        </div>
    </div>

    <!-- 3. Edit Promotion Modal -->
    <div id="editPromoModal" class="cool-modal-backdrop" aria-hidden="true">
        <div class="edit-modal-box">
            <button type="button" class="cool-modal-close" onclick="closeEditPromoModal()">✕</button>

            <div style="display:flex; align-items:center; gap:10px; margin-bottom:20px;">
                <span style="font-size:1.4rem;">✏️</span>
                <h3 style="font-size:1.2rem; font-weight:850; color:#0f172a; margin:0;">Edit Promotion Code</h3>
            </div>

            <form id="editPromoForm" method="POST">
                @csrf
                @method('PUT')

                <div class="promo-form-group">
                    <label class="promo-form-label">Coupon Code *</label>
                    <input type="text" id="edit_code" name="code" required class="promo-input-ctrl" style="text-transform:uppercase; font-family:'JetBrains Mono', monospace; font-weight:800;">
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;" class="promo-form-group">
                    <div>
                        <label class="promo-form-label">Discount % *</label>
                        <input type="number" id="edit_discount_percent" name="discount_percent" min="1" max="100" required class="promo-input-ctrl">
                    </div>

                    <div>
                        <label class="promo-form-label">Min Spend ($)</label>
                        <input type="number" step="0.01" id="edit_min_spend" name="min_spend" class="promo-input-ctrl">
                    </div>
                </div>

                <div class="promo-form-group">
                    <label class="promo-form-label">Description</label>
                    <input type="text" id="edit_description" name="description" class="promo-input-ctrl">
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;" class="promo-form-group">
                    <div>
                        <label class="promo-form-label">Status</label>
                        <select id="edit_status" name="status" class="promo-input-ctrl">
                            <option value="Active">Active (បើកដំណើរការ)</option>
                            <option value="Disabled">Disabled (បិទ/ផ្អាក)</option>
                            <option value="Expired">Expired (ផុតកំណត់)</option>
                        </select>
                    </div>

                    <div>
                        <label class="promo-form-label">Expiry Date</label>
                        <input type="date" id="edit_expires_at" name="expires_at" class="promo-input-ctrl">
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px;">
                    <button type="button" class="btn-promo-action" style="padding:10px 18px;" onclick="closeEditPromoModal()">Cancel</button>
                    <button type="submit" class="promo-btn-submit" style="width:auto; padding:10px 22px;">Save Changes →</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function openEditPromo(promo) {
        const modal = document.getElementById('editPromoModal');
        const form = document.getElementById('editPromoForm');
        form.action = '/admin/promotions/' + promo.id;

        document.getElementById('edit_code').value = promo.code;
        document.getElementById('edit_discount_percent').value = promo.discount_percent;
        document.getElementById('edit_min_spend').value = promo.min_spend;
        document.getElementById('edit_description').value = promo.description || '';
        document.getElementById('edit_status').value = promo.status;
        document.getElementById('edit_expires_at').value = promo.expires_at ? promo.expires_at.substring(0, 10) : '';

        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
    }

    function closeEditPromoModal() {
        const modal = document.getElementById('editPromoModal');
        if (modal) {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeEditPromoModal();
        }
    });

    const editModal = document.getElementById('editPromoModal');
    if (editModal) {
        editModal.addEventListener('click', function(e) {
            if (e.target === editModal) closeEditPromoModal();
        });
    }
</script>
@endsection
