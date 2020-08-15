@extends('layouts.auth.app')

@section('content')
<section class="section">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-5">
        <div class="login-brand">
          <img src="{{ asset('img/stisla-fill.svg') }}" alt="logo" width="100" class="shadow-light rounded-circle">
        </div>

        <div class="card card-primary">
          <div class="card-header"><h4>Register</h4></div>

          <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
              @csrf
              <div class="row">
                <div class="form-group col-12">
                  <label for="name">Nama</label>
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                  @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>

              <div class="row">
                <div class="form-group col-6">
                  <label for="password" class="d-block">Password</label>
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                  @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                  <div id="pwindicator" class="pwindicator">
                    <div class="bar"></div>
                    <div class="label"></div>
                  </div>
                </div>
                <div class="form-group col-6">
                  <label for="password2" class="d-block">Konfirmasi Password</label>
                  <input id="password2" type="password" class="form-control" name="password_confirmation">
                </div>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block">
                  Buat Akun
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="simple-footer">
          Copyright &copy; Stisla 2018
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

