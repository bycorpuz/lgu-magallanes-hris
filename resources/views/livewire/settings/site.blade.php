<div>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Settings</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('my-profile') }}"><i class="bx bx-user-circle"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Site Settings</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills mb-3" role="tablist">
                <li class="nav-item" role="presentation">
                    <a wire:click.prevent="selectTab('general_settings')" class="nav-link {{ $tab == 'general_settings' ? 'active' : '' }}" data-bs-toggle="pill" href="#general_settings_tab" role="tab" aria-selected="true">
                        <div class="d-flex align-items-center">
                            <div class="tab-icon"><i class="bx bx-cog font-18 me-1"></i>
                            </div>
                            <div class="tab-title">General Settings</div>
                        </div>
                    </a>
                </li>
                {{-- <li class="nav-item" role="presentation">
                    <a wire:click.prevent="selectTab('logo_favicon')" class="nav-link {{ $tab == 'logo_favicon' ? 'active' : '' }}" data-bs-toggle="pill" href="#logo_favicon_tab" role="tab" aria-selected="false" tabindex="-1">
                        <div class="d-flex align-items-center">
                            <div class="tab-icon"><i class="bx bx-outline font-18 me-1"></i>
                            </div>
                            <div class="tab-title">Logo and Favicon</div>
                        </div>
                    </a>
                </li> --}}
                <li class="nav-item" role="presentation">
                    <a wire:click.prevent="selectTab('social_networks')" class="nav-link {{ $tab == 'social_networks' ? 'active' : '' }}" data-bs-toggle="pill" href="#social_networks_tab" role="tab" aria-selected="false" tabindex="-1">
                        <div class="d-flex align-items-center">
                            <div class="tab-icon"><i class="bx bx-network-chart font-18 me-1"></i>
                            </div>
                            <div class="tab-title">Social Networks</div>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade {{ $tab == 'general_settings' ? 'active show' : '' }}" id="general_settings_tab" role="tabpanel">
                    <div class="p-2">
                        <form class="row g-3" wire:submit.prevent="updateGeneralSettings">
                            @csrf
                            <div class="col-md-4">
                                <label for="site_name" class="form-label">Site Name</label>
                                <input type="text" class="form-control" id="site_name" placeholder="Site Name" wire:model="site_name">
                                @error('site_name')
                                    <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="site_email" class="form-label">Site Email</label>
                                <input type="text" class="form-control" id="site_email" placeholder="Site Email" wire:model="site_email">
                                @error('site_email')
                                    <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="site_phone" class="form-label">Site Phone</label>
                                <input type="text" class="form-control" id="site_phone" placeholder="Site Phone" wire:model="site_phone">
                                @error('site_phone')
                                    <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="site_meta_keywords" class="form-label">Site Meta Keywords <small>Separated by coma (a,b,c)</small></label>
                                <input type="text" class="form-control" id="site_meta_keywords" placeholder="Site Meta Keywords" wire:model="site_meta_keywords">
                                @error('site_meta_keywords')
                                    <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <label for="site_meta_description" class="form-label">Site Meta Description</label>
                                <textarea class="form-control" id="site_meta_description" placeholder="Site Meta Description" wire:model="site_meta_description" rows="1"></textarea>
                                @error('site_meta_description')
                                    <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- <div class="tab-pane fade {{ $tab == 'logo_favicon' ? 'active show' : '' }}" id="logo_favicon_tab" role="tabpanel">
                    <div class="row p-2">
                        <div class="col-md-6">
                            <form class="row g-3" action="{{ route('site-settings-change-logo') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <div id="siteOldLogoPreview">
                                        <label class="form-label">Current Site Logo</label>
                                        <div><img src="/images/site/{{ $site_logo }}" id="siteLogo" alt="Site Logo" style="width: 122px; height: 83px;"></div>
                                    </div>
                                    <div>
                                        <br>
                                        <label class="form-label">Site Logo to be updated</label>
                                        <div id="siteLogoPreview"><small>Selected Site Logo will be apper hear.</small></div>
                                    </div>
                                    <br>
                                    <label for="site_logo_filename" class="form-label">Site Logo</label>
                                    <input class="form-control" type="file" name="site_logo_filename" id="site_logo_filename" accept="image/*">
                                    
                                    <p class="mt-0 mb-0 font-13 text-danger site_logo_filename_error"></p>

                                </div>
                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary">Change Site Logo</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <div class="col-md-6">
                            <form class="row g-3" id="changeSiteFaviconForm" action="{{ route('site-settings-change-favicon') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <div id="siteOldFaviconPreview">
                                        <label class="form-label">Current Site Favicon</label>
                                        <div><img src="/images/site/{{ $site_favicon }}" name="siteFavicon" id="siteFavicon" alt="Site Favicon" style="width: 32px; height: 21px;"></div>
                                    </div>
                                    <div>
                                        <br>
                                        <label class="form-label">Site Favicon to be updated</label>
                                        <div id="siteFaviconPreview"><small>Selected Site Favicon will be apper hear.</small></div>
                                    </div>
                                    <br>
                                    <label for="site_favicon" class="form-label">Site Favicon</label>
                                    <input class="form-control" type="file" id="site_favicon" name="site_favicon" accept="image/*">
                                    <p class="mt-0 mb-0 font-13 text-danger site_favicon_error"></p>

                                </div>
                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary">Change Site Favicon</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> --}}
                <div class="tab-pane fade {{ $tab == 'social_networks' ? 'active show' : '' }}" id="social_networks_tab" role="tabpanel">
                    <div class="p-2">
                        <form class="row g-3" wire:submit.prevent="updateSocialNetworks">
                            @csrf
                            <div class="col-md-6">
                                <label for="facebook_url" class="form-label">Facebook URL</label>
                                <input type="text" class="form-control" id="facebook_url" placeholder="Facebook URL" wire:model="facebook_url">
                                @error('facebook_url')
                                    <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="twitter_url" class="form-label">Twitter URL</label>
                                <input type="text" class="form-control" id="twitter_url" placeholder="Twitter URL" wire:model="twitter_url">
                                @error('twitter_url')
                                    <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="youtube_url" class="form-label">Youtube URL</label>
                                <input type="text" class="form-control" id="youtube_url" placeholder="Youtube URL" wire:model="youtube_url">
                                @error('youtube_url')
                                    <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="instagram_url" class="form-label">Instagram URL</label>
                                <input type="text" class="form-control" id="instagram_url" placeholder="Instagram URL" wire:model="instagram_url">
                                @error('instagram_url')
                                    <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            siteLogoPreview();
            function siteLogoPreview() {
                // Get references to the input and div elements
                const imageInput = $('#site_logo_filename');
                const siteLogoPreview = $('#siteLogoPreview');
                const siteOldLogoPreview = $('#siteOldLogoPreview');

                // Add an event listener to the input element
                imageInput.on('change', function () {
                    // Check if a file is selected
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();

                        // Read the selected file as a data URL
                        reader.readAsDataURL(this.files[0]);

                        // When the file is loaded, set the div's background image
                        reader.onload = function (e) {
                            siteLogoPreview.html('');
                            siteLogoPreview.css('background-image', `url('${e.target.result}')`);
                            // siteLogoPreview.css('background-size', 'cover');
                            siteLogoPreview.css('background-repeat', 'no-repeat'); // Set no-repeat
                            siteLogoPreview.css('width', '122px'); // Set the desired width
                            siteLogoPreview.css('height', '83px'); // Set the desired height
                        };
                    } else {
                        // Clear the div if no file is selected
                        siteLogoPreview.css('background-image', '');
                        siteLogoPreview.css('width', '0');
                        siteLogoPreview.css('height', '0');
                    }
                });
            }

            siteFaviconPreview();
            function siteFaviconPreview() {
                // Get references to the input and div elements
                const imageInput = $('#site_favicon');
                const siteFaviconPreview = $('#siteFaviconPreview');
                const siteOldFaviconPreview = $('#siteOldFaviconPreview');

                // Add an event listener to the input element
                imageInput.on('change', function () {
                    // Check if a file is selected
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();

                        // Read the selected file as a data URL
                        reader.readAsDataURL(this.files[0]);

                        // When the file is loaded, set the div's background image
                        reader.onload = function (e) {
                            siteFaviconPreview.html('');
                            siteFaviconPreview.css('background-image', `url('${e.target.result}')`);
                            // siteFaviconPreview.css('background-size', 'cover');
                            siteFaviconPreview.css('background-repeat', 'no-repeat'); // Set no-repeat
                            siteFaviconPreview.css('width', '32px'); // Set the desired width
                            siteFaviconPreview.css('height', '21px'); // Set the desired height
                        };
                    } else {
                        // Clear the div if no file is selected
                        siteFaviconPreview.css('background-image', '');
                        siteFaviconPreview.css('width', '0');
                        siteFaviconPreview.css('height', '0');
                    }
                });
            }
        });        
    </script>
@endpush