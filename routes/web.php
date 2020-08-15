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

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Redirect to dashboard if user in '/' route
Route::get('/', function() {
  return redirect('dashboard');
});

// Auth
Route::middleware(['auth'])->group(function() {
  // Dashboard
  Route::get('dashboard', 'Admin\DashboardController@index')->name('dashboard');

  Route::resource('user', 'Admin\UserController'); // User
  Route::resource('role', 'Admin\RoleController'); // Role
  Route::put('role/{id}/deleteable', 'Admin\RoleController@toggleDeleteable');
  
  // Permission
  Route::get('permissions', 'Admin\PermissionController@index')->name('permissions');

  // Profile
  Route::get('profile', 'Admin\UserController@profile')->name('profile');
  Route::post('profile', 'Admin\UserController@changeProfile')->name('changeProfile');
  Route::post('profile/image', 'Admin\UserController@changeProfileImage')->name('changeProfileImage');
  Route::put('profile/password', 'Admin\UserController@changePassword')->name('changePassword');
});