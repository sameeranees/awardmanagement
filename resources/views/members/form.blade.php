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
                      {!! Form::select('degree_id',$degrees,null, ['class' => 'form-control border-primary']) !!}
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('Major', 'Major') !!}
                      {!! Form::select('majors_id',$majors,null, ['class' => 'form-control border-primary']) !!}
                    </div>
                  </div>
                </div> 
                  <div class="row">
                    <div class="form-group">
                      {!! Form::label('grades', 'Grades for O/A Levels:') !!}
                      {!! Form::label('A*s', '------A*s') !!}
                      {!! Form::selectRange('A*s',0,20,null) !!}
                      {!! Form::label('As', '------As') !!}
                      {!! Form::selectRange('As',0,20,null) !!}
                      {!! Form::label('Bs', '------Bs') !!}
                      {!! Form::selectRange('Bs',0,20,null) !!}
                      {!! Form::label('Cs', '------Cs') !!}
                      {!! Form::selectRange('Cs',0,20,null) !!}
                      {!! Form::label('Ds', '------Ds') !!}
                      {!! Form::selectRange('Ds',0,20,null) !!}
                      {!! Form::label('Fs', '------Fs') !!}
                      {!! Form::selectRange('Fs',0,20,null) !!}
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

                <div class="card-header">
                <h4 class="card-title">Family History</h4>
                </div>                
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('formSelect', 'How many of your family members have recieved Academic Excellence award from DYSF?') !!}
                      {!! Form::selectRange('formSelect',0,5,null,['id'=>'formSelect','class' => 'form-control border-primary'] ) !!}
                    </div>
                  </div>
                </div> 

                <script>
                  jQuery(function($) {
                    $('.relative1').hide();
                    $('.relative2').hide();
                    $('.relative3').hide();
                    $('.relative4').hide();
                    $('.relative5').hide();
                    $('#formSelect').change(function () {
                      var val = $(this).val();
                      if(val==='1'){
                        $('.relative1').show();
                        $('.relative2').hide();
                        $('.relative3').hide();
                        $('.relative4').hide();
                        $('.relative5').hide();
                      }
                      else if(val==='2'){
                        $('.relative1').show();
                        $('.relative2').show();
                        $('.relative3').hide();
                        $('.relative4').hide();
                        $('.relative5').hide();
                      }
                      else if(val==='3'){
                        $('.relative1').show();
                        $('.relative2').show();
                        $('.relative3').show();
                        $('.relative4').hide();
                        $('.relative5').hide();
                      }
                      else if(val==='4'){
                        $('.relative1').show();
                        $('.relative2').show();
                        $('.relative3').show();
                        $('.relative4').show();
                        $('.relative5').hide();
                      }
                      else if (val==='5'){
                        $('.relative1').show();
                        $('.relative2').show();
                        $('.relative3').show();
                        $('.relative4').show();
                        $('.relative5').show();
                      }
                      else{
                          $('.relative1').hide();
                          $('.relative2').hide();
                          $('.relative3').hide();
                          $('.relative4').hide();
                          $('.relative5').hide();
                      }
                    });
                  });
                </script>

                <div class="relative1">
                <div class="card-header">
                <h4 class="card-title">Relative 1</h4>
                </div>  
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relative_name1', 'Name') !!}
                      {!! Form::text('relative_name1', null, ['class' => 'form-control border-primary', 'placeholder' => 'Name']) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relation_relative1', 'Relation') !!}
                      {!! Form::text('relation_relative1', null, ['class' => 'form-control border-primary', 'placeholder' => 'Relation']) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relative_year1', 'Passing Year') !!}
                      {!! Form::text('relative_year1', null, ['class' => 'form-control border-primary', 'placeholder' => 'Passing Year']) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relative_degree1', 'Degree') !!}
                      {!! Form::text('relative_degree1', null, ['class' => 'form-control border-primary', 'placeholder' => 'Degree']) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relative_contact1', 'Contact') !!}
                      {!! Form::text('relative_contact1', null, ['class' => 'form-control border-primary', 'placeholder' => 'Contact']) !!}
                    </div>
                  </div>
                </div>
              </div>

              <div class="relative2">  
                <div class="card-header">
                <h4 class="card-title">Relative 2</h4>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relative_name2', 'Name') !!}
                      {!! Form::text('relative_name2', null, ['class' => 'form-control border-primary', 'placeholder' => 'Name']) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relation_relative2', 'Relation') !!}
                      {!! Form::text('relation_relative2', null, ['class' => 'form-control border-primary', 'placeholder' => 'Relation']) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relative_year2', 'Passing Year') !!}
                      {!! Form::text('relative_year2', null, ['class' => 'form-control border-primary', 'placeholder' => 'Passing Year']) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relative_degree2', 'Degree') !!}
                      {!! Form::text('relative_degree2', null, ['class' => 'form-control border-primary', 'placeholder' => 'Degree']) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relative_contact2', 'Contact') !!}
                      {!! Form::text('relative_contact2', null, ['class' => 'form-control border-primary', 'placeholder' => 'Contact']) !!}
                    </div>
                  </div>
                </div>
              </div>

              <div class="relative3">
              <div class="card-header">
                <h4 class="card-title">Relative 3</h4>
                </div>  
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relative_name3', 'Name') !!}
                      {!! Form::text('relative_name3', null, ['class' => 'form-control border-primary', 'placeholder' => 'Name']) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relation_relative3', 'Relation') !!}
                      {!! Form::text('relation_relative3', null, ['class' => 'form-control border-primary', 'placeholder' => 'Relation']) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relative_year3', 'Passing Year') !!}
                      {!! Form::text('relative_year3', null, ['class' => 'form-control border-primary', 'placeholder' => 'Passing Year']) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relative_degree3', 'Degree') !!}
                      {!! Form::text('relative_degree3', null, ['class' => 'form-control border-primary', 'placeholder' => 'Degree']) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relative_contact3', 'Contact') !!}
                      {!! Form::text('relative_contact3', null, ['class' => 'form-control border-primary', 'placeholder' => 'Contact']) !!}
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="relative4">
              <div class="card-header">
                <h4 class="card-title">Relative 4</h4>
                </div>  
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relative_name4', 'Name') !!}
                      {!! Form::text('relative_name4', null, ['class' => 'form-control border-primary', 'placeholder' => 'Name']) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relation_relative4', 'Relation') !!}
                      {!! Form::text('relation_relative4', null, ['class' => 'form-control border-primary', 'placeholder' => 'Relation']) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relative_year4', 'Passing Year') !!}
                      {!! Form::text('relative_year4', null, ['class' => 'form-control border-primary', 'placeholder' => 'Passing Year']) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relative_degree4', 'Degree') !!}
                      {!! Form::text('relative_degree4', null, ['class' => 'form-control border-primary', 'placeholder' => 'Degree']) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relative_contact4', 'Contact') !!}
                      {!! Form::text('relative_contact4', null, ['class' => 'form-control border-primary', 'placeholder' => 'Contact']) !!}
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="relative5">
              <div class="card-header">
                <h4 class="card-title">Relative 5</h4>
                </div>  
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relative_name5', 'Name') !!}
                      {!! Form::text('relative_name5', null, ['class' => 'form-control border-primary', 'placeholder' => 'Name']) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relation_relative5', 'Relation') !!}
                      {!! Form::text('relation_relative5', null, ['class' => 'form-control border-primary', 'placeholder' => 'Relation']) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relative_year5', 'Passing Year') !!}
                      {!! Form::text('relative_year5', null, ['class' => 'form-control border-primary', 'placeholder' => 'Passing Year']) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relative_degree5', 'Degree') !!}
                      {!! Form::text('relative_degree5', null, ['class' => 'form-control border-primary', 'placeholder' => 'Degree']) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('relative_contact5', 'Contact') !!}
                      {!! Form::text('relative_contact5', null, ['class' => 'form-control border-primary', 'placeholder' => 'Contact']) !!}
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="card-header">
              <h4 class="card-title">References</h4>
              </div>

              <div class="card-header">
              <h4 class="card-title">Reference 1</h4>
              </div>

              <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('reference_name1', 'Name') !!}
                      {!! Form::text('reference_name1', null, ['class' => 'form-control border-primary', 'placeholder' => 'Name']) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('reference_surname1', 'Surname') !!}
                      {!! Form::text('reference_surname1', null, ['class' => 'form-control border-primary', 'placeholder' => 'Surname']) !!}
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('reference_address1', 'Address') !!}
                      {!! Form::textarea('reference_address1', null, ['class' => 'form-control border-primary','rows'=>2,'cols'=>4, 'placeholder' => 'Address']) !!}
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('reference_phone1', 'Phone') !!}
                      {!! Form::text('reference_phone1', null, ['class' => 'form-control border-primary', 'placeholder' => 'Phone']) !!}
                    </div>
                  </div>
                </div>

              <div class="card-header">
              <h4 class="card-title">Reference 2</h4>
              </div>

              <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('reference_name2', 'Name') !!}
                      {!! Form::text('reference_name2', null, ['class' => 'form-control border-primary', 'placeholder' => 'Name']) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('reference_surname2', 'Surname') !!}
                      {!! Form::text('reference_surname2', null, ['class' => 'form-control border-primary', 'placeholder' => 'Surname']) !!}
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('reference_address2', 'Address') !!}
                      {!! Form::textarea('reference_address2', null, ['class' => 'form-control border-primary','rows'=>2,'cols'=>4, 'placeholder' => 'Address']) !!}
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('reference_phone2', 'Phone') !!}
                      {!! Form::text('reference_phone2', null, ['class' => 'form-control border-primary', 'placeholder' => 'Phone']) !!}
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
