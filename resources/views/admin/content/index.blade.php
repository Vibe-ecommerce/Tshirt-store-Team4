@extends('layouts.admin')

@section('title', 'Content Management')
@section('page-title', 'Storefront Content Management')

@section('content')
    <div style="max-width:900px; margin:0 auto;">
        <div style="margin-bottom:24px;">
            <h2 style="font-size:1.6rem; font-weight:800; color:#ffffff;">Storefront Content & Homepage Banners</h2>
            <p style="color:var(--text-muted); font-size:0.9rem;">Modify top announcements, hero taglines, featured collection items, and about/contact info.</p>
        </div>

        <form action="{{ route('admin.content.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- 1. Home Banner / Announcement -->
            <div style="background:var(--bg-card); border:1px solid var(--border-subtle); border-radius:var(--radius-lg); padding:28px; margin-bottom:24px;">
                <h3 style="font-size:1.2rem; font-weight:800; color:#ffffff; margin-bottom:16px;">1. Announcement Bar & Hero Headline</h3>

                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:0.85rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Top Announcement Bar Text</label>
                    <input type="text" name="announcement_text" class="form-control" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:12px; border-radius:var(--radius-md);" value="{{ $settings['announcement_text'] }}">
                </div>

                <div>
                    <label style="display:block; font-size:0.85rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Hero Headline / Tagline</label>
                    <input type="text" name="hero_tagline" class="form-control" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:12px; border-radius:var(--radius-md);" value="{{ $settings['hero_tagline'] }}">
                </div>
            </div>

            <!-- 2. Lookbook Editorial Campaign Banner (The Concrete Canvas) -->
            <div style="background:var(--bg-card); border:1px solid var(--border-subtle); border-radius:var(--radius-lg); padding:28px; margin-bottom:24px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                    <div>
                        <h3 style="font-size:1.25rem; font-weight:800; color:#ffffff; display:flex; align-items:center; gap:8px;">
                            <span>📸 2. Lookbook Editorial Campaign Banner (ផ្ទាំងរូបភាព Banner ទំព័រដើម)</span>
                            <span style="font-size:0.72rem; background:rgba(99,102,241,0.2); color:#a5b4fc; padding:2px 8px; border-radius:9999px; font-weight:700;">HOMEPAGE SPOTLIGHT</span>
                        </h3>
                        <p style="color:var(--text-muted); font-size:0.85rem; margin-top:3px;">
                            Change the large middle banner picture ("The Concrete Canvas") and customize its editorial text.
                        </p>
                    </div>
                </div>

                <!-- Current Banner Preview with Live Overlay -->
                <div style="position:relative; width:100%; height:230px; border-radius:var(--radius-md); overflow:hidden; border:1px solid var(--border-subtle); margin-bottom:18px; background:#000;">
                    <img id="bannerLivePreview" src="{{ asset($settings['lookbook_banner_image']) }}" alt="Banner Preview" style="width:100%; height:100%; object-fit:cover; transition:opacity 0.2s;">
                    <div style="position:absolute; inset:0; background:linear-gradient(90deg, rgba(10,14,23,0.9) 0%, rgba(10,14,23,0.45) 50%, rgba(10,14,23,0.7) 100%); display:flex; flex-direction:column; justify-content:center; padding:24px 30px;">
                        <span id="previewBadge" style="display:inline-block; align-self:flex-start; background:rgba(99,102,241,0.4); border:1px solid #6366f1; color:#ffffff; font-size:0.68rem; font-weight:800; padding:2px 10px; border-radius:9999px; margin-bottom:8px; letter-spacing:0.5px;">
                            {{ $settings['lookbook_badge'] }}
                        </span>
                        <h4 id="previewTitle" style="font-size:1.35rem; font-weight:800; color:#ffffff; margin:0 0 6px 0; line-height:1.2;">
                            {{ $settings['lookbook_title'] }} <span style="background:linear-gradient(135deg, #a5b4fc 0%, #ec4899 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent;" id="previewSubtitle">{{ $settings['lookbook_subtitle'] }}</span>
                        </h4>
                        <p id="previewDesc" style="color:#cbd5e1; font-size:0.82rem; margin:0 0 12px 0; max-width:500px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                            {{ $settings['lookbook_desc'] }}
                        </p>
                        <span style="display:inline-block; align-self:flex-start; background:var(--accent-gradient); color:#fff; font-size:0.75rem; font-weight:700; padding:6px 16px; border-radius:9999px; box-shadow:0 4px 12px rgba(99,102,241,0.4);">
                            {{ $settings['lookbook_btn_text'] }}
                        </span>
                    </div>
                    <div id="newBadgeNotice" style="position:absolute; top:12px; right:12px; background:rgba(16,185,129,0.92); backdrop-filter:blur(4px); color:#fff; font-size:0.72rem; font-weight:800; padding:4px 10px; border-radius:9999px; display:none;">
                        ✓ NEW PHOTO READY TO SAVE
                    </div>
                </div>

                <!-- Picture Upload Controls -->
                <div style="display:grid; grid-template-columns:1.2fr 1fr; gap:16px; margin-bottom:18px;">
                    <!-- Upload From Computer -->
                    <div onclick="document.getElementById('lookbook_image_file').click()" 
                         style="border:2px dashed rgba(99,102,241,0.45); background:rgba(99,102,241,0.05); border-radius:var(--radius-md); padding:16px; text-align:center; cursor:pointer; transition:all 0.2s;"
                         onmouseover="this.style.borderColor='#818cf8'; this.style.background='rgba(99,102,241,0.1)';"
                         onmouseout="this.style.borderColor='rgba(99,102,241,0.45)'; this.style.background='rgba(99,102,241,0.05)';">
                        <input type="file" id="lookbook_image_file" name="lookbook_image_file" accept="image/*" style="display:none;" onchange="previewBannerFile(this)">
                        <div style="width:38px; height:38px; border-radius:50%; background:rgba(99,102,241,0.18); display:inline-flex; align-items:center; justify-content:center; color:#818cf8; margin-bottom:8px;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        </div>
                        <div style="font-size:0.88rem; font-weight:700; color:#fff; margin-bottom:3px;">Upload New Banner Picture from Device</div>
                        <div style="font-size:0.72rem; color:var(--text-muted); margin-bottom:6px;">Click or Drag & Drop (PNG, JPG, WEBP)</div>
                        <span class="btn-primary" style="font-size:0.72rem; padding:4px 14px; pointer-events:none; border-radius:9999px;">Browse Computer...</span>
                    </div>

                    <!-- Presets or Image Path URL -->
                    <div style="background:var(--bg-input); border:1px solid var(--border-subtle); border-radius:var(--radius-md); padding:14px; display:flex; flex-direction:column; justify-content:space-between;">
                        <div>
                            <label style="display:block; font-size:0.75rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Or Paste Image URL / Path</label>
                            <input type="text" id="lookbook_banner_image_input" name="lookbook_banner_image" class="form-control" style="width:100%; background:#0a0e17; border:1px solid var(--border-subtle); color:#fff; padding:8px 10px; border-radius:var(--radius-md); font-size:0.82rem; margin-bottom:8px;" value="{{ $settings['lookbook_banner_image'] }}" oninput="previewBannerUrl(this.value)">
                        </div>
                        
                        <div>
                            <div style="font-size:0.68rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:4px;">Quick Presets:</div>
                            <div style="display:flex; gap:6px; flex-wrap:wrap;">
                                <button type="button" onclick="selectPresetBanner('/images/hero-editorial.jpg')" class="btn-outline" style="padding:4px 8px; font-size:0.72rem;">Urban Streetwear</button>
                                <button type="button" onclick="selectPresetBanner('/images/lookbook-portrait.jpg')" class="btn-outline" style="padding:4px 8px; font-size:0.72rem;">Studio Model</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Text Customization -->
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
                    <div>
                        <label style="display:block; font-size:0.78rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:5px;">Badge Text</label>
                        <input type="text" name="lookbook_badge" value="{{ $settings['lookbook_badge'] }}" class="form-control" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:10px; border-radius:var(--radius-md); font-size:0.85rem;" oninput="document.getElementById('previewBadge').textContent = this.value">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.78rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:5px;">Button Action Text</label>
                        <input type="text" name="lookbook_btn_text" value="{{ $settings['lookbook_btn_text'] }}" class="form-control" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:10px; border-radius:var(--radius-md); font-size:0.85rem;">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
                    <div>
                        <label style="display:block; font-size:0.78rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:5px;">Main Headline (Line 1)</label>
                        <input type="text" name="lookbook_title" value="{{ $settings['lookbook_title'] }}" class="form-control" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:10px; border-radius:var(--radius-md); font-size:0.85rem;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.78rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:5px;">Accent Subtitle (Gradient Line 2)</label>
                        <input type="text" name="lookbook_subtitle" value="{{ $settings['lookbook_subtitle'] }}" class="form-control" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:10px; border-radius:var(--radius-md); font-size:0.85rem;" oninput="document.getElementById('previewSubtitle').textContent = this.value">
                    </div>
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block; font-size:0.78rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:5px;">Banner Description Paragraph</label>
                    <textarea name="lookbook_desc" rows="2" class="form-control" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:10px; border-radius:var(--radius-md); font-size:0.85rem; resize:none;" oninput="document.getElementById('previewDesc').textContent = this.value">{{ $settings['lookbook_desc'] }}</textarea>
                </div>

                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:0.78rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:5px;">Button Target URL Link</label>
                    <input type="text" name="lookbook_btn_url" value="{{ $settings['lookbook_btn_url'] }}" class="form-control" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:10px; border-radius:var(--radius-md); font-size:0.85rem;" placeholder="/shop">
                </div>

                <div style="display:flex; justify-content:flex-end; padding-top:14px; border-top:1px solid var(--border-subtle);">
                    <button type="submit" class="btn-primary" style="padding:10px 22px; font-size:0.88rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Save Lookbook Banner Changes
                    </button>
                </div>
            </div>

            <!-- 3. Featured Products Selector -->
            <div style="background:var(--bg-card); border:1px solid var(--border-subtle); border-radius:var(--radius-lg); padding:28px; margin-bottom:24px;">
                <h3 style="font-size:1.2rem; font-weight:800; color:#ffffff; margin-bottom:10px;">3. Featured Products on Homepage</h3>
                <p style="color:var(--text-muted); font-size:0.85rem; margin-bottom:18px;">Check the t-shirts to pin directly into the homepage 'Featured Drops' grid.</p>

                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:12px;">
                    @foreach ($allProducts as $product)
                        <label style="display:flex; align-items:center; gap:10px; background:var(--bg-input); border:1px solid var(--border-subtle); padding:10px 14px; border-radius:var(--radius-md); cursor:pointer;">
                            <input type="checkbox" name="featured_ids[]" value="{{ $product->id }}" {{ $product->is_featured ? 'checked' : '' }}>
                            <img src="{{ asset($product->image) }}" alt="" style="width:32px; height:32px; border-radius:4px; object-fit:cover;">
                            <span style="font-size:0.88rem; font-weight:600; color:#fff;">{{ $product->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- 4. About Us & Contact Information -->
            <div style="background:var(--bg-card); border:1px solid var(--border-subtle); border-radius:var(--radius-lg); padding:28px; margin-bottom:28px;">
                <h3 style="font-size:1.2rem; font-weight:800; color:#ffffff; margin-bottom:16px;">4. About Us & Contact Information</h3>

                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:0.85rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Our Brand Story</label>
                    <textarea name="about_story" rows="3" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:12px; border-radius:var(--radius-md);">{{ $settings['about_story'] }}</textarea>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                    <div>
                        <label style="display:block; font-size:0.85rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Support Email</label>
                        <input type="email" name="support_email" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:12px; border-radius:var(--radius-md);" value="{{ $settings['support_email'] }}">
                    </div>

                    <div>
                        <label style="display:block; font-size:0.85rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Customer Service Phone</label>
                        <input type="text" name="phone" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:12px; border-radius:var(--radius-md);" value="{{ $settings['phone'] }}">
                    </div>
                </div>

                <div>
                    <label style="display:block; font-size:0.85rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Studio Location & Address</label>
                    <input type="text" name="address" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:12px; border-radius:var(--radius-md);" value="{{ $settings['address'] }}">
                </div>
            </div>

            <button type="submit" class="btn-primary" style="padding:14px 30px; font-size:1rem; width:100%; justify-content:center;">
                Save All Content Changes →
            </button>
        </form>
    </div>

    <script>
        function previewBannerFile(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('bannerLivePreview');
                    if (img) img.src = e.target.result;
                    const notice = document.getElementById('newBadgeNotice');
                    if (notice) notice.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function selectPresetBanner(url) {
            const img = document.getElementById('bannerLivePreview');
            if (img) img.src = url;
            const input = document.getElementById('lookbook_banner_image_input');
            if (input) input.value = url;
            const fileInput = document.getElementById('lookbook_image_file');
            if (fileInput) fileInput.value = '';
            const notice = document.getElementById('newBadgeNotice');
            if (notice) notice.style.display = 'block';
        }

        function previewBannerUrl(url) {
            if (url && url.trim()) {
                const img = document.getElementById('bannerLivePreview');
                if (img) img.src = url.trim();
            }
        }
    </script>
@endsection

