@extends('layouts.default')
@section('content')

@include('partials.header')



<section id="map" class="tabsection">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <div id="map-canvas">
                <!-- <iframe width="600" height="450" frameborder="0" style="border:0" src=""></iframe> -->
            </div>
            <script>
                mapInitialize();
                // google.maps.event.addDomListener(window, 'load', mapInitialize);
            </script>

            <!-- <div class="u-aligncenter u-pv20">
                <a class="btn btn-tertiary" id="map_redraw"><i class="ion ion-refresh"></i></a>
            </div> -->

        </div>
    </div>
</section>

@include('partials.web-app-message')

@stop
