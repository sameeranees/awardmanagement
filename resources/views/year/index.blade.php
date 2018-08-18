<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

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
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('award_ceremony', 'Date of Ceremony') !!}
                      {!! Form::text('award_ceremony', null, ['class' => 'form-control','id' => 'datepicker1']) !!}
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('application_closing', 'Application Closing') !!}
                      {!! Form::text('application_closing', null, ['class' => 'form-control','id' => 'datepicker2']) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('venue_booking', 'Venue Booking') !!}
                      {!! Form::text('venue_booking', null, ['class' => 'form-control','id' => 'datepicker3']) !!}
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('students_confirmation', 'Students Confirmation') !!}
                      {!! Form::text('students_confirmation', null, ['class' => 'form-control','id' => 'datepicker4']) !!}
                    </div>
                  </div>
                </div>

                <script type="text/javascript">
                  $(function () {
                  $( "#datepicker1" ).datepicker({
                  format: "mm/dd/yy",
                  weekStart: 0,
                  calendarWeeks: true,
                  autoclose: true,
                  todayHighlight: true,
                  rtl: true,
                  orientation: "auto"
                  });
                  $( "#datepicker2" ).datepicker({
                  format: "mm/dd/yy",
                  weekStart: 0,
                  calendarWeeks: true,
                  autoclose: true,
                  todayHighlight: true,
                  rtl: true,
                  orientation: "auto"
                  });
                  $( "#datepicker3" ).datepicker({
                  format: "mm/dd/yy",
                  weekStart: 0,
                  calendarWeeks: true,
                  autoclose: true,
                  todayHighlight: true,
                  rtl: true,
                  orientation: "auto"
                  });
                  $( "#datepicker4" ).datepicker({
                  format: "mm/dd/yy",
                  weekStart: 0,
                  calendarWeeks: true,
                  autoclose: true,
                  todayHighlight: true,
                  rtl: true,
                  orientation: "auto"
                  });
                      });
                </script>
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
