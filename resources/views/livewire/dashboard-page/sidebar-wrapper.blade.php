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

            @if(Gate::check('view-user-logs'))
                <li class="menu-label">User Management</li>
            @endif
            @can('view-user-logs')
                <li class="{{ Route::is('user-logs') ? 'mm-active' : '' }}">
                    <a href="{{ route('user-logs') }}">
                        <div class="parent-icon"><i class="bx bx-history"></i>
                        </div>
                        <div class="menu-title">User Logs</div>
                    </a>
                </li>
            @endcan

            @if(
                // for developer and administrator
                Gate::check('rbac-model-has-permissions') ||
                Gate::check('rbac-model-has-roles') ||
                // for developer
                Gate::check('rbac-permissions') ||
                Gate::check('rbac-roles') ||
                Gate::check('rbac-role-has-permissions')
            )
                <li class="menu-label">Role-Based Access Control</li>
            @endif
            @can('rbac-roles')
                <li class="{{ Route::is('rbac-roles') ? 'mm-active' : '' }}">
                    <a href="{{ route('rbac-roles') }}">
                        <div class="parent-icon"><i class="bx bx-cog"></i>
                        </div>
                        <div class="menu-title">Roles</div>
                    </a>
                </li>
            @endcan

        </ul>
        <!--end navigation-->
    </div>
    <!--end sidebar wrapper -->
</div>
