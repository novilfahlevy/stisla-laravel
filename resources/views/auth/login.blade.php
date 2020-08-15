@extends('layouts.auth.app')

@section('content')
<section class="section">
  <div class="container mt-5">
    <div class="row">
      <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="login-brand">
          <img src="{{ asset('img/stisla-fill.svg') }}" alt="logo" width="100" class="shadow-light rounded-circle">
        </div>

        <div class="card card-primary">
          <div class="card-header"><h4>Login</h4></div>

          <div class="card-body">
            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
              @csrf
              <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>

              <div class="form-group">
                <div class="d-block">
                  <label for="password" class="control-label">Password</label>
                </div>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>

              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                  <label class="custom-control-label" for="remember">Ingat saya</label>
                </div>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                  Login
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