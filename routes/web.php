<?php

use App\Livewire\AuthenticationPage\Login;
use App\Livewire\AuthenticationPage\Register;
use App\Livewire\DashboardPage\Dashboard;
use App\Livewire\LandingPage\Welcome;
use App\Livewire\RoleBasedAccessControl\ModelHasPermissions;
use App\Livewire\RoleBasedAccessControl\ModelHasRoles;
use App\Livewire\RoleBasedAccessControl\Permissions;
use App\Livewire\RoleBasedAccessControl\RoleHasPermissions;
use App\Livewire\RoleBasedAccessControl\Roles;
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
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/users', Users::class)->middleware('permission:crud-users')->name('users');

    Route::get('/rbac-roles', Roles::class)->middleware('permission:rbac-roles')->name('rbac-roles');
    Route::get('/rbac-permissions', Permissions::class)->middleware('permission:rbac-permissions')->name('rbac-permissions');
    Route::get('/rbac-role-has-permissions', RoleHasPermissions::class)->middleware('permission:rbac-role-has-permissions')->name('rbac-role-has-permissions');
    Route::get('/rbac-model-has-permissions', ModelHasPermissions::class)->middleware('permission:rbac-model-has-permissions')->name('rbac-model-has-permissions');
    Route::get('/rbac-model-has-roles', ModelHasRoles::class)->middleware('permission:rbac-model-has-roles')->name('rbac-model-has-roles');

    Route::get('/user-logs', Logs::class)->middleware('permission:view-user-logs')->name('user-logs');
});