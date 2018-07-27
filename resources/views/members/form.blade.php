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
            {!! Form::model($member, ['route' => $section->route]) !!}
              @method($section->method)
              <div class="form-body">
                {{-- <h4 class="form-section"><i class="fa fa-eye"></i> {{ __('About Member') }}</h4> --}}

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('first_name', 'Name') !!}
                      {!! Form::text('first_name', null, ['class' => 'form-control border-primary', 'placeholder' => 'Name']) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('surname', 'Surname') !!}
                      {!! Form::text('surname', null, ['class' => 'form-control border-primary', 'placeholder' => 'Surname']) !!}
                    </div>
                  </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        {!! Form::label('fathers_name', 'Father Name') !!}
                        {!! Form::text('fathers_name',null, ['class' => 'form-control border-primary', 'placeholder' => 'Father Name']) !!}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        {!! Form::label('email', 'Email') !!}
                        {!! Form::email('email',null, ['class' => 'form-control border-primary', 'placeholder' => 'Email']) !!}
                      </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('phone', 'Phone') !!}
                      {!! Form::text('phone', null, ['class' => 'form-control border-primary', 'placeholder' => 'Phone']) !!}
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <!--
                      {!! Form::label('status', 'Active') !!}
                      {!! Form::switch('status', null, null, ['data-on-label' => 'Yes', 'data-off-label' => 'No']) !!} 
                    -->
                      {!! Form::label('dam_no', 'Dhoraji Association Member Number') !!}
                      {!! Form::text('dam_no', null, ['class' => 'form-control border-primary', 'placeholder' => 'Dam_No']) !!}
                    </div>
                  </div>
                </div>

              <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('address', 'Address') !!}
                      {!! Form::textarea('address', null, ['class' => 'form-control border-primary','rows'=>2,'cols'=>4, 'placeholder' => 'Address']) !!}
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('gender', 'Gender') !!}
                      {!! Form::select('gender',array('Male'=>'Male','Female'=>'Female'),null,['class' => 'form-control border-primary'] ) !!}
                    </div>
                  </div>
                </div>

              <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('name_of_institute', 'Name of Institute') !!}
                      {!! Form::text('name_of_institute', null, ['class' => 'form-control border-primary', 'placeholder' => 'Name of Institute']) !!}
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <!--
                      {!! Form::label('status', 'Active') !!}
                      {!! Form::switch('status', null, null, ['data-on-label' => 'Yes', 'data-off-label' => 'No']) !!} 
                    -->
                      {!! Form::label('marks_obtained', 'Marks Obtained') !!}
                      {!! Form::text('marks_obtained', null, ['class' => 'form-control border-primary', 'placeholder' => 'Marks Obtained']) !!}
                    </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('total_marks', 'Total Marks') !!}
                      {!! Form::text('total_marks', null, ['class' => 'form-control border-primary', 'placeholder' => 'Total Marks']) !!}
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <!--
                      {!! Form::label('status', 'Active') !!}
                      {!! Form::switch('status', null, null, ['data-on-label' => 'Yes', 'data-off-label' => 'No']) !!} 
                    -->
                      {!! Form::label('gpa', 'GPA') !!}
                      {!! Form::text('gpa', null, ['class' => 'form-control border-primary', 'placeholder' => 'GPA']) !!}
                    </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('distinctions', 'Distinctions') !!}
                      {!! Form::text('distinctions', null, ['class' => 'form-control border-primary', 'placeholder' => 'Distinctions']) !!}
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <!--
                      {!! Form::label('status', 'Active') !!}
                      {!! Form::switch('status', null, null, ['data-on-label' => 'Yes', 'data-off-label' => 'No']) !!} 
                    -->
                      {!! Form::label('passing_year', 'Passing Year') !!}
                      {!! Form::text('passing_year', null, ['class' => 'form-control border-primary', 'placeholder' => 'Passing Year']) !!}
                    </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('previous_qualifications', 'Previous Qualifications') !!}
                      {!! Form::text('previous_qualifications', null, ['class' => 'form-control border-primary', 'placeholder' => 'Previous Qualifications']) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('Degree', 'Degree') !!}
                      {!! Form::select('degree_id',$degrees,null,['class' => 'form-control border-primary']) !!}
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('Major', 'Major') !!}
                      {!! Form::select('majors_id',$majors,null,['class' => 'form-control border-primary']) !!}
                    </div>
                  </div>
                </div> 
                  <div class="row">
                    <div class="form-group">
                      {!! Form::label('grades', 'Grades for O/A Levels:') !!}
                      {!! Form::label('A*s', '------A*s') !!}
                      {!! Form::selectRange('A*s',1,20,['class' => 'form-control border-primary'] ) !!}
                      {!! Form::label('As', '------As') !!}
                      {!! Form::selectRange('As',1,20,['class' => 'form-control'] ) !!}
                      {!! Form::label('Bs', '------Bs') !!}
                      {!! Form::selectRange('Bs',1,20,['class' => 'form-control'] ) !!}
                      {!! Form::label('Cs', '------Cs') !!}
                      {!! Form::selectRange('Cs',1,20,['class' => 'form-control'] ) !!}
                      {!! Form::label('Ds', '------Ds') !!}
                      {!! Form::selectRange('Ds',1,20,['class' => 'form-control'] ) !!}
                      {!! Form::label('Fs', '------Fs') !!}
                      {!! Form::selectRange('Fs',1,20,['class' => 'form-control'] ) !!}
                    </div>
                  </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('status', 'Active') !!}
                      {!! Form::switch('status', null, null, ['data-on-label' => 'Accepted', 'data-off-label' => 'On Hold']) !!}
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
