@extends('layouts.admin.app', ['title' => 'Detail User'])

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Data User</h4>
          <div class="card-header-form">
            <a href="{{ route('user.index') }}" class="btn btn-primary">
              <i class="fas fa-angle-left mr-1"></i>
              Kembali
            </a>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-4 d-flex justify-content-center align-items-center">
              <img alt="image" src="{{ asset('storage/img/profile/' . $user->image) }}" class="rounded-circle ml-0 shadow mb-4 mb-md-0" style="width: 200px; height: 200px; background-size: cover">
            </div>
            <div class="col">
              <ul class="list-group">
                <li class="list-group-item">
                  <h6 class="mb-0 mt-1">Name</h6>
                  <p class="mb-0">{{ $user->name }}</p>
                </li>
                <li class="list-group-item">
                  <h6 class="mb-0 mt-1">Email</h6>
                  <p class="mb-0">{{ $user->email }}</p>
                </li>
                <li class="list-group-item">
                  <h6 class="mb-0 mt-1">Role</h6>
                  <p class="mb-0">{{ $user->roles->pluck('name')->first() }}</p>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection