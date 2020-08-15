<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AddRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\EditRequest;
use App\Http\Requests\User\ChangeProfileRequest;
use App\Role;
use Illuminate\Http\Request as BaseRequest;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $this->authorizePermissions('Melihat daftar pengguna');

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
    $this->authorizePermissions('Menambah pengguna');
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
    $this->authorizePermissions('Menambah pengguna');

    $data = $request->all();
    $data['password'] = Hash::make($data['password']);

    if ( $user = User::create($data) ) {
      $user->assignRole($request->role);
      
      return redirect('user')->with('alert', [
        'type' => 'success',
        'message' => 'Berhasil menambah pengguna.'
      ]);
    }

    return redirect('user')->with('alert', [
      'type' => 'danger',
      'message' => 'Gagal menambah pengguna.'
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
    $this->authorizePermissions('Melihat detail pengguna');

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
    $this->authorizePermissions('Mengubah data pengguna');
    
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
    $this->authorizePermissions('Mengubah data pengguna');

    if ( User::where('id', $id)->update($request->except(['_method', '_token', 'role'])) ) {
      User::find($id)->syncRoles($request->role);
      return redirect('user')->with('alert', [
        'type' => 'success',
        'message' => 'Berhasil mengubah data pengguna.'
      ]);
    }

    return redirect('user')->with('alert', [
      'type' => 'danger',
      'message' => 'Gagal mengubah data pengguna.'
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
    $this->authorizePermissions('Menghapus pengguna');

    if ( User::where('id', $id)->delete() ) {
      return redirect('user')->with('alert', [
        'type' => 'success',
        'message' => 'Berhasil menghapus pengguna.'
      ]);
    }

    return redirect('user')->with('alert', [
      'type' => 'danger',
      'message' => 'Gagal menghapus pengguna.'
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
        'message' => 'Berhasil mengubah data profil.'
      ]);
    } 

    return redirect('profile')->with('alert', [
      'type' => 'danger',
      'message' => 'Gagal mengubah data profil.'
    ]);
  }

  public function changeProfileImage(BaseRequest $request) {
    $image = $request->file('image');
    
    if ( $image ) {
      $user = User::find(auth()->user()->id);
      $imageTypes = ['jpg', 'png', 'jpeg'];
      $extension = $image->extension();

      if ( !in_array($extension, $imageTypes) ) {
        return redirect()->route('profile')->with('alert', [
          'type' => 'danger',
          'message' => 'Yang anda unggah bukan gambar.'
        ]);
      }

      if ( $user->image != 'default.png' ) {
        Storage::disk('public')->delete('img/profile/' . $user->image);
      }

      $imageName = Str::random(32) . '.' . $extension;
      $invertentionImage = Image::make($image->getRealPath());
      
      if ( $invertentionImage->width() > 500 ) {
        $invertentionImage->resize(500, null);
      }

      if ( $invertentionImage->height() > 500 ) {
        $invertentionImage->resize(null, 500);
      }

      $result = $invertentionImage->save(storage_path('app/public/img/profile/' . $imageName));

      if ( $result && User::where('id', auth()->user()->id)->update(['image' => $imageName]) ) {
        return redirect()->route('profile')->with('alert', [
          'type' => 'success',
          'message' => 'Berhasil mengubah gambar profil.'
        ]);
      }
    }

    return redirect()->route('profile')->with('alert', [
      'type' => 'danger',
      'message' => 'Gagal mengubah gambar profil.'
    ]);
  }

  public function changePassword(ChangePasswordRequest $request) {
    $id = auth()->user()->id;
    $user = User::find($id);
    
    if ( Hash::check($request->oldPassword, $user->password) ) {
      if ( User::where('id', $id)->update(['password' => Hash::make($request->password)]) ) {
        return redirect()->route('profile')->with('alert', [
          'type' => 'success',
          'message' => 'Berhasil mengganti password.'
        ]);
      }
      return redirect()->route('profile')->with('alert', [
        'type' => 'danger',
        'message' => 'Gagal mengganti password.'
      ]);
    }

    return redirect()->route('profile')->with('error', 'Password lama anda salah.');
  }
}
