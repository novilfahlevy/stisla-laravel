@extends('layouts.admin.app', ['title' => 'Edit Pengguna'])

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Form Pengguna</h4>
          <div class="card-header-form">
            <a href="{{ route('user.index') }}" class="btn btn-primary">
              <i class="fas fa-angle-left mr-1"></i>
              Kembali
            </a>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('user.update', $user->id) }}" method="POST">
            @method('put')
            @csrf
            <div class="form-group">
              <label for="name">Nama</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $user->name }}">
              @error('name')
              <p class="invalid-feedback d-block">{{ $message }}</p>
              @enderror
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ $user->email }}">
              @error('email')
              <p class="invalid-feedback d-block">{{ $message }}</p>
              @enderror
            </div>
            <div class="form-group">
              <label for="role">Role</label>
              <select class="form-control" name="role" id="role">
                @foreach ($roles as $role)
                <option value="{{ $role }}" {{ $user->roles->pluck('name')->first() === $role ? 'selected' : '' }}>{{ $role }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection