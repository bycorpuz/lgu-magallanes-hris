<div>
    <!--start switcher-->
        <div class="switcher-wrapper">
            <div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
            </div>
            <div class="switcher-body">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 text-uppercase">Theme Customizer</h5>
                    <button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
                </div>
                <hr/>
                <h6 class="mb-0">Theme Styles</h6>
                <hr/>

                @php
                    $themeStyle = getUserThemeSettings()->theme_style;

                    $lightTheme = $themeStyle === 'light-theme' ? 'checked' : '';
                    $darkTheme = $themeStyle === 'dark-theme' ? 'checked' : '';
                    $semiDark = $themeStyle === 'semi-dark' ? 'checked' : '';
                    $minimalTheme = $themeStyle === 'minimal-theme' ? 'checked' : '';
                @endphp

                <div class="d-flex align-items-center justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode" wire:click='themeStyles("light-theme")' {{ $lightTheme }}>
                        <label class="form-check-label" for="lightmode">Light</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode" wire:click='themeStyles("dark-theme")' {{ $darkTheme }}>
                        <label class="form-check-label" for="darkmode">Dark</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark" wire:click='themeStyles("semi-dark")' {{ $semiDark }}>
                        <label class="form-check-label" for="semidark">Semi Dark</label>
                    </div>
                </div>
                <hr/>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault" wire:click='themeStyles("minimal-theme")' {{ $minimalTheme }}>
                    <label class="form-check-label" for="minimaltheme">Minimal Theme</label>
                </div>
                <hr/>
                <h6 class="mb-0">Header Colors</h6>
                <hr/>
                <div class="header-colors-indigators">
                    <div class="row row-cols-auto g-3">
                        <div class="col">
                            <div class="indigator headercolor1" id="headercolor1" wire:click='headerColors("headercolor1")'></div>
                        </div>
                        <div class="col">
                            <div class="indigator headercolor2" id="headercolor2" wire:click='headerColors("headercolor2")'></div>
                        </div>
                        <div class="col">
                            <div class="indigator headercolor3" id="headercolor3" wire:click='headerColors("headercolor3")'></div>
                        </div>
                        <div class="col">
                            <div class="indigator headercolor4" id="headercolor4" wire:click='headerColors("headercolor4")'></div>
                        </div>
                        <div class="col">
                            <div class="indigator headercolor5" id="headercolor5" wire:click='headerColors("headercolor5")'></div>
                        </div>
                        <div class="col">
                            <div class="indigator headercolor6" id="headercolor6" wire:click='headerColors("headercolor6")'></div>
                        </div>
                        <div class="col">
                            <div class="indigator headercolor7" id="headercolor7" wire:click='headerColors("headercolor7")'></div>
                        </div>
                        <div class="col">
                            <div class="indigator headercolor8" id="headercolor8" wire:click='headerColors("headercolor8")'></div>
                        </div>
                    </div>
                </div>
                <hr/>
                <h6 class="mb-0">Sidebar Colors</h6>
                <hr/>
                <div class="header-colors-indigators">
                    <div class="row row-cols-auto g-3">
                        <div class="col">
                            <div class="indigator sidebarcolor1" id="sidebarcolor1" wire:click='sidebarColors("sidebarcolor1")'></div>
                        </div>
                        <div class="col">
                            <div class="indigator sidebarcolor2" id="sidebarcolor2" wire:click='sidebarColors("sidebarcolor2")'></div>
                        </div>
                        <div class="col">
                            <div class="indigator sidebarcolor3" id="sidebarcolor3" wire:click='sidebarColors("sidebarcolor3")'></div>
                        </div>
                        <div class="col">
                            <div class="indigator sidebarcolor4" id="sidebarcolor4" wire:click='sidebarColors("sidebarcolor4")'></div>
                        </div>
                        <div class="col">
                            <div class="indigator sidebarcolor5" id="sidebarcolor5" wire:click='sidebarColors("sidebarcolor5")'></div>
                        </div>
                        <div class="col">
                            <div class="indigator sidebarcolor6" id="sidebarcolor6" wire:click='sidebarColors("sidebarcolor6")'></div>
                        </div>
                        <div class="col">
                            <div class="indigator sidebarcolor7" id="sidebarcolor7" wire:click='sidebarColors("sidebarcolor7")'></div>
                        </div>
                        <div class="col">
                            <div class="indigator sidebarcolor8" id="sidebarcolor8" wire:click='sidebarColors("sidebarcolor8")'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!--end switcher-->
</div>
