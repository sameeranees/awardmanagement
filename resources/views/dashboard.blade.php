@extends('layouts.app')

@section('title')
    {{ __('Dashboard') }}
@endsection

@section('content')
    <div class="row">
    <div class="col-md-12">
      <div class="card">
        
        <div class="card-header">
          <h4 class="card-title">{{ __('Dashboard') }}</h4>
        </div>

        <div class="card-content collapse show">
          <div class="card-body">
            Content of the page....
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection
