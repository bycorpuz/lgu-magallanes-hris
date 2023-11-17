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

            <li class="menu-label" >Main Navigation</li>
            <li class="{{ Route::is('dashboard') ? 'mm-active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <div class="parent-icon"><i class="bx bx-user-circle"></i>
                    </div>
                    <div class="menu-title">My Profile</div>
                </a>
            </li>
            <li class="{{ Route::is('dashboard') ? 'mm-active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <div class="parent-icon"><i class="bx bx-paper-plane"></i>
                    </div>
                    <div class="menu-title">My Leave</div>
                </a>
            </li>

            @if(
                // for developer and administrator
                Gate::check('crud-users') ||
                Gate::check('crud-positions') ||
                Gate::check('crud-salaries') ||
                Gate::check('crud-plantillas') ||
                Gate::check('crud-leave-types') ||
                Gate::check('rbac-model-has-permissions') ||
                Gate::check('rbac-model-has-roles') ||
                // for developer
                Gate::check('rbac-permissions') ||
                Gate::check('rbac-roles') ||
                Gate::check('rbac-role-has-permissions') ||
                Gate::check('view-user-logs')
            )

                <li class="menu-label">Human Resource Management</li>
                
                @can('crud-users')
                    <li class="{{ Route::is('users') ? 'mm-active' : '' }}">
                        <a href="{{ route('users') }}">
                            <div class="parent-icon"><i class="bx bx-group"></i>
                            </div>
                            <div class="menu-title">Users</div>
                        </a>
                    </li>
                @endcan

                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-cog'></i>
                        </div>
                        <div class="menu-title">Role-Based Access Control (RBAC)</div>
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
                        @can('rbac-model-has-roles')
                            <li class="{{ Route::is('rbac-model-has-roles') ? 'mm-active' : '' }}">
                                <a href="{{ route('rbac-model-has-roles') }}">
                                    <i class='bx bx-radio-circle'></i>Model Has Roles
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-data'></i>
                        </div>
                        <div class="menu-title">Database Libraries</div>
                    </a>
                    <ul>
                        @can('crud-positions')
                            <li class="{{ Route::is('dl-positions') ? 'mm-active' : '' }}">
                                <a href="{{ route('dl-positions') }}">
                                    <i class='bx bx-radio-circle'></i>Positions
                                </a>
                            </li>
                        @endcan
                        @can('crud-salaries')
                            <li class="{{ Route::is('dl-salaries') ? 'mm-active' : '' }}">
                                <a href="{{ route('dl-salaries') }}">
                                    <i class='bx bx-radio-circle'></i>Salaries
                                </a>
                            </li>
                        @endcan
                        @can('crud-leave-types')
                            <li class="{{ Route::is('dl-leave-types') ? 'mm-active' : '' }}">
                                <a href="{{ route('dl-leave-types') }}">
                                    <i class='bx bx-radio-circle'></i>Leave Types
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                
                @can('view-user-logs')
                    <li class="{{ Route::is('user-logs') ? 'mm-active' : '' }}">
                        <a href="{{ route('user-logs') }}">
                            <div class="parent-icon"><i class="bx bx-history"></i>
                            </div>
                            <div class="menu-title">User Logs</div>
                        </a>
                    </li>
                @endcan
            @endif

        </ul>
        <!--end navigation-->
    </div>
    <!--end sidebar wrapper -->
</div>
