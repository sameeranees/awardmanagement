<!DOCTYPE html>
<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

  <meta name="csrf-token" content="{{ csrf_token() }}" />
  
  <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
  
  <link rel="apple-touch-icon" href="{{ asset('assets/images/ico/apple-icon-120.png') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/ico/favicon.ico') }}">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
  rel="stylesheet">

  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors.css') }}">
  <!-- END VENDOR CSS-->

  <!-- BEGIN STACK CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/app.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/menu/menu-types/vertical-menu-modern.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/extensions/sweetalert.css') }}">
  {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/toggle/switchery.min.css') }}"> --}}
  <!-- END STACK CSS-->

  <!-- BEGIN Page Level CSS-->
    @stack('styles')
  <!-- END Page Level CSS-->
  
  <!-- BEGIN Custom CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
  <!-- END Custom CSS-->
</head>

<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar scrollTo"
data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-url="{{ url('/') }}" data-asset-url="{{ asset('assets') }}">
    <!-- BEGIN HEADER-->
    @include('partials.header')
    <!-- END HEADER-->

    <!-- BEGIN SIDEBAR-->
    @include('partials.sidebar')
    <!-- END SIDEBAR-->

    <!-- BEGIN CONTENT-->
    <div class="app-content content">
        <div class="content-wrapper">
          
          @include('partials.breadcrumbs')

          <div class="content-body"> 
            
            {!! (new App\Classes\CHtml)->alertMessage($errors) !!}
            
            <section>
                @yield('content')
            </section>

          </div>
        </div>
    </div>
    <!-- END CONTENT-->
  
    <!-- BEGIN FOOTER-->
    @include('partials.footer')
    <!-- END FOOTER-->

  <!-- BEGIN VENDOR JS-->
  <script src="{{ asset('assets/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('assets/vendors/js/extensions/sweetalert.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js') }}" type="text/javascript"></script>
  {{-- <script src="{{ asset('assets/vendors/js/forms/toggle/switchery.min.js') }}" type="text/javascript"></script> --}}
  <!-- BEGIN VENDOR JS-->
  
  <script type="text/javascript">
      $(function () {
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
      });
  </script>
  
  <!-- BEGIN STACK JS-->
  <script src="{{ asset('assets/js/core/app-menu.js') }}" type="text/javascript"></script>
  <script src="{{ asset('assets/js/core/app.js') }}" type="text/javascript"></script>
  <script src="{{ asset('assets/custom/lib.js') }}" type="text/javascript"></script>
  <!-- END STACK JS-->
  
  <!-- BEGIN PAGE LEVEL JS-->
  @stack('scripts')
  <!-- END PAGE LEVEL JS-->

</body>
</html>