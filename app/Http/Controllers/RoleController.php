<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
  public function __construct()
  {
    $this->middleware(function($request, $next) {
      $this->authorizePermissions('manage_role_permissions');
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $role = Role::find($id)->name;
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
        //
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
}
