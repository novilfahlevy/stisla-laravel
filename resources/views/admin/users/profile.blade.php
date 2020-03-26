@extends('layouts.admin.app', ['title' => 'Profile'])

@section('content')
<div class="row">
  <div class="col-12">
    <div class="row mt-sm-4">
      <div class="col-12 col-md-12 col-lg-5">
        <div class="card profile-widget">
          <div class="profile-widget-header d-flex justify-content-center">
            <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle profile-widget-picture ml-0 mb-5 mb-lg-3 shadow">
          </div>
          <div class="profile-widget-description p-0">
            <form action="{{ route('changeProfileImage') }}" method="POST" class="dropzone" id="imageProfile" enctype="multipart/form-data">
              @csrf @method('put')
              <div class="dz-message mx-0">
                <h5>Select profile image</h5>
                <p class="mb-0 small">500 &times; 500</p>
              </div>
            </form>
          </div>
          <div class="card-footer text-center">
            <button type="button" class="btn btn-primary" onclick="document.getElementById('imageProfile').submit();">Save Change</button>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-12 col-lg-7">
        <div class="card">
          <form action="{{ route('changeProfile') }}" method="post">
            @csrf
            <div class="card-header">
              <h4>Edit Profile</h4>
            </div>
            <div class="card-body">
              @include('partials.alert')
              <div class="row">
                <div class="form-group col-12">
                  <label for="name">Name</label>
                  <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}">
                  @error('name')
                  <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group mb-0 col-12">
                  <label for="email">Email</label>
                  <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}">
                  @error('email')
                  <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
            </div>
            <div class="card-footer text-right">
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
@include('admin.users.js.profile', ['url' => route('changeProfileImage')])
@endpush