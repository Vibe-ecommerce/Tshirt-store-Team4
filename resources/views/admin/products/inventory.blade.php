@extends('layouts.admin')

@section('title', 'Stock & Inventory Management')
@section('page-title', 'Inventory & Stock Control')

@section('content')
    <!-- Top Action Bar -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:16px;">
        <div>
            <div style="display:flex; align-items:center; gap:10px;">
                <h2 style="font-size:1.6rem; font-weight:850; color:#0f172a; letter-spacing:-0.4px; margin:0;">Inventory & Stock Levels</h2>
                <span style="background:#eef2ff; color:#4f46e5; font-size:0.75rem; font-weight:800; padding:3px 10px; border-radius:9999px; border:1px solid #c7d2fe;">
                    Real-time
                </span>
            </div>
            <p style="color:#475569; font-size:0.92rem; font-weight:500; margin-top:4px; margin-bottom:0;">
                Set numeric stock quantities, monitor stockout alerts, and manage warehouse availability in real time.
            </p>
        </div>
        <div style="display:flex; gap:12px;">
            <a href="{{ route('admin.products.create') }}" class="btn-primary" style="padding:9px 20px; font-size:0.88rem; font-weight:750; box-shadow:0 4px 14px rgba(79, 70, 229, 0.3);">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>Add New Product</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="btn-outline" style="padding:9px 18px; font-size:0.88rem; font-weight:700; color:#1e293b; background:#ffffff; border:1.5px solid #cbd5e1;">
                ← Back to Catalog
            </a>
        </div>
    </div>

    <!-- Inventory Overview KPI Cards -->
    @php
        $totalStockUnits = $products->sum('stock');
        $inStockCount = $products->filter(fn($p) => !$p->isOutOfStock())->count();
        $lowStockCount = $products->filter(fn($p) => $p->isLowStock())->count();
        $stockoutCount = $products->filter(fn($p) => $p->isOutOfStock())->count();
    @endphp

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(230px, 1fr)); gap:18px; margin-bottom:28px;">
        <!-- Card 1: Total Stock -->
        <div style="background:#ffffff; border:1.5px solid #e2e8f0; border-radius:14px; padding:20px 22px; box-shadow:0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.02); display:flex; flex-direction:column; justify-content:space-between;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <span style="background:#f1f5f9; color:#334155; font-size:0.75rem; font-weight:800; text-transform:uppercase; letter-spacing:0.5px; padding:3px 9px; border-radius:6px; border:1px solid #e2e8f0;">
                    Total Units
                </span>
                <span style="font-size:1.1rem;">📦</span>
            </div>
            <div>
                <div style="font-size:2rem; font-weight:850; color:#0f172a; line-height:1.1;">
                    {{ number_format($totalStockUnits) }}
                    <span style="font-size:0.92rem; color:#64748b; font-weight:600;">pieces</span>
                </div>
                <div style="font-size:0.8rem; color:#475569; font-weight:600; margin-top:6px;">Across all warehouse catalog</div>
            </div>
        </div>

        <!-- Card 2: In Stock -->
        <div style="background:#ffffff; border:1.5px solid #bbf7d0; border-radius:14px; padding:20px 22px; box-shadow:0 1px 3px rgba(16,185,129,0.06), 0 4px 12px rgba(16,185,129,0.04); display:flex; flex-direction:column; justify-content:space-between;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <span style="background:#dcfce7; color:#15803d; font-size:0.75rem; font-weight:800; text-transform:uppercase; letter-spacing:0.5px; padding:3px 9px; border-radius:6px; border:1px solid #86efac;">
                    In Stock Items
                </span>
                <span style="font-size:1.1rem;">✅</span>
            </div>
            <div>
                <div style="font-size:2rem; font-weight:850; color:#15803d; line-height:1.1;">
                    {{ $inStockCount }}
                    <span style="font-size:0.92rem; color:#166534; font-weight:600;">products</span>
                </div>
                <div style="font-size:0.8rem; color:#15803d; font-weight:600; margin-top:6px;">Healthy ready-to-ship stock</div>
            </div>
        </div>

        <!-- Card 3: Low Stock Warning -->
        <div style="background:#ffffff; border:1.5px solid #fde68a; border-radius:14px; padding:20px 22px; box-shadow:0 1px 3px rgba(245,158,11,0.06), 0 4px 12px rgba(245,158,11,0.04); display:flex; flex-direction:column; justify-content:space-between;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <span style="background:#fef3c7; color:#b45309; font-size:0.75rem; font-weight:800; text-transform:uppercase; letter-spacing:0.5px; padding:3px 9px; border-radius:6px; border:1px solid #fcd34d;">
                    Low Stock (≤ 10)
                </span>
                <span style="font-size:1.1rem;">⚠️</span>
            </div>
            <div>
                <div style="font-size:2rem; font-weight:850; color:#b45309; line-height:1.1;">
                    {{ $lowStockCount }}
                    <span style="font-size:0.92rem; color:#92400e; font-weight:600;">products</span>
                </div>
                <div style="font-size:0.8rem; color:#b45309; font-weight:600; margin-top:6px;">Restock recommended soon</div>
            </div>
        </div>

        <!-- Card 4: Out of Stock Alert -->
        <div style="background:#ffffff; border:1.5px solid #fecaca; border-radius:14px; padding:20px 22px; box-shadow:0 1px 3px rgba(239,68,68,0.06), 0 4px 12px rgba(239,68,68,0.04); display:flex; flex-direction:column; justify-content:space-between;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <span style="background:#fee2e2; color:#b91c1c; font-size:0.75rem; font-weight:800; text-transform:uppercase; letter-spacing:0.5px; padding:3px 9px; border-radius:6px; border:1px solid #fca5a5;">
                    Stockout / Sold Out
                </span>
                <span style="font-size:1.1rem;">🚨</span>
            </div>
            <div>
                <div style="font-size:2rem; font-weight:850; color:#b91c1c; line-height:1.1;">
                    {{ $stockoutCount }}
                    <span style="font-size:0.92rem; color:#991b1b; font-weight:600;">products</span>
                </div>
                <div style="font-size:0.8rem; color:#b91c1c; font-weight:600; margin-top:6px;">Requires immediate replenishment</div>
            </div>
        </div>
    </div>

    <!-- Inventory Data Table -->
    <div style="background:#ffffff; border:1.5px solid #e2e8f0; border-radius:16px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.04), 0 6px 18px rgba(0,0,0,0.02);">
        <table style="width:100%; border-collapse:collapse; text-align:left;">
            <thead>
                <tr style="background:#f8fafc; border-bottom:1.5px solid #e2e8f0;">
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px;">Item</th>
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px;">Category</th>
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px;">Color Variant</th>
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px;">Unit Price</th>
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px; min-width:190px;">Stock Quantity</th>
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px;">Stock Status</th>
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px; text-align:right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr style="border-bottom:1px solid #f1f5f9; transition:background 0.15s; {{ $product->isOutOfStock() ? 'background:#fffafa;' : '' }}" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='{{ $product->isOutOfStock() ? '#fffafa' : '#ffffff' }}'">
                        <!-- Item -->
                        <td style="padding:16px 20px;">
                            <div style="display:flex; align-items:center; gap:14px;">
                                <div style="position:relative; width:48px; height:48px; flex-shrink:0;">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" style="width:100%; height:100%; border-radius:10px; object-fit:cover; border:1px solid #e2e8f0; {{ $product->isOutOfStock() ? 'filter:grayscale(65%); opacity:0.75;' : '' }}">
                                    @if ($product->isOutOfStock())
                                        <span style="position:absolute; bottom:0; left:0; right:0; background:#dc2626; color:#ffffff; font-size:0.6rem; font-weight:850; text-align:center; border-radius:0 0 9px 9px; line-height:1.3; letter-spacing:0.5px;">OUT</span>
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" style="font-weight:800; color:#0f172a; font-size:0.95rem; text-decoration:none; display:inline-block; transition:color 0.15s;" onmouseover="this.style.color='#4f46e5'" onmouseout="this.style.color='#0f172a'">
                                        {{ $product->name }}
                                    </a>
                                    <div style="font-size:0.78rem; font-weight:600; color:#475569; margin-top:3px;">
                                        SKU: <span style="font-family:ui-monospace,SFMono-Regular,Consolas,monospace; font-weight:750; color:#1e293b;">TC-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Category -->
                        <td style="padding:16px 20px;">
                            <span style="display:inline-block; font-size:0.85rem; font-weight:700; color:#334155; background:#f1f5f9; padding:4px 10px; border-radius:6px; border:1px solid #e2e8f0;">
                                {{ $product->category }}
                            </span>
                        </td>

                        <!-- Color Variant -->
                        <td style="padding:16px 20px;">
                            <span style="display:inline-flex; align-items:center; gap:8px; font-weight:650; color:#1e293b; font-size:0.9rem;">
                                <span style="width:12px; height:12px; border-radius:50%; background:#4f46e5; border:1.5px solid rgba(0,0,0,0.12); display:inline-block; flex-shrink:0;"></span>
                                {{ $product->color ?? 'Standard' }}
                            </span>
                        </td>

                        <!-- Unit Price -->
                        <td style="padding:16px 20px;">
                            <span style="font-weight:850; color:#0f172a; font-size:1rem;">
                                ${{ number_format($product->price, 2) }}
                            </span>
                        </td>
                        
                        <!-- Quick Quantity Editor -->
                        <td style="padding:16px 20px;">
                            <form action="{{ route('admin.products.update_stock', $product->id) }}" method="POST" style="display:inline-flex; align-items:center; gap:8px; margin:0;">
                                @csrf
                                <div style="display:inline-flex; align-items:center; background:#ffffff; border:1.5px solid #cbd5e1; border-radius:9px; overflow:hidden; box-shadow:0 1px 2px rgba(0,0,0,0.04);">
                                    <button type="button" onclick="let inp = this.nextElementSibling; if(parseInt(inp.value)>0){inp.value=parseInt(inp.value)-1;}" style="background:#f8fafc; border:none; border-right:1px solid #cbd5e1; color:#334155; width:30px; height:34px; cursor:pointer; font-weight:850; font-size:1.1rem; display:flex; align-items:center; justify-content:center; transition:background 0.15s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f8fafc'" title="Decrease Stock">−</button>
                                    <input type="number" name="stock" value="{{ $product->stock }}" min="0" style="width:52px; text-align:center; background:#ffffff; border:none; color:#0f172a; font-weight:850; font-size:0.95rem; outline:none; -moz-appearance:textfield; padding:4px 0;" required>
                                    <button type="button" onclick="let inp = this.previousElementSibling; inp.value=parseInt(inp.value)+1;" style="background:#f8fafc; border:none; border-left:1px solid #cbd5e1; color:#334155; width:30px; height:34px; cursor:pointer; font-weight:850; font-size:1.1rem; display:flex; align-items:center; justify-content:center; transition:background 0.15s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f8fafc'" title="Increase Stock">+</button>
                                </div>
                                <button type="submit" style="background:#4f46e5; color:#ffffff; border:none; padding:8px 14px; font-size:0.8rem; font-weight:750; border-radius:8px; cursor:pointer; box-shadow:0 2px 6px rgba(79,70,229,0.3); transition:all 0.15s; display:inline-flex; align-items:center; gap:4px;" onmouseover="this.style.background='#4338ca'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='#4f46e5'; this.style.transform='none';" title="Save Updated Stock Count">
                                    Save
                                </button>
                            </form>
                        </td>

                        <!-- Stock Status Badge -->
                        <td style="padding:16px 20px;">
                            @if ($product->isOutOfStock())
                                <span style="display:inline-flex; align-items:center; gap:6px; background:#fee2e2; color:#b91c1c; border:1.5px solid #fecaca; padding:5px 12px; border-radius:9999px; font-weight:850; font-size:0.75rem; letter-spacing:0.4px;">
                                    <span style="font-size:0.85rem; line-height:1;">✕</span> STOCKOUT
                                </span>
                            @elseif ($product->isLowStock())
                                <span style="display:inline-flex; align-items:center; gap:6px; background:#fef3c7; color:#b45309; border:1.5px solid #fde68a; padding:5px 12px; border-radius:9999px; font-weight:850; font-size:0.75rem; letter-spacing:0.3px;">
                                    <span style="font-size:0.85rem; line-height:1;">⚠️</span> LOW STOCK ({{ $product->stock }})
                                </span>
                            @else
                                <span style="display:inline-flex; align-items:center; gap:6px; background:#dcfce7; color:#15803d; border:1.5px solid #bbf7d0; padding:5px 12px; border-radius:9999px; font-weight:850; font-size:0.75rem; letter-spacing:0.3px;">
                                    <span style="font-size:0.85rem; line-height:1;">✓</span> IN STOCK ({{ $product->stock }})
                                </span>
                            @endif
                        </td>

                        <!-- Action Button -->
                        <td style="padding:16px 20px; text-align:right;">
                            <div style="display:inline-flex; align-items:center; gap:8px;">
                                <form action="{{ route('admin.products.toggle_stock', $product->id) }}" method="POST" style="display:inline; margin:0;">
                                    @csrf
                                    @if ($product->isOutOfStock())
                                        <button type="submit" style="background:#ecfdf5; color:#15803d; border:1.5px solid #86efac; padding:7px 14px; font-size:0.82rem; font-weight:750; border-radius:9999px; cursor:pointer; display:inline-flex; align-items:center; gap:5px; box-shadow:0 1px 2px rgba(16,185,129,0.1); transition:all 0.15s;" onmouseover="this.style.background='#10b981'; this.style.color='#ffffff'; this.style.borderColor='#10b981';" onmouseout="this.style.background='#ecfdf5'; this.style.color='#15803d'; this.style.borderColor='#86efac';">
                                            ✓ Restock (+25)
                                        </button>
                                    @else
                                        <button type="submit" style="background:#fff1f2; color:#be123c; border:1.5px solid #fecdd3; padding:7px 14px; font-size:0.82rem; font-weight:750; border-radius:9999px; cursor:pointer; display:inline-flex; align-items:center; gap:5px; box-shadow:0 1px 2px rgba(225,29,72,0.06); transition:all 0.15s;" onmouseover="this.style.background='#e11d48'; this.style.color='#ffffff'; this.style.borderColor='#e11d48';" onmouseout="this.style.background='#fff1f2'; this.style.color='#be123c'; this.style.borderColor='#fecdd3';">
                                            Mark Stockout
                                        </button>
                                    @endif
                                </form>
                                <a href="{{ route('admin.products.edit', $product->id) }}" style="background:#ffffff; color:#334155; border:1.5px solid #cbd5e1; width:34px; height:34px; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; font-size:0.95rem; text-decoration:none; box-shadow:0 1px 2px rgba(0,0,0,0.04); transition:all 0.15s;" onmouseover="this.style.background='#f1f5f9'; this.style.color='#4f46e5'; this.style.borderColor='#94a3b8';" onmouseout="this.style.background='#ffffff'; this.style.color='#334155'; this.style.borderColor='#cbd5e1';" title="Edit Product">
                                    ✎
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
