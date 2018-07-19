@extends('layouts.auth')

@section('title')
    {{ __('Recover Password') }}
@endsection

@section('content')

    @component('components.auth_header')
        {{ __('Recover Password') }}
    @endcomponent

    <div class="card-content">
      <div class="card-body">
        
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form class="form-horizontal" method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}" novalidate>
            @csrf
          <fieldset class="form-group position-relative has-icon-left">
            <input id="email" type="email" class="form-control form-control-lg{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('Email Address') }}" required>
            <div class="form-control-position">
              <i class="ft-mail"></i>
            </div>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
          
          </fieldset>
          <button type="submit" class="btn btn-outline-primary btn-lg btn-block"><i class="ft-unlock"></i> {{ __('Send Password Reset Link') }}</button>
        </form>
      </div>
    </div>
    <div class="card-footer">
      <div class="">
        <p class="float-sm-right text-center m-0">{{ __('Back to') }} <a href="{{ route('login') }}" class="card-link">{{ __('Login') }}</a></p>
      </div>
    </div>
@endsection