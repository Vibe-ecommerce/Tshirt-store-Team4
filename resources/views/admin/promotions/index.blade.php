@extends('layouts.admin')

@section('title', 'Promotions & Discounts')
@section('page-title', 'Promotions & Discount Codes')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:16px;">
        <div>
            <h2 style="font-size:1.6rem; font-weight:800; color:#ffffff;">Active Promo Campaigns & Discount Codes</h2>
            <p style="color:var(--text-muted); font-size:0.9rem;">Add, edit, enable/disable, and remove coupon codes for customer checkout.</p>
        </div>
    </div>

    <div style="display:grid; grid-template-columns: 2fr 1.2fr; gap:28px;">
        <!-- All Promotions List -->
        <div class="table-card">
            <div style="padding:20px; border-bottom:1px solid var(--border-subtle); display:flex; justify-content:space-between; align-items:center;">
                <h3 style="font-size:1.15rem; font-weight:800; color:#ffffff;">All Promotional Codes ({{ $promotions->count() }})</h3>
                <span style="font-size:0.8rem; color:var(--text-muted);">Syncs live with checkout</span>
            </div>

            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Code</th>
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
                                <strong style="color:#ffffff; font-size:1rem; letter-spacing:0.5px;">{{ $promo->code }}</strong>
                                <div style="font-size:0.75rem; color:var(--text-muted);">
                                    {{ $promo->description ?: 'No description' }}
                                    @if ($promo->expires_at)
                                        • <span style="color:{{ $promo->expires_at->isPast() ? '#f87171' : 'var(--text-muted)' }}">Exp: {{ $promo->expires_at->format('M d, Y') }}</span>
                                    @endif
                                </div>
                            </td>
                            <td><strong style="color:#4ade80;">{{ $promo->discount_percent }}% OFF</strong></td>
                            <td>${{ number_format($promo->min_spend, 2) }}</td>
                            <td>{{ $promo->uses_count }} orders</td>
                            <td>
                                @if ($promo->status == 'Active')
                                    <span class="badge-status badge-green">Active</span>
                                @elseif ($promo->status == 'Disabled')
                                    <span class="badge-status badge-yellow">Disabled</span>
                                @else
                                    <span class="badge-status badge-red">{{ $promo->status }}</span>
                                @endif
                            </td>
                            <td style="text-align:right;">
                                <div style="display:flex; justify-content:flex-end; gap:6px; align-items:center;">
                                    <!-- Edit Button -->
                                    <button type="button" class="btn-outline" style="padding:4px 8px; font-size:0.75rem;" onclick='openEditPromo(@json($promo))'>
                                        Edit
                                    </button>

                                    <!-- Quick Pause / Enable Toggle -->
                                    <form action="{{ route('admin.promotions.toggle', $promo->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @if ($promo->status === 'Active')
                                            <button type="submit" class="btn-outline" style="padding:4px 8px; font-size:0.75rem; color:#facc15;" title="Pause / Disable code">
                                                Pause
                                            </button>
                                        @else
                                            <button type="submit" class="btn-outline" style="padding:4px 8px; font-size:0.75rem; color:#4ade80;" title="Activate code">
                                                Enable
                                            </button>
                                        @endif
                                    </form>

                                    <!-- Delete Button with Cool Confirmation Alert -->
                                    <form action="{{ route('admin.promotions.destroy', $promo->id) }}" method="POST"
                                          data-confirm="Are you sure you want to permanently delete this discount code? Customers holding this code will no longer be able to use it."
                                          data-confirm-title="Delete Promotion?"
                                          data-confirm-item="🏷️ {{ $promo->code }} ({{ $promo->discount_percent }}% OFF)"
                                          data-confirm-badge="MARKETING PROMOTION"
                                          data-confirm-btn="Delete Promo"
                                          data-confirm-type="danger"
                                          data-confirm-icon="🏷️">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-outline" style="padding:4px 8px; font-size:0.75rem; color:#f87171; border-color:rgba(239,68,68,0.3); transition:all 0.2s;">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:30px; color:var(--text-muted);">No promotions found. Create one on the right.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Create Promotion Form (ដាក់ Discount / Promotion) -->
        <div style="background:var(--bg-card); border:1px solid var(--border-subtle); border-radius:var(--radius-lg); padding:24px; height:fit-content;">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:18px;">
                <span style="color:#818cf8; display:flex;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                </span>
                <h3 style="font-size:1.15rem; font-weight:800; color:#ffffff;">Create New Promo Code</h3>
            </div>

            <form action="{{ route('admin.promotions.store') }}" method="POST">
                @csrf

                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:0.8rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Coupon Code *</label>
                    <input type="text" name="code" required style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:10px; border-radius:var(--radius-md); font-weight:700; text-transform:uppercase;" placeholder="e.g. SUMMER20">
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Discount % *</label>
                        <input type="number" name="discount_percent" min="1" max="100" required style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:10px; border-radius:var(--radius-md);" placeholder="20">
                    </div>

                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Min Spend ($)</label>
                        <input type="number" step="0.01" name="min_spend" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:10px; border-radius:var(--radius-md);" placeholder="0.00">
                    </div>
                </div>

                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:0.8rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Campaign Description</label>
                    <input type="text" name="description" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:10px; border-radius:var(--radius-md);" placeholder="e.g. Special weekend flash sale">
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:20px;">
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Status</label>
                        <select name="status" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:10px; border-radius:var(--radius-md);">
                            <option value="Active">Active</option>
                            <option value="Disabled">Disabled</option>
                            <option value="Expired">Expired</option>
                        </select>
                    </div>

                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Expiry Date</label>
                        <input type="date" name="expires_at" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:10px; border-radius:var(--radius-md);">
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:12px;">
                    Create Promotion Code →
                </button>
            </form>
        </div>
    </div>

    <!-- Edit Promotion Modal -->
    <div id="editPromoModal" class="cool-modal-backdrop" aria-hidden="true">
        <div class="cool-modal-card" style="max-width:500px; text-align:left;">
            <button type="button" class="cool-modal-close" onclick="closeEditPromoModal()">✕</button>

            <div style="display:flex; align-items:center; gap:10px; margin-bottom:20px;">
                <span style="font-size:1.5rem;">✏️</span>
                <h3 style="font-size:1.25rem; font-weight:800; color:#ffffff;">Edit Promotion Code</h3>
            </div>

            <form id="editPromoForm" method="POST">
                @csrf
                @method('PUT')

                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:0.8rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Coupon Code *</label>
                    <input type="text" id="edit_code" name="code" required style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:10px; border-radius:var(--radius-md); font-weight:700; text-transform:uppercase;">
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Discount % *</label>
                        <input type="number" id="edit_discount_percent" name="discount_percent" min="1" max="100" required style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:10px; border-radius:var(--radius-md);">
                    </div>

                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Min Spend ($)</label>
                        <input type="number" step="0.01" id="edit_min_spend" name="min_spend" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:10px; border-radius:var(--radius-md);">
                    </div>
                </div>

                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:0.8rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Description</label>
                    <input type="text" id="edit_description" name="description" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:10px; border-radius:var(--radius-md);">
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:24px;">
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Status</label>
                        <select id="edit_status" name="status" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:10px; border-radius:var(--radius-md);">
                            <option value="Active">Active</option>
                            <option value="Disabled">Disabled</option>
                            <option value="Expired">Expired</option>
                        </select>
                    </div>

                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Expiry Date</label>
                        <input type="date" id="edit_expires_at" name="expires_at" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:10px; border-radius:var(--radius-md);">
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:12px;">
                    <button type="button" class="btn-outline" onclick="closeEditPromoModal()">Cancel</button>
                    <button type="submit" class="btn-primary">Save Changes →</button>
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
