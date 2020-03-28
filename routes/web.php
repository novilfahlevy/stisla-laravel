<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function() {
  return redirect('dashboard');
});

// Admin
Route::middleware(['auth', 'role:admin'])->group(function() {
  Route::get('dashboard', 'Admin\DashboardController@index')->name('dashboard');

  Route::resource('user', 'Admin\UserController');
  Route::resource('role', 'Admin\RoleController');
  
  Route::get('permissions', 'Admin\PermissionController@index')->name('permissions');
  Route::put('role/permissions/{id}', 'Admin\RoleController@setPermissions')->name('setRolePermissions');
});

// All Roles
Route::middleware(['auth'])->group(function() {
  Route::get('profile', 'Admin\UserController@profile')->name('profile');
  Route::post('profile', 'Admin\UserController@changeProfile')->name('changeProfile');
  Route::post('profile/image', 'Admin\UserController@changeProfileImage')->name('changeProfileImage');
  Route::put('profile/password', 'Admin\UserController@changePassword')->name('changePassword');
});