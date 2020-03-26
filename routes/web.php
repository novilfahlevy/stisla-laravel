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
  Route::get('dashboard', 'DashboardController@index')->name('dashboard');

  Route::resource('user', 'UserController');
  Route::resource('role', 'RoleController');
  
  Route::get('permissions', 'PermissionController@index')->name('permissions');
  Route::put('role/permissions/{id}', 'RoleController@setPermissions')->name('setRolePermissions');
});

// All Roles
Route::middleware(['auth'])->group(function() {
  Route::get('profile', 'UserController@profile')->name('profile');
  Route::post('profile', 'UserController@changeProfile')->name('changeProfile');
  Route::post('profile/image', 'UserController@changeProfileImage')->name('changeProfileImage');
});