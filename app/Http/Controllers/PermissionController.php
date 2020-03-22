<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
  public function index() {
    $permissions = Permission::all();
    return view('admin.permissions.index', compact('permissions'));
  }
}
