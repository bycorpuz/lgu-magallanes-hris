<div>
    <!--sidebar wrapper -->
    <div class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div>
                <img src="{{ asset('/images/site/'. getSettings()->site_logo) }}" >
            </div>
            <div>
                <h1 class="logo-text" style="font-size: 9pt;">{{ getSettings()->site_name }}</h1>
            </div>
            <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
            </div>
        </div>
        <!--navigation-->
        <ul class="metismenu" id="menu">

            <li class="menu-label" style="margin-top: -20px;">Home</li>
            <li class="{{ Route::is('dashboard') ? 'mm-active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <div class="parent-icon"><i class="bx bx-home-alt"></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            <li class="menu-label">User Management</li>
            <li class="{{ Route::is('user-logs') ? 'mm-active' : '' }}">
                <a href="{{ route('user-logs') }}">
                    <div class="parent-icon"><i class="bx bx-history"></i>
                    </div>
                    <div class="menu-title">User Logs</div>
                </a>
            </li>

        </ul>
        <!--end navigation-->
    </div>
    <!--end sidebar wrapper -->
</div>
