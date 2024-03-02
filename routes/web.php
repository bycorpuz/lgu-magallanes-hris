<?php

use App\Livewire\AuthenticationPage\Login;
use App\Livewire\AuthenticationPage\Register;
use App\Livewire\DashboardPage\Dashboard;
use App\Livewire\DatabaseLibraries\Designations;
use App\Livewire\DatabaseLibraries\LeaveTypes;
use App\Livewire\DatabaseLibraries\Positions;
use App\Livewire\DatabaseLibraries\Salaries;
use App\Livewire\LandingPage\Welcome;
use App\Livewire\Leave\Dashboard as LeaveDashboard;
use App\Livewire\Leave\LeaveEarnings;
use App\Livewire\Leave\Leaves;
use App\Livewire\My\Leave;
use App\Livewire\My\Profile;
use App\Livewire\My\ProfilePicture;
use App\Livewire\Plantilla\Plantillas;
use App\Livewire\RoleBasedAccessControl\ModelHasPermissions;
use App\Livewire\RoleBasedAccessControl\ModelHasRoles;
use App\Livewire\RoleBasedAccessControl\Permissions;
use App\Livewire\RoleBasedAccessControl\RoleHasPermissions;
use App\Livewire\RoleBasedAccessControl\Roles;
use App\Livewire\Settings\Site;
use App\Livewire\User\Logs;
use App\Livewire\User\Users;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', Welcome::class)->name('landing-page');

Route::group(['middleware' => ['guest','preventBackHistory']], function(){
    // Route::get('/register', Register::class)->name('register');

    Route::get('/login', Login::class)->name('login');
    Route::post('/login-handler',[Login::class,'loginHandler'])->name('login-handler');
});

Route::group(['middleware' => ['auth', 'preventBackHistory']], function(){
    // Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/my-profile', Profile::class)->name('my-profile');
    Route::post('/my-profile-change-profile-picture', [ProfilePicture::class, 'changeProfilePicture'])->name('my-profile-change-profile-picture');

    Route::get('/my-leave', Leave::class)->name('my-leave');
    Route::get('/my-leave-print/{id}', [Leave::class, 'printleave']);
    Route::get('/my-leave-card-print/{user_id}', [Leave::class, 'printleavecard']);

    Route::get('/users', Users::class)->middleware('permission:crud-users')->name('users');

    Route::get('/rbac-roles', Roles::class)->middleware('permission:rbac-roles')->name('rbac-roles');
    Route::get('/rbac-permissions', Permissions::class)->middleware('permission:rbac-permissions')->name('rbac-permissions');
    Route::get('/rbac-role-has-permissions', RoleHasPermissions::class)->middleware('permission:rbac-role-has-permissions')->name('rbac-role-has-permissions');
    Route::get('/rbac-model-has-permissions', ModelHasPermissions::class)->middleware('permission:rbac-model-has-permissions')->name('rbac-model-has-permissions');
    Route::get('/rbac-model-has-roles', ModelHasRoles::class)->middleware('permission:rbac-model-has-roles')->name('rbac-model-has-roles');

    Route::get('/dl-positions', Positions::class)->middleware('permission:crud-positions')->name('dl-positions');
    Route::get('/dl-salaries', Salaries::class)->middleware('permission:crud-salaries')->name('dl-salaries');
    Route::get('/dl-leave-types', LeaveTypes::class)->middleware('permission:crud-leave-types')->name('dl-leave-types');
    Route::get('/dl-designations', Designations::class)->middleware('permission:crud-designations')->name('dl-designations');

    Route::get('/leaves', Leaves::class)->middleware('permission:crud-leaves')->name('leaves');
    Route::get('/leave-earnings', LeaveEarnings::class)->middleware('permission:crud-leave-earnings')->name('leave-earnings');
    Route::get('/leave-dashboard', LeaveDashboard::class)->middleware('permission:view-leave-dashboard')->name('leave-dashboard');

    Route::get('/plantillas', Plantillas::class)->middleware('permission:crud-plantillas')->name('plantillas');

    Route::get('/site-settings', Site::class)->middleware('permission:update-site-settings')->name('site-settings');
    Route::post('/site-settings-change-logo', [Site::class, 'changeLogo'])->middleware('permission:update-site-settings')->name('site-settings-change-logo');

    Route::get('/user-logs', Logs::class)->middleware('permission:view-user-logs')->name('user-logs');
});
