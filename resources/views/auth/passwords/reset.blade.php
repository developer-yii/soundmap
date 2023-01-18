@extends('layouts.app')

@section('content')
<!-- title-->
<h4 class="mt-0">Reset Password</h4>
<!-- form -->

@if(session()->get('errors'))
<p class="alert alert-danger">{{ session()->get('errors')->first() }}</p>
@endif

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="mb-3">
        <label for="emailaddress" class="form-label">Email address</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">{{ __('Password') }}</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">{{ __('Confirm Password') }}</label>
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="mb-0 text-center d-grid">
        <button class="btn btn-primary" type="submit"><i class="mdi mdi-lock-reset"></i> {{ __('Reset Password') }} </button>
    </div>
</form>
<!-- end form-->

<!-- Footer-->
<footer class="footer footer-alt">
    <p class="text-muted">Back to <a href="{{route('login')}}" class="text-muted ms-1"><b>Log In</b></a></p>
</footer>
@endsection
