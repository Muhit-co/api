@extends('layouts.default')
@section('content')

@include('partials.header')



<section id="map" class="tabsection u-opacity0">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <div id="map-canvas">
                <!-- <iframe width="600" height="450" frameborder="0" style="border:0" src=""></iframe> -->
                <script>
                    mapInitialize();
                    // google.maps.event.addDomListener(window, 'load', mapInitialize);
                </script>
            </div>

            <div class="u-aligncenter u-pv20">
                <a class="btn btn-secondary" id="map_redraw">MAP REDRAW</a>
            </div>

        </div>
    </div>
</section>

@include('partials.web-app-message')

@stop
