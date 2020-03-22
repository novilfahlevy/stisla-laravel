<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
  public function __construct()
  {
    $this->middleware(function($request, $next) {
      $this->authorizePermissions('manage_role');
      return $next($request);
    });
  }
  
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $roles = Role::all();
    return view('admin.roles.index', compact('roles'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if ( SpatieRole::create(['name' => strtolower($request->name)]) ) {
      return redirect('role')->with('alert', [
        'type' => 'success',
        'message' => 'Role has successfully added.'
      ]);
    }
    return redirect('role')->with('alert', [
      'type' => 'danger',
      'message' => 'Failed to add role, something went wrong.'
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $role = Role::find($id)->only(['id', 'name']);
    $permissions = DB::table('role_has_permissions')
      ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
      ->where('role_id', $id)
      ->get();
    return view('admin.roles.permission', compact('role', 'permissions'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $role = Role::find($id)->only(['id', 'name']);

    $permissions = Permission::select([
      '*',
      'isCurrentPermission' => DB::table('role_has_permissions')
        ->select('id')
        ->where('role_id', $id)
        ->whereColumn('permission_id', 'permissions.id')
    ])
    ->orderBy(DB::raw('CASE WHEN isCurrentPermission > 0 THEN 1 ELSE 0 END'), 'desc')
    ->get();

    $currentPermissions = $permissions->filter(function($permission) {
      return $permission->isCurrentPermission;
    })->pluck('name');

    return view('admin.roles.edit_permissions', compact('role', 'permissions', 'currentPermissions'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    if ( Role::where('id', $id)->delete() ) {
      return redirect('role')->with('alert', [
        'type' => 'success',
        'message' => 'Role has successfully deleted.'
      ]);
    }

    return redirect('role')->with('alert', [
      'type' => 'danger',
      'message' => 'Failed to delete role, something went wrong.'
    ]);
  }

  public function setPermissions(Request $request) {
    $this->authorizePermissions('manage_role_permissions');
    SpatieRole::find($request->role)->syncPermissions(json_decode($request->permissions));
    return redirect(route('role.show', $request->role))->with('alert', [
      'type' => 'success',
      'message' => 'Role permissions have successfully managed.'
    ]);
  }
}
