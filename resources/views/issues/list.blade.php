@extends('layouts.default')
@section('content')

@include('partials.header', ['redir' => 'list', 'hood' => $hood, 'district' => $district, 'all_districts' => $all_districts])

<?php setlocale(LC_TIME, 'tr_TR.utf8', 'tr_TR.UTF-8', 'tr_TR'); ?>

<section id="issues">
    <div class="row">
        <div class="col-xs-12 col-sm-8" id="issueListContainer">

            @if (isset($_GET['sort']) && $_GET['sort'] == 'map')
                @include('partials.issues-map', ['issues' => $issues])
            @else
                @include('partials.issues-list', ['issues' => $issues])
            @endif

        </div>
    	<div class="col-xs-12 col-sm-4">
    		@include('partials.issues-latest-updates')
    	</div>
    </div>
</section>


@include('partials.web-app-message')

@stop
