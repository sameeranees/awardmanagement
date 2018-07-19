<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Forrun Eats</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mediaqurries.css') }}">
    <link href="http://jackonthe.net/wp-content/themes/kappe/css/animations.css" rel="stylesheet">
    <link rel="stylesheet" href="http://plugins.upbootstrap.com/assets/css/bootstrap-fancyfile.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
</head>

<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg fixed-top" id="header">
    <div class="container uppercase">
        <a class="navbar-brand" href="#">
            <img id="logo" src="images/logo.png" alt=""/>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul id="forruneats-ul" class="navbar-nav  ml-auto">
                @foreach($pages as $page)
                    <li class="nav-item">
                        <a class="nav-link" href={{$page["id"]}}> {{$page["title"]}}</a>
                    </li>
                @endforeach
            </ul>
        </div>


    </div>
</nav>

<!-- Page Content -->
<main id="main">
    @yield('content')



<!-- Page Footer -->

<section id="cus-footer">
    <div class="container p-0">
        <div class="col-md-12 p-0">
            <div class="row m-0">
                <div class="col-md-5 col-sm-12 copyrights pull-left">
                    Copyright © Forrun Eats 2018. All Rights Reserved.
                </div>

                <div class="col-md-2 col-sm-12 social-icons">
                    <i class="fa fa-facebook" aria-hidden="true"></i>
                    <i class="fa fa-twitter" aria-hidden="true"></i>
                    <i class="fa fa-instagram" aria-hidden="true"></i>
                </div>

                <div class="col-md-5 col-sm-12 float-md-right footer-links">
                    <ul class="float-md-right">
                        <li><a href="#">Company Login</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li class="last-footer-li"><a href="#">Privacy</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- The modal -->
<div class="modal fade" id="flipFlop" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabel">Add my workplace</h4>
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
                <!--<span aria-hidden="true">&times;</span>-->
                </button>
            </div>
            <div class="modal-body">
                <form class="form" role="form" autocomplete="off">
                    <div class="form-group row">
                        <!--<label class="col-lg-4 col-form-label form-control-label">Company Name</label>-->
                        <div class="col-lg-12">
                            <input class="form-control" type="text" value="" placeholder="Company Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <!--<label class="col-lg-4 col-form-label form-control-label">Contact Number</label>-->
                        <div class="col-lg-12">
                            <input class="form-control" type="text" value="" placeholder="Contact Person">
                        </div>
                    </div>
                    <div class="form-group row">
                        <!--<label class="col-lg-4 col-form-label form-control-label">Email Domain</label>-->
                        <div class="col-lg-12">
                            <input class="form-control" type="text" value="" placeholder="Contact Number">
                        </div>
                    </div>
                    <!--<div class="form-group row">-->
                    <!--<label class="col-lg-4 col-form-label form-control-label">Upload Company Logo</label>-->
                    <!-- <div class="col-lg-12">
                       <!--<input class="form-control" type="file" value="" placeholder="Upload Company Logo">-->
                    <!--<input id="demo1" type="file" class="form-control">-->
                    <!--</div>-->
                    <!--</div>-->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-page-btns">Submit</button>
            </div>
        </div>
    </div>
</div>
</main>
<!-- Bootstrap core JavaScript -->
<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>

<!-- Wow Js for custom animations -->
<script src="https://wowjs.uk/dist/wow.min.js"></script>
<script src="{{ asset('js/wowjs-custom.js') }}" type="text/javascript"></script>
<script src="http://plugins.upbootstrap.com/assets/js/bootstrap-fancyfile.min.js"></script>

<!-- Custom js file -->
<script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>
</body>
</html>


