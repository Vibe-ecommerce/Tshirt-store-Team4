@extends('layouts.admin')

@section('title', 'Review Management')
@section('page-title', 'Customer Review Moderation')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:16px;">
        <div>
            <h2 style="font-size:1.6rem; font-weight:850; color:#0f172a; letter-spacing:-0.4px;">Customer Reviews & Ratings</h2>
            <p style="color:#475569; font-size:0.92rem; font-weight:500;">Moderate customer product ratings, approve pending submissions, or hide spam.</p>
        </div>
    </div>

    <!-- Status Tabs -->
    <div style="display:flex; gap:10px; margin-bottom:24px; flex-wrap:wrap;">
        @foreach ($counts as $stName => $stCount)
            @php
                $isActive = (request('status') == $stName) || (!request('status') && $stName == 'All');
            @endphp
            <a href="{{ route('admin.reviews.index', ['status' => ($stName == 'All' ? null : $stName)]) }}" 
               class="btn-outline" 
               style="{{ $isActive ? 'background:#4f46e5; border-color:#4f46e5; color:#ffffff; font-weight:750;' : 'background:#ffffff; color:#334155; font-weight:600;' }}">
                {{ $stName }} Reviews <span style="background:{{ $isActive ? 'rgba(255,255,255,0.25)' : '#f1f5f9' }}; color:{{ $isActive ? '#ffffff' : '#475569' }}; padding:2px 8px; border-radius:10px; font-size:0.75rem; margin-left:4px; font-weight:800;">{{ $stCount }}</span>
            </a>
        @endforeach
    </div>

    <div class="table-card">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Reviewer</th>
                    <th>Product</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reviews as $review)
                    <tr>
                        <td>
                            <strong style="color:#0f172a; font-size:0.95rem; font-weight:800;">{{ $review->reviewer_name }}</strong>
                            <div style="font-size:0.78rem; color:#64748b; font-weight:600;">{{ $review->reviewer_email }}</div>
                        </td>
                        <td>
                            @if ($review->product)
                                <div>
                                    <a href="{{ route('admin.products.edit', $review->product->id) }}" style="color:#0f172a; font-weight:800; text-decoration:none; display:block;" title="Edit Product in Admin">
                                        {{ $review->product->name }}
                                    </a>
                                    <a href="{{ route('product.detail', $review->product->id) }}" target="_blank" style="display:inline-flex; align-items:center; gap:4px; font-size:0.75rem; color:#4f46e5; font-weight:700; text-decoration:none; margin-top:3px;">
                                        <span>View on Storefront</span>
                                        <span style="font-size:0.8rem;">↗</span>
                                    </a>
                                </div>
                            @else
                                <span style="color:#64748b; font-weight:600;">Deleted Product</span>
                            @endif
                        </td>
                        <td><span style="display:inline-flex; align-items:center; gap:3px; background:#fef3c7; color:#b45309; border:1px solid #fde68a; padding:2px 8px; border-radius:9999px; font-weight:800; font-size:0.8rem;">★ {{ $review->rating }}</span></td>
                        <td>
                            <div style="max-width:320px; font-size:0.9rem; color:#1e293b; line-height:1.5; font-weight:500;">
                                "{{ $review->comment }}"
                            </div>
                        </td>
                        <td>
                            @if ($review->status == 'Approved')
                                <span class="badge-status badge-green">Approved</span>
                            @elseif ($review->status == 'Pending')
                                <span class="badge-status badge-yellow">Pending</span>
                            @else
                                <span class="badge-status badge-red">Hidden</span>
                            @endif
                        </td>
                        <td style="font-size:0.82rem; color:#64748b; font-weight:600;">{{ $review->created_at->format('M d, Y') }}</td>
                        <td style="text-align:right;">
                            <div style="display:flex; justify-content:flex-end; gap:6px;">
                                @if ($review->status !== 'Approved')
                                    <form action="{{ route('admin.reviews.status', $review->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="Approved">
                                        <button type="submit" style="background:#ecfdf5; color:#15803d; border:1px solid #86efac; padding:5px 12px; font-size:0.78rem; font-weight:750; border-radius:6px; cursor:pointer;">Approve</button>
                                    </form>
                                @endif

                                @if ($review->status !== 'Hidden')
                                    <form action="{{ route('admin.reviews.status', $review->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="Hidden">
                                        <button type="submit" style="background:#fef3c7; color:#b45309; border:1px solid #fde68a; padding:5px 12px; font-size:0.78rem; font-weight:750; border-radius:6px; cursor:pointer;">Hide</button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST"
                                      data-confirm="Permanently purge this customer feedback and star rating? This will recompute the overall product review score."
                                      data-confirm-title="Delete Customer Review?"
                                      data-confirm-item="⭐ {{ $review->rating }}/5 by {{ $review->reviewer_name }}"
                                      data-confirm-badge="MODERATION ACTION"
                                      data-confirm-btn="Delete Review"
                                      data-confirm-type="danger"
                                      data-confirm-icon="🗑️">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-outline" style="padding:4px 8px; font-size:0.75rem; color:#f87171; transition:all 0.2s;">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:30px; color:var(--text-muted);">No reviews found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:24px;">
        {{ $reviews->links() }}
    </div>
@endsection
