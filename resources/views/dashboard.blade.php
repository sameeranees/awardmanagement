@extends('layouts.app')

@section('title')
    {{ __('Dashboard') }}
@endsection

@section('content')
{!! Charts::assets() !!}
    <div class="row">
          <div class="col-xl-3 col-lg-6 col-12">
            <div class="card" style="background-color:rgb(0, 199, 197)">
              <div class="card-content">
                <div class="media align-items-stretch">
                  <div class="p-2 text-center bg-primary bg-darken-2">
                    <i class="icon-camera font-large-2 white"></i>
                  </div>
                  <div class="p-2 bg-gradient-x-primary white media-body">
                    <h5>Book Venue</h5>
                    <script>
                      var today = new Date();
                      var date_to_reply = new Date('2019-1-15');
                      var timeinmilisec = date_to_reply.getTime() - today.getTime();
                      var d= Math.floor(timeinmilisec / (1000 * 60 * 60 * 24));
                    </script>
                    <h5 class="text-bold-400 mb-0"><script>document.write(d + " Days Left");</script></h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-6 col-12">
            <div class="card" style="background-color: rgb(243, 39, 117)">
              <div class="card-content">
                <div class="media align-items-stretch">
                  <div class="p-2 text-center bg-danger bg-darken-2">
                    <i class="icon-user font-large-2 white"></i>
                  </div>
                  <div class="p-2 bg-gradient-x-danger white media-body">
                    <h5>Application Closing</h5>
                    <script>
                      var today = new Date();
                      var date_to_reply = new Date('2019-2-15');
                      var timeinmilisec = date_to_reply.getTime() - today.getTime();
                      var d= Math.floor(timeinmilisec / (1000 * 60 * 60 * 24));
                    </script>
                    <h5 class="text-bold-400 mb-0"><script>document.write(d + " Days Left");</script></h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-6 col-12">
            <div class="card" style="background-color: rgb(252, 124, 65)">
              <div class="card-content">
                <div class="media align-items-stretch">
                  <div class="p-2 text-center bg-warning bg-darken-2">
                    <i class="icon-basket-loaded font-large-2 white"></i>
                  </div>
                  <div class="p-2 bg-gradient-x-warning white media-body">
                    <h5>Students Confirmation</h5>
                    <script>
                      var today = new Date();
                      var date_to_reply = new Date('2019-3-15');
                      var timeinmilisec = date_to_reply.getTime() - today.getTime();
                      var d= Math.floor(timeinmilisec / (1000 * 60 * 60 * 24));
                    </script>
                    <h5 class="text-bold-400 mb-0"><script>document.write(d + " Days Left");</script></h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-6 col-12">
            <div class="card" style="background-color: rgb(55, 198, 95)">
              <div class="card-content">
                <div class="media align-items-stretch">
                  <div class="p-2 text-center bg-success bg-darken-2">
                    <i class="icon-wallet font-large-2 white"></i>
                  </div>
                  <div class="p-2 bg-gradient-x-success white media-body">
                    <h5>Award Ceremony</h5>
                    <script>
                      var today = new Date();
                      var date_to_reply = new Date('2019-4-15');
                      var timeinmilisec = date_to_reply.getTime() - today.getTime();
                      var d= Math.floor(timeinmilisec / (1000 * 60 * 60 * 24));
                    </script>
                    <h5 class="text-bold-400 mb-0"><script>document.write(d + " Days Left");</script></h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-content">
            {!! $chart->render() !!}
          </div>
        </div>
        <div class="card">
          <div class="card-content">
            {!! $chart2->render() !!}
          </div>
        </div>
@endsection
