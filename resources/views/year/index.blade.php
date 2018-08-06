<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
            {!! Form::model($year, ['route' => $section->route]) !!}
              @method($section->method)
              <div class="form-body">
                {{-- <h4 class="form-section"><i class="fa fa-eye"></i> {{ __('About Member') }}</h4> --}}

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('year', 'What year is the next academic excellence award in?') !!}
                      {!! Form::text('year', null, ['class' => 'form-control border-primary', 'placeholder' => 'Year']) !!}
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
