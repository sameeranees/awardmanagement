@extends('frontend.layout')
    @section('content')
        @foreach($pages as $page)
            @include($page["template"])
        @endforeach

    <div class="clearfix"></div>
    @endsection