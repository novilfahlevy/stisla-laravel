<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Permission;
use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $this->authorizePermissions('Melihat daftar role');
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
    $permissions = Permission::all();
    return view('admin.roles.create', compact('permissions'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->authorizePermissions('Menambah role');
    
    if ( $role = Role::create(['name' => strtolower($request->name), 'is_deleteable' => !$request->isDeleteable]) ) {
      if ( $role->syncPermissions(json_decode($request->permissions)) ) {
        return redirect('role')->with('alert', [
          'type' => 'success',
          'message' => 'Role berhasil ditambah.'
        ]);
      }
    }

    return redirect('role')->with('alert', [
      'type' => 'danger',
      'message' => 'Gagal menambah role.'
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
    
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $this->authorizePermissions('Mengubah data role');

    $role = Role::find($id)->only(['id', 'name', 'is_deleteable']);
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

    return view('admin.roles.edit', compact('role', 'permissions', 'currentPermissions'));
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
    $this->authorizePermissions('Mengubah data role');

    if ( 
      Role::where('id', $id)->update(['name' => strtolower($request->name), 'is_deleteable' => !$request->isDeleteable]) 
      &&
      Role::find($id)->syncPermissions(json_decode($request->permissions))
    ) {
      return redirect('role')->with('alert', [
        'type' => 'success',
        'message' => 'Role berhasil diubah.'
      ]);
    }


    return redirect('role')->with('alert', [
      'type' => 'danger',
      'message' => 'Gagal mengubah data role.'
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $this->authorizePermissions('Menghapus role');

    if ( Role::where('id', $id)->delete() ) {
      return redirect('role')->with('alert', [
        'type' => 'success',
        'message' => 'Berhasil menghapus role.'
      ]);
    }

    return redirect('role')->with('alert', [
      'type' => 'danger',
      'message' => 'Gagal menghapus role.'
    ]);
  }

  public function toggleDeleteable($id)
  {
    $role = Role::where('id', $id);
    if ( $role->count() ) {
      $role->update(['is_deleteable' => !$role->first()->is_deleteable]);
      return redirect('role')->with('alert', [
        'type' => 'success',
        'message' => 'Berhasil mengubah data role.'
      ]);
    }
    return redirect('role')->with('alert', [
      'type' => 'danger',
      'message' => 'Gagal mengubah data role.'
    ]);
  }
}
