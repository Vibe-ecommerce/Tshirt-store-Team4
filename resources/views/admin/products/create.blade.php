@extends('layouts.admin')

@section('title', 'Add New T-Shirt')
@section('page-title', 'Create New Product')

@section('content')
<div class="no-scroll-view" style="max-width:1180px; margin:0 auto;">
    <!-- Top Action Bar -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
        <div style="display:flex; align-items:center; gap:12px;">
            <h2 style="font-size:1.45rem; font-weight:850; color:#0f172a !important; margin:0; letter-spacing:-0.3px;">Add New T-Shirt</h2>
            <span style="background:#eef2ff; border:1px solid #c7d2fe; color:#4338ca; font-size:0.75rem; font-weight:800; padding:3px 10px; border-radius:9999px; letter-spacing:0.5px;">
                CATALOG INVENTORY
            </span>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn-outline" style="padding:7px 16px; font-size:0.85rem; font-weight:750; color:#1e293b; background:#ffffff; border:1.5px solid #cbd5e1; border-radius:var(--radius-full); box-shadow:0 1px 2px rgba(0,0,0,0.04); display:inline-flex; align-items:center; gap:6px;">
            ← Back to Products
        </a>
    </div>

    <!-- Main Card with 2-Column Split Grid -->
    <div class="product-create-card" style="background:#ffffff; border:1.5px solid #e2e8f0; border-radius:var(--radius-lg); padding:24px 28px; box-shadow:0 4px 20px rgba(0,0,0,0.06);">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="addProductForm">
            @csrf

            <div class="product-form-grid" style="display:grid; grid-template-columns:1.2fr 0.8fr; gap:26px; align-items:start;">
                <!-- LEFT COLUMN: Product Specifications & Details -->
                <div style="display:flex; flex-direction:column; gap:14px;">
                    <!-- Row 1: Name & Category -->
                    <div style="display:grid; grid-template-columns:1.6fr 1fr; gap:14px;">
                        <div>
                            <label class="compact-label">Product Name *</label>
                            <input type="text" name="name" required class="compact-input" placeholder="e.g. Vintage Coastal Graphic Tee" value="{{ old('name') }}">
                        </div>
                        <div>
                            <label class="compact-label">Category *</label>
                            <select name="category" required class="compact-input">
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Row 2: Price, Original Price, Stock Quantity -->
                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px;">
                        <div>
                            <label class="compact-label">Price ($) *</label>
                            <input type="number" step="0.01" name="price" required class="compact-input" placeholder="29.99" value="{{ old('price') }}">
                        </div>
                        <div>
                            <label class="compact-label">Original / Compare ($)</label>
                            <input type="number" step="0.01" name="original_price" class="compact-input" placeholder="39.99" value="{{ old('original_price') }}">
                        </div>
                        <div>
                            <label class="compact-label">Stock Quantity *</label>
                            <input type="number" name="stock" min="0" required class="compact-input" placeholder="25" value="{{ old('stock', 25) }}">
                        </div>
                    </div>

                    <!-- Row 3: Color & Available Sizes -->
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                        <div>
                            <label class="compact-label">Color *</label>
                            <input type="text" name="color" required class="compact-input" placeholder="e.g. Onyx Black, Vintage Cream" value="{{ old('color') }}">
                        </div>
                        <div>
                            <label class="compact-label">Available Sizes (Comma-separated) *</label>
                            <input type="text" name="sizes" required class="compact-input" placeholder="S,M,L,XL,XXL" value="{{ old('sizes', 'S,M,L,XL,XXL') }}">
                        </div>
                    </div>

                    <!-- Row 4: Product Description -->
                    <div>
                        <label class="compact-label">Product Description *</label>
                        <textarea name="description" rows="2" required class="compact-input" style="height:68px; min-height:60px; max-height:90px; resize:none; line-height:1.5;" placeholder="Heavyweight 240 GSM organic cotton t-shirt with premium screen print...">{{ old('description') }}</textarea>
                    </div>

                    <!-- Row 5: Status & Visibility Chips (Compact interactive toggles) -->
                    <div>
                        <label class="compact-label" style="margin-bottom:8px;">Product Badges & Visibility</label>
                        <div class="status-chips-wrap" style="display:grid; grid-template-columns:repeat(4, 1fr); gap:10px;">
                            <label class="chip-item chip-green">
                                <input type="checkbox" name="in_stock" value="1" checked>
                                <span class="chip-dot"></span>
                                <span class="chip-label">In Stock</span>
                            </label>
                            <label class="chip-item chip-indigo">
                                <input type="checkbox" name="is_featured" value="1" checked>
                                <span class="chip-dot"></span>
                                <span class="chip-label">Featured</span>
                            </label>
                            <label class="chip-item chip-amber">
                                <input type="checkbox" name="is_bestseller" value="1">
                                <span class="chip-dot"></span>
                                <span class="chip-label">Best Seller</span>
                            </label>
                            <label class="chip-item chip-purple">
                                <input type="checkbox" name="is_latest" value="1" checked>
                                <span class="chip-dot"></span>
                                <span class="chip-label">Latest Release</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Visual Photo Selector & Quick Save Action -->
                <div style="display:flex; flex-direction:column; gap:12px; height:100%; justify-content:space-between;">
                    <div>
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                            <label class="compact-label" style="margin:0;">Product Picture *</label>
                            <span style="font-size:0.75rem; font-weight:600; color:#64748b;">Local file or store preset</span>
                        </div>

                        <!-- Hidden File and Value Inputs -->
                        <input type="file" id="image_file" name="image_file" accept="image/png,image/jpeg,image/webp,image/gif" style="display:none;" onchange="previewUploadImage(this)">
                        <input type="hidden" id="image_url" name="image_url" value="{{ old('image_url', '/images/products/tee-black.jpg') }}">

                        <!-- Side-by-Side: Mini Preview Card + Compact Dropzone -->
                        <div style="display:grid; grid-template-columns:120px 1fr; gap:12px; align-items:stretch; margin-bottom:12px;">
                            <!-- Preview Box -->
                            <div style="background:#f8fafc; border:1.5px solid #cbd5e1; border-radius:var(--radius-md); padding:10px; display:flex; flex-direction:column; align-items:center; text-align:center; box-shadow:0 1px 3px rgba(0,0,0,0.03);">
                                <div style="position:relative; width:100%; aspect-ratio:1/1; border-radius:8px; overflow:hidden; background:#ffffff; border:1px solid #e2e8f0; display:flex; align-items:center; justify-content:center;">
                                    <img id="previewImg" src="{{ asset(old('image_url', '/images/products/tee-black.jpg')) }}" alt="Product Preview" style="width:100%; height:100%; object-fit:cover;">
                                    <div id="uploadBadge" style="position:absolute; top:4px; right:4px; background:#059669; color:#fff; font-size:0.65rem; font-weight:800; padding:2px 6px; border-radius:9999px; display:none;">
                                        ✓ NEW
                                    </div>
                                </div>
                                <div style="font-size:0.78rem; font-weight:750; color:#0f172a; margin-top:6px; max-width:104px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" id="previewFileName">
                                    tee-black.jpg
                                </div>
                                <button type="button" id="resetBtn" onclick="resetPictureSelection()" style="margin-top:4px; background:#fee2e2; border:1px solid #fecaca; color:#b91c1c; padding:3px 8px; border-radius:6px; font-size:0.72rem; font-weight:750; cursor:pointer; display:none; width:100%;">
                                    ✕ Revert
                                </button>
                            </div>

                            <!-- Compact Dropzone Box -->
                            <div id="dropzoneBox" onclick="document.getElementById('image_file').click()"
                                 ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)" ondrop="handleDrop(event)"
                                 style="border:2px dashed #818cf8; background:#f8fafc; border-radius:var(--radius-md); padding:14px; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; cursor:pointer; transition:all 0.2s ease;">
                                <div style="width:36px; height:36px; border-radius:50%; background:#e0e7ff; display:flex; align-items:center; justify-content:center; color:#4f46e5; margin-bottom:8px;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
                                        <circle cx="9" cy="9" r="2"></circle>
                                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                                    </svg>
                                </div>
                                <div style="font-size:0.88rem; font-weight:800; color:#0f172a; margin-bottom:3px;">
                                    Upload Photo
                                </div>
                                <div style="font-size:0.74rem; font-weight:600; color:#64748b; margin-bottom:8px;">
                                    Click or Drag & Drop (PNG, JPG max 10MB)
                                </div>
                                <span class="btn-primary" style="font-size:0.75rem; font-weight:750; padding:5px 14px; pointer-events:none; border-radius:9999px;">
                                    Browse Device...
                                </span>
                            </div>
                        </div>

                        <!-- Multi-Angle Gallery Upload Section (រូបភាពពហុមុំបន្ថែម) -->
                        <div style="margin-top:12px; background:#f8fafc; border:1.5px solid #cbd5e1; border-radius:var(--radius-md); padding:12px 14px; box-shadow:0 1px 3px rgba(0,0,0,0.03);">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <div>
                                    <div style="font-size:0.82rem; font-weight:850; color:#0f172a; display:flex; align-items:center; gap:8px;">
                                        <span>📸 Multi-Angle Gallery (រូបភាពពហុមុំ)</span>
                                        <span style="font-size:0.68rem; background:#e0e7ff; color:#4338ca; padding:2px 8px; border-radius:4px; font-weight:800;">Draggable Slider</span>
                                    </div>
                                    <div style="font-size:0.72rem; font-weight:600; color:#475569; margin-top:3px;">
                                        Upload extra angles for customer thumbnail slider (e.g. Side, Box, On wrist, Back)
                                    </div>
                                </div>
                                <button type="button" onclick="document.getElementById('gallery_files_input').click()" style="background:#ffffff; border:1.5px solid #c7d2fe; color:#4f46e5; font-size:0.76rem; font-weight:800; padding:5px 12px; border-radius:var(--radius-sm); cursor:pointer; display:flex; align-items:center; gap:4px; box-shadow:0 1px 2px rgba(0,0,0,0.04); transition:all 0.2s;" onmouseover="this.style.background='#eef2ff'" onmouseout="this.style.background='#ffffff'">
                                    <span>+ Add Photos</span>
                                </button>
                            </div>

                            <!-- Hidden Multiple Files Input -->
                            <input type="file" id="gallery_files_input" name="gallery_files[]" multiple accept="image/png,image/jpeg,image/webp,image/gif" style="display:none;" onchange="handleGalleryFiles(this)">

                            <!-- Dynamic Gallery Previews Track -->
                            <div id="galleryPreviewsTrack" style="display:flex; gap:8px; overflow-x:auto; padding:4px 2px; min-height:68px; align-items:center;">
                                <div id="galleryEmptyNotice" onclick="document.getElementById('gallery_files_input').click()" style="width:100%; border:1.5px dashed #cbd5e1; border-radius:6px; padding:12px; text-align:center; color:#475569; font-size:0.76rem; font-weight:600; cursor:pointer; background:#ffffff;">
                                    + Click to upload multiple angles (Side angle, Box, On wrist, Back...)
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons: Save & Publish (Prominent) -->
                    <div style="margin-top:10px; display:flex; flex-direction:column; gap:6px;">
                        <button type="submit" class="btn-primary" style="padding:12px 24px; font-size:0.95rem; font-weight:800; width:100%; justify-content:center; border-radius:var(--radius-md); box-shadow:0 4px 18px rgba(79,70,229,0.4); cursor:pointer;">
                            Save & Publish Product →
                        </button>
                        <div style="text-align:center;">
                            <a href="{{ route('admin.products.index') }}" style="font-size:0.82rem; font-weight:700; color:#64748b; text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='#0f172a'; this.style.textDecoration='underline';" onmouseout="this.style.color='#64748b'; this.style.textDecoration='none';">
                                Discard & Return to Catalog
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Remove padding excess for admin content on create page to guarantee zero-scroll fit */
    .admin-content {
        padding: 16px 28px !important;
    }

    .compact-label {
        display: block;
        font-size: 0.80rem;
        font-weight: 800;
        color: #1e293b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .compact-input {
        width: 100%;
        background: #ffffff !important;
        border: 1.5px solid #cbd5e1 !important;
        color: #0f172a !important;
        padding: 9px 13px;
        font-size: 0.90rem;
        font-weight: 600;
        border-radius: var(--radius-md);
        transition: all 0.2s ease;
        outline: none;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
    }

    .compact-input::placeholder {
        color: #94a3b8;
        font-weight: 500;
    }

    .compact-input:focus {
        border-color: #4f46e5 !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15) !important;
        background: #ffffff !important;
    }

    /* Status & Visibility Chips */
    .chip-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: var(--radius-md);
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        cursor: pointer;
        user-select: none;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    }

    .chip-item input[type="checkbox"] {
        display: none;
    }

    .chip-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #94a3b8;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .chip-label {
        font-size: 0.80rem;
        font-weight: 750;
        color: #475569;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Active states when checked */
    .chip-green:has(input:checked) {
        background: #ecfdf5;
        border-color: #059669;
    }
    .chip-green:has(input:checked) .chip-dot {
        background: #059669;
        box-shadow: 0 0 8px #10b981;
    }
    .chip-green:has(input:checked) .chip-label {
        color: #065f46;
        font-weight: 800;
    }

    .chip-indigo:has(input:checked) {
        background: #eef2ff;
        border-color: #4f46e5;
    }
    .chip-indigo:has(input:checked) .chip-dot {
        background: #4f46e5;
        box-shadow: 0 0 8px #6366f1;
    }
    .chip-indigo:has(input:checked) .chip-label {
        color: #3730a3;
        font-weight: 800;
    }

    .chip-amber:has(input:checked) {
        background: #fffbeb;
        border-color: #d97706;
    }
    .chip-amber:has(input:checked) .chip-dot {
        background: #d97706;
        box-shadow: 0 0 8px #f59e0b;
    }
    .chip-amber:has(input:checked) .chip-label {
        color: #92400e;
        font-weight: 800;
    }

    .chip-purple:has(input:checked) {
        background: #faf5ff;
        border-color: #9333ea;
    }
    .chip-purple:has(input:checked) .chip-dot {
        background: #9333ea;
        box-shadow: 0 0 8px #c084fc;
    }
    .chip-purple:has(input:checked) .chip-label {
        color: #6b21a8;
        font-weight: 800;
    }

    .preset-thumb:hover {
        transform: translateY(-2px) scale(1.06);
        border-color: #818cf8 !important;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);
    }

    .preset-thumb.active {
        border-color: #6366f1 !important;
        box-shadow: 0 0 10px rgba(99, 102, 241, 0.6);
    }

    @media (max-width: 900px) {
        .product-form-grid {
            grid-template-columns: 1fr !important;
        }
        .status-chips-wrap {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    function previewUploadImage(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('uploadBadge').style.display = 'block';
                document.getElementById('previewFileName').textContent = file.name;
                document.getElementById('resetBtn').style.display = 'block';
                
                // clear preset visual active states
                document.querySelectorAll('.preset-thumb').forEach(el => {
                    el.classList.remove('active');
                    el.style.borderColor = 'rgba(255,255,255,0.1)';
                });
                // clear image_url so controller uploads image_file
                document.getElementById('image_url').value = '';
            };
            
            reader.readAsDataURL(file);
        }
    }

    function selectPreset(path, name, el) {
        const fileInput = document.getElementById('image_file');
        if (fileInput) fileInput.value = '';
        
        document.getElementById('previewImg').src = path;
        document.getElementById('uploadBadge').style.display = 'none';
        document.getElementById('previewFileName').textContent = name;
        document.getElementById('resetBtn').style.display = 'none';
        document.getElementById('image_url').value = path;
        
        document.querySelectorAll('.preset-thumb').forEach(item => {
            item.classList.remove('active');
            item.style.borderColor = 'rgba(255,255,255,0.1)';
        });
        if (el) {
            el.classList.add('active');
            el.style.borderColor = '#6366f1';
        }
    }

    function resetPictureSelection() {
        const fileInput = document.getElementById('image_file');
        if (fileInput) fileInput.value = '';
        const firstPreset = document.querySelector('.preset-thumb');
        selectPreset('/images/products/tee-black.jpg', 'Black Tee', firstPreset);
    }

    function handleDragOver(e) {
        e.preventDefault();
        e.stopPropagation();
        const drop = document.getElementById('dropzoneBox');
        if (drop) {
            drop.style.borderColor = '#818cf8';
            drop.style.background = 'rgba(99, 102, 241, 0.14)';
        }
    }

    function handleDragLeave(e) {
        e.preventDefault();
        e.stopPropagation();
        const drop = document.getElementById('dropzoneBox');
        if (drop) {
            drop.style.borderColor = 'rgba(99, 102, 241, 0.45)';
            drop.style.background = 'rgba(99, 102, 241, 0.04)';
        }
    }

    function handleDrop(e) {
        e.preventDefault();
        e.stopPropagation();
        handleDragLeave(e);
        
        const dt = e.dataTransfer;
        const files = dt ? dt.files : null;
        if (files && files.length > 0) {
            const input = document.getElementById('image_file');
            input.files = files;
            previewUploadImage(input);
        }
    }

    // Gallery Files Handler for Multi-Angle Photos
    function handleGalleryFiles(input) {
        const track = document.getElementById('galleryPreviewsTrack');
        const emptyNotice = document.getElementById('galleryEmptyNotice');
        if (!input.files || input.files.length === 0) return;

        if (emptyNotice) {
            emptyNotice.style.display = 'none';
        }

        const defaultLabels = ['Side angle', 'Charging box', 'On wrist', 'Sensor back', 'Detail view', 'Packaging'];
        let currentCount = track.querySelectorAll('.gallery-preview-item').length;

        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            const lbl = defaultLabels[(currentCount + index) % defaultLabels.length];

            reader.onload = function(e) {
                const item = document.createElement('div');
                item.className = 'gallery-preview-item';
                item.style.cssText = 'flex:0 0 auto; width:72px; display:flex; flex-direction:column; align-items:center; position:relative; background:#ffffff; border:1.5px solid #cbd5e1; border-radius:8px; padding:4px; box-shadow:0 1px 3px rgba(0,0,0,0.05);';
                item.innerHTML = `
                    <div style="width:62px; height:62px; border-radius:4px; overflow:hidden; position:relative;">
                        <img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">
                        <button type="button" onclick="this.closest('.gallery-preview-item').remove()" title="Remove" style="position:absolute; top:2px; right:2px; width:18px; height:18px; border-radius:50%; background:rgba(239,68,68,0.9); border:none; color:#fff; font-size:10px; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center;">✕</button>
                    </div>
                    <input type="text" name="gallery_labels[]" value="${lbl}" placeholder="Label" title="Click to rename label" style="width:100%; background:#ffffff; border:1px solid #cbd5e1; border-radius:4px; color:#0f172a; font-size:0.65rem; font-weight:700; text-align:center; padding:3px 2px; margin-top:4px; outline:none;">
                `;
                track.appendChild(item);
            };
            reader.readAsDataURL(file);
        });
    }
</script>
@endsection
