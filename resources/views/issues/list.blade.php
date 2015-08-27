@extends('layouts.default')
@section('content')

@include('partials.header', ['redir' => 'list', 'hood' => $hood])

<?php setlocale(LC_TIME, 'tr_TR.utf8', 'tr_TR.UTF-8', 'tr_TR'); ?>

<section class="tabsection" id="latest">
    <div class="row">
        <div class="col-md-10 col-md-offset-1" id="issueListContainer">

            @include('partials.issues', ['issues' => $issues])

        </div>
    </div>
</section>


@include('partials.web-app-message')

@stop
