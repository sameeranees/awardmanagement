@extends('layouts.app')

@section('title')
    {{ $section->title }}
@endsection

@push('scripts')
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/forms/switch.css') }}">
@endpush

@section('content')
<?php

for($i = 0; $i < 2; $i++) {
	?>
	<div class="col-md-12">
	<?php
	foreach($members as $member){
		for($i = 0; $i < $number; $i++) {
			?>
			<div class="row"><?php
			$member->first_name;?>	    		
		}
	}
}
@endsection