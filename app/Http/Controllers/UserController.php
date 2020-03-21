<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\AddRequest;
use App\Http\Requests\User\EditRequest;
use Illuminate\Http\Request;
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
      $this->authorizePermissions('add_users');
      return view('admin.users.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddRequest $request)
    {
      $this->authorizePermissions('add_users');

      $data = $request->all();
      $data['password'] = Hash::make($data['password']);

      if ( User::create($data) ) {
        return redirect('user')->with('user_alert', [
          'type' => 'success',
          'message' => 'User has successfully added.'
        ]);
      }

      return redirect('user')->with('user_alert', [
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
      $this->authorizePermissions('edit_users');
      
      $user = User::find($id);
      return view('admin.users.edit', compact('user'));
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
      $this->authorizePermissions('edit_users');

      if ( User::where('id', $id)->update($request->except(['_method', '_token'])) ) {
        return redirect('user')->with('user_alert', [
          'type' => 'success',
          'message' => 'User data has successfully updated.'
        ]);
      }

      return redirect('user')->with('user_alert', [
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
      $this->authorizePermissions('delete_users');

      if ( User::where('id', $id)->delete() ) {
        return redirect('user')->with('user_alert', [
          'type' => 'success',
          'message' => 'User has successfully deleted.'
        ]);
      }

      return redirect('user')->with('user_alert', [
        'type' => 'danger',
        'message' => 'Failed to delete user, something went wrong.'
      ]);
    }
}
