@extends('layouts.admin.app', ['title' => 'Profile'])

@section('content')
<div class="row">
  <div class="col-12">
    @include('partials.alert')
    <div class="row mt-sm-4">
      <div class="col-12 col-md-12 col-lg-7">
        <div class="card">
          <form action="{{ route('changeProfile') }}" method="post">
            @csrf
            <div class="card-header">
              <h4>Edit Profile Info</h4>
            </div>
            <div class="card-body">
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
      <div class="col-12 col-md-12 col-lg-5">
        <div class="card profile-widget mt-0">
          <div class="card-header">
            <h4>Edit Profile Image</h4>
          </div>
          <form action="{{ route('changeProfileImage') }}" method="POST" enctype="multipart/form-data" id="changeProfileImageForm">
            <div class="card-body d-flex justify-content-center">
              <div class="row">
                <div class="col-12 d-flex justify-content-center">
                  <img alt="image" src="{{ asset('storage/img/profile/' . $user->image) }}" class="rounded-circle ml-0 shadow" style="width: 150px; height: 150px; background-size: cover">
                </div>
                <div class="col-12 py-0">
                  <hr class="my-4">
                </div>
                <div class="col-12 d-flex justify-content-center">
                  <div class="rounded-circle d-flex justify-content-center align-items-center" style="width: 200px; height: 200px; border: 2px dashed #6777ef">
                    @csrf
                    <div id="profileImage">
                      <label class="m-0 pt-3 text-break" for="image">
                        <h6 class="mb-0">Select your profile image</h6>
                        <p class="mb-0 text-center">500 &times; 500</p>
                      </label>
                    </div>
                    <input type="file" name="image" class="d-none" id="image">
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer text-center">
              <button type="submit" class="btn btn-primary">Save Change</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
@include('admin.users.js.profile')
@endpush