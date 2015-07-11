@extends('layouts.reports')
@section('content')

<section class="u-pv50">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="card">
                <div class="card-header u-pa40">
                    <h1>
                        <i class="ion ion-clipboard u-mr15 c-light"></i>
                        <big>Beşiktaş</big>
                    </h1>
                </div>
                <div class="card-content u-ph40">
                    <canvas id="chart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>

@stop
