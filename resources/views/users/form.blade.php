@extends('layouts.app')

@section('title')
    {{ $section->title }}
@endsection

@push('styles')
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/forms/switch.css') }}">
@endpush

@section('content')
    <div class="row">
    <div class="col-md-12">
      <div class="card">
        
        <div class="card-header">
          <h4 class="card-title">{{ $section->heading }}</h4>
        </div>

        <div class="card-content collapse show">
          <div class="card-body">
            {!! Form::model($user, ['route' => $section->route]) !!}
              @method($section->method)
              <div class="form-body">
                {{-- <h4 class="form-section"><i class="fa fa-eye"></i> {{ __('About User') }}</h4> --}}
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('name', 'Name') !!}
                      {!! Form::text('name', null, ['class' => 'form-control border-primary', 'placeholder' => 'Name']) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('email', 'Email') !!}
                      {!! Form::email('email', null, ['class' => 'form-control border-primary', 'placeholder' => 'Email']) !!}
                    </div>
                  </div>
                </div>
                @if(!$user)
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        {!! Form::label('password', 'Password') !!}
                        {!! Form::password('password', ['class' => 'form-control border-primary', 'placeholder' => 'Password']) !!}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        {!! Form::label('password_confirmation', 'Confirm Password') !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control border-primary', 'placeholder' => 'Confirm Password']) !!}
                      </div>
                    </div>
                  </div>
                @endif

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('phone', 'Phone') !!}
                      {!! Form::text('phone', null, ['class' => 'form-control border-primary', 'placeholder' => 'Phone']) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('status', 'Active') !!}
                      {!! Form::switch('status', null, null, ['data-on-label' => 'Yes', 'data-off-label' => 'No']) !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-actions right">
                {!! Form::button(' <i class="ft-x"></i></i> Cancel', ['class' => 'btn btn-warning mr-1']) !!}
                {!! Form::button('<i class="fa fa-check-square-o"></i> Save', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
              </div>
            {!! Form::close() !!}
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection
