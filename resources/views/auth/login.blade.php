@extends('layouts.app')

@section('content')
<!-- title-->
<h4 class="mt-0">{{ __('Login') }}</h4>
<p class="text-muted mb-4">Enter your email address and password to access account.</p>

<!-- form -->
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-3">
        <label for="emailaddress" class="form-label">Email address</label>
        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="emailaddress"  placeholder="Enter your email" autofocus value="{{ old('email') }}">
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="mb-3">
        @if (Route::has('password.request'))
            <a class="text-muted float-end" href="{{ route('password.request') }}">
                <small>Forgot your password?</small>
            </a>
        @endif
        <label for="password" class="form-label">Password</label>
        <input class="form-control @error('password') is-invalid @enderror" type="password"  id="password" name="password" placeholder="Enter your password">
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="checkbox-signin" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="checkbox-signin">Remember me</label>
        </div>
    </div>
    <div class="d-grid mb-0 text-center">
        <button class="btn btn-primary" type="submit"><i class="mdi mdi-login"></i> Log In </button>
    </div>
    
</form>
<!-- end form-->

<!-- Footer-->
@endsection
