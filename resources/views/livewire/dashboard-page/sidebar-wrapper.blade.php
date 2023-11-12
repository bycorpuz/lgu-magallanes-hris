<div>
    <!--sidebar wrapper -->
    <div class="sidebar-wrapper" data-simplebar="true">
        <livewire:dashboard-page.sidebar-header>

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

            @if(
                // for developer and administrator
                Gate::check('rbac-model-has-permissions') ||
                Gate::check('rbac-model-has-roles') ||
                // for developer
                Gate::check('rbac-permissions') ||
                Gate::check('rbac-roles') ||
                Gate::check('rbac-role-has-permissions') ||
                Gate::check('view-user-logs')
            )

                <li class="menu-label">User Management</li>
                
                @can('view-user-logs')
                    <li class="{{ Route::is('user-logs') ? 'mm-active' : '' }}">
                        <a href="{{ route('user-logs') }}">
                            <div class="parent-icon"><i class="bx bx-history"></i>
                            </div>
                            <div class="menu-title">User Logs</div>
                        </a>
                    </li>
                @endcan

                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-cog'></i>
                        </div>
                        <div class="menu-title">Role-Based Access Control</div>
                    </a>
                    <ul>
                        @can('rbac-roles')
                            <li class="{{ Route::is('rbac-roles') ? 'mm-active' : '' }}">
                                <a href="{{ route('rbac-roles') }}">
                                    <i class='bx bx-radio-circle'></i>Roles
                                </a>
                            </li>
                        @endcan
                        @can('rbac-permissions')
                            <li class="{{ Route::is('rbac-permissions') ? 'mm-active' : '' }}">
                                <a href="{{ route('rbac-permissions') }}">
                                    <i class='bx bx-radio-circle'></i>Permissions
                                </a>
                            </li>
                        @endcan
                        @can('rbac-role-has-permissions')
                            <li class="{{ Route::is('rbac-role-has-permissions') ? 'mm-active' : '' }}">
                                <a href="{{ route('rbac-role-has-permissions') }}">
                                    <i class='bx bx-radio-circle'></i>Role Has Permissions
                                </a>
                            </li>
                        @endcan
                        @can('rbac-model-has-permissions')
                            <li class="{{ Route::is('rbac-model-has-permissions') ? 'mm-active' : '' }}">
                                <a href="{{ route('rbac-model-has-permissions') }}">
                                    <i class='bx bx-radio-circle'></i>Model Has Permissions
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

        </ul>
        <!--end navigation-->
    </div>
    <!--end sidebar wrapper -->
</div>
