@extends('layouts.auth')

@section('title')
    {{ __('Login') }}
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/menu/menu-types/vertical-menu-modern.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/login-register.css') }}">
@endpush

@section('content')

    @component('components.auth_header')
        {{ __('Login') }}
    @endcomponent

    <div class="card-content">
      <div class="card-body">
        <form method="POST" class="form-horizontal form-simple"  action="{{ route('login') }}" novalidate>
            @csrf
          <fieldset class="form-group position-relative has-icon-left mb-0">
            <input id="email" type="email" class="form-control form-control-lg{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('Email Address') }}"
            required>
            <div class="form-control-position">
              <i class="ft-user"></i>
            </div>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif

          </fieldset>
          <fieldset class="form-group position-relative has-icon-left">
            <input id="password" type="password" class="form-control  form-control-lg{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" type="password" placeholder="{{ __('Password') }}" required>
            <div class="form-control-position">
              <i class="fa fa-key"></i>
            </div>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </fieldset>
          <div class="form-group row">
            <div class="col-md-6 col-12 text-center text-md-left">
              <fieldset>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember"> {{ __('Remember Me') }}</label>
              </fieldset>
            </div>
            <div class="col-md-6 col-12 text-center text-md-right"><a href="{{ route('password.request') }}" class="card-link">{{ __('Forgot Password?') }}</a></div>
          </div>
          <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="ft-unlock"></i> {{ __('Login') }}</button>
        </form>
        <a href="http://local.dysfawards.com/register" >Can't login? Register Now!</a> 
      </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/scripts/forms/form-login-register.js') }}" type="text/javascript"></script>
@endpush
