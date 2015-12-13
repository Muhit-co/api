@extends('layouts.default')
@section('content')

<header class="u-relative header-list">

    <div class="row u-pb20">
        <div class="col-md-10 col-md-offset-1">
            <div class="u-floatright">
                @include('partials.add_idea_button', array('hood' => $hood))
            </div>
            <h2>{{ trans('issues.ideas_i_supported') }}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @include('partials.issue-list-tabs')
        </div>
    </div>

</header>

<section class="tabsection" id="latest">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if (isset($_GET['sort']) && $_GET['sort'] == 'map')
                @include('partials.issues-map', ['issues' => $issues])
            @else
                @include('partials.issues-list', ['issues' => $issues])
            @endif
        </div>
    </div>
</section>

@stop
