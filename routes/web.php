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

Route::middleware(['auth', 'role:admin'])->group(function() {
  Route::get('dashboard', 'DashboardController@index')->name('dashboard');

  Route::resource('user', 'UserController');
  Route::resource('role', 'RoleController');
  Route::post('role/permissions', 'RoleController@setPermissions')->name('setRolePermissions');
  Route::get('permissions', 'PermissionController@index')->name('permissions');
});