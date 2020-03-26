<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\AddRequest;
use App\Http\Requests\User\EditRequest;
use App\Http\Requests\User\ChangeProfileRequest;
use App\Role;
use Illuminate\Http\Request as BaseRequest;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorizePermissions('see_users');

      $users = User::all();
      return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorizePermissions('add_user');
      $roles = Role::all()->pluck('name');
      return view('admin.users.create', compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddRequest $request)
    {
      $this->authorizePermissions('add_user');

      $data = $request->all();
      $data['password'] = Hash::make($data['password']);

      if ( $user = User::create($data) ) {
        $user->assignRole($request->role);
        
        return redirect('user')->with('alert', [
          'type' => 'success',
          'message' => 'User has successfully added.'
        ]);
      }

      return redirect('user')->with('alert', [
        'type' => 'danger',
        'message' => 'Failed to delete user, something went wrong.'
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
      $this->authorizePermissions('see_user');

      $user = User::find($id);
      return view('admin.users.show', compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $this->authorizePermissions('edit_user');
      
      $user = User::find($id);
      $roles = Role::all()->pluck('name');
      return view('admin.users.edit', compact('user', 'roles'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditRequest $request, $id)
    {
      $this->authorizePermissions('edit_user');

      if ( User::where('id', $id)->update($request->except(['_method', '_token', 'role'])) ) {
        User::find($id)->syncRoles($request->role);
        return redirect('user')->with('alert', [
          'type' => 'success',
          'message' => 'User data has successfully updated.'
        ]);
      }

      return redirect('user')->with('alert', [
        'type' => 'danger',
        'message' => 'Failed to edit user, something went wrong.'
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
      $this->authorizePermissions('delete_user');

      if ( User::where('id', $id)->delete() ) {
        return redirect('user')->with('alert', [
          'type' => 'success',
          'message' => 'User has successfully deleted.'
        ]);
      }

      return redirect('user')->with('alert', [
        'type' => 'danger',
        'message' => 'Failed to delete user, something went wrong.'
      ]);
    }

    public function profile() {
      $user = auth()->user();
      return view('admin.users.profile', compact('user'));
    }

    public function changeProfile(ChangeProfileRequest $request) {
      $id = auth()->user()->id;

      if ( User::where('id', $id)->update($request->only('name', 'email')) ) {
        return redirect('profile')->with('alert', [
          'type' => 'success',
          'message' => 'Profile successfully updated.'
        ]);
      } 

      return redirect('profile')->with('alert', [
        'type' => 'danger',
        'message' => 'Failed to update profile, something went wrong.'
      ]);
    }

    public function changeProfileImage(BaseRequest $request) {
      dd($request->file('image'));
    }
}
