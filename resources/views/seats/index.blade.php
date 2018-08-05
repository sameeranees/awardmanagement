@extends('layouts.app')

@section('title')
    {{ $section->title }}
@endsection

@push('scripts')
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/forms/switch.css') }}">
@endpush

@section('content')
    <div class="row">
    <div class="col-md-12">
      <div class="card">
        
        <div class="card-header">
          <h4 class="card-title">{{ $section->heading }}</h4>
          <div class="heading-elements">
            <div class="btn-group">
              <a href="{{ route($section->slug.'.create') }}" class="btn btn-info">Create</a>
              <a href="{{ route($section->slug.'.print') }}" class="btn btn-info">Print Seats</a>
            </div>
          </div>
        </div>

        <div class="card-content collapse show">
          <div class="card-body">
            {!!
                App\Classes\DataGrid::instance($section->slug, null, true)
                ->bind(route($section->slug.'.list'))
                ->addColumn('Seat No', 'seat_no', 100, true, ['type'=>'text-field'])
                ->addColumn('Name', 'first_name', 150, true, ['type'=>'text-field'])
                ->addColumn('Surname', 'surname', 100, true, ['type'=>'text-field' ])
                //->addColumn('Phone', 'phone', 100, true, ['type'=>'text-field' ])
                //->addColumn('Email', 'email', 400, true, ['type'=>'text-field' ])
                //->addColumn('DAM No', 'damno', 100, true, ['type'=>'text-field' ])
                ->addColumn('Degree', 'degree_name', 150, true, ['type'=>'text-field' ])
                ->addColumn('Major', 'majors_name', 150, true, ['type'=>'text-field' ])
                //->addColumn('Active', 'status', 80, true, ['type'=>'select', 'options' => ["-1"=>'All','0'=>'Inactive','1'=>'Active' ]] )
                //->addColumn('Actions', '', 50, false, ['type' => 'search-reset'])
                ->sortColumn(0, true)
                ->pagination(25, 'simple_numbers')
                ->getHtml()
            !!}
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection

@push('scripts')
  
  <script src="{{ asset('assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
  <script src="{{ asset('assets/custom/datatables/plugins/bootstrap/datatables.bootstrap.js') }}"></script>
  <script src="{{ asset('assets/custom/datatables/datatable.js') }}"></script>
  <script src="{{ asset('assets/custom/datatables/data-table-helper.js') }}"></script>

  <script type="text/javascript">
    {!! App\Classes\DataGrid::instance($section->slug)->getScript( 'xGrid' ) !!}

    xGrid.onLoad( function() {
        app.initSwitch();
        app.changeStatus('{{ route('change-status') }}');

        $('.grid-action-archive').on('click', function (e) {
            e.preventDefault();
            var $this = $(this);
            app.confirm('Are you sure to archive ' + $this.data('first_name') + "?", function() {
                app.ajax($this.attr('href'), 'POST', {
                    'id': $this.data('id'),
                    'first_name': $this.data('first_name'),
                    '_method': 'DELETE'
                }, function(response) {
                    swal("Deleted!", response.message, "success");
                    xGrid.reload();
                }, function(response) {
                });
            }, function(){
              swal("Cancelled", "It's safe.", "error");
            });
        });
    }); // onLoad
  </script>
@endpush
