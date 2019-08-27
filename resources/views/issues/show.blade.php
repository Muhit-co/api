@extends('layouts.default')
@section('content')
@section('dialogs')
    @if($role =='admin' || $role == 'municipality-admin' || $role == 'superadmin')
        @include('dialogs.write_comment', ['issue_id' => $issue['id']])
        @include('dialogs.edit_comment', ['issue_id' => $issue['id']])
        @include('dialogs.come_drink_tea', ['issue_id' => $issue['id']])
        @include('dialogs.change_status_progress', ['issue_id' => $issue['id']])
        @include('dialogs.change_status_solved', ['issue_id' => $issue['id']])
    @endif
@stop

<?php
// head parameters
$pageTitle = $shareTitle = $issue['title'] . ' -';
if(count($issue['images']) > 0) {
    $shareImage = getImageURL($issue['images'][0]['image'], '600x300');
}
if(strlen($issue['problem']) > 0) {
    $shareDescr = $issue['problem'];
}
?>

@include('partials.header', array('type'=>'show'))

<?php if (App::getLocale() == 'tr') { setlocale(LC_TIME, 'tr_TR.utf8', 'tr_TR.UTF-8', 'tr_TR'); } ?>

<section>
    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <?php
            $issue_supporters = (int) Redis::get('supporter_counter:' . $issue['id']);
            $issue_status = getIssueStatus($issue['status'], $issue_supporters);
            $neighbourhood = trim( explode(',', $issue['location'], 2)[0] );
            $distr_city = trim( explode(',', $issue['location'], 2)[1] );
            ?>

            {{-- Card start --}}
            <div class="card card-issue">
                <div class="card-header u-clearfix">
                    
                    <div class="u-floatright u-clearfix">
                        @include('partials.issue-actions', array('issue' => $issue))
                    </div>

                    <a href="javascript:window.history.back()" class="u-floatleft u-pr20"><i class="ion ion-android-arrow-back ion-2x"></i></a>
                    <span class="title u-inlineblock u-mt5">
                        <a href="/fikirler?{{ buildRelativeUrl('location', $issue['location'] ) }}">{{ $neighbourhood }}</a>,
                        <a href="/fikirler?{{ buildRelativeUrl('district', $distr_city , 'location' ) }}">{{ $distr_city }}</a>
                    </span>
                </div>
                <div class="card-content">

                    <div class="u-floatright u-relative">
                        <div class="label label-{{$issue_status['class']}} u-pr80 u-mr10">
                            <i class="ion {{$issue_status['icon']}}"></i>
                            <span class="text extended">{{$issue_status['title']}}</span>
                        </div>
                        <div id="support_counter" class="badge badge-circle-xlarge badge-support badge-{{$issue_status['class']}} u-pinned-topright u-pt15" style="margin-top: -15px;">
                            <div class="value">{{ $issue_supporters }}</div>
                            <label>{{ trans_choice('issues.supporters_cap', $issue_supporters) }}</label>
                        </div>
                    </div>

                    <h3 class="u-mh5 u-mv10">
                        {{$issue['title']}}
                    </h3>


                    <?php
                    // map longitude & latitude, and hide if no information
                    $lon = ((!empty($issue['coordinates'])) ? trim(explode(",", $issue['coordinates'])[0]) : 0);
                    $lat = ((!empty($issue['coordinates'])) ? trim(explode(",", $issue['coordinates'])[1]) : 0);
                    $showmap = ($lon > 0 && $lat > 0) ? true : false;

                    $numimages = count($issue['images']);
                    $imagecol = ($numimages == 0) ? 'col-xs-4 extended' : 'col-sm-8';
                    $mapcol = ($numimages == 0) ? 'col-sm-8 compact' : 'col-sm-4';
                    ?>


                    <div class="row row-nopadding media u-mv20">
                        <div class="media-images {{ $imagecol }}">

                            <div id="slides">
                                <?php ;?>

                                @if($numimages == 0)
                                    <div class="bg-lightest u-pa30 u-aligncenter">
                                        <i class="ion ion-image ion-4x c-lighter"></i>
                                        <div class="c-light"><strong>{{ trans('issues.no_images_present') }}</strong></div>
                                    </div>
                                @elseif($numimages >= 1)
                                    @foreach($issue['images'] as $image)
                                        <div style="height: 100%;">
                                            <div class="media-image" style="background-image: url('{{ getImageURL($image['image'], '600x300') }}')" title="{{$issue['title']}}"></div>
                                        </div>
                                    @endforeach
                                @endif

                            </div>

                            @if($numimages > 1)
                                <script>
                                    $(function(){
                                        $("#slides").slidesjs({
                                            width: 500,
                                            height: 300,
                                        });
                                    });
                                </script>
                            @endif

                        </div>
                        @if($showmap)
                        <div class="media-map {{ $mapcol }}" data-status="">
                            <div id="map-canvas">
                            </div>
                            <script>
                                mapInitializeForIssue({{$lon}}, {{$lat}}, '{{$issue['status']}}');
                            </script>
                        </div>
                        @endif
                    </div>

                    <div class="row row-nopadding u-mv10">
                        <div class="col-md-9">
                                @foreach($issue['tags'] as $tag)
                                        <span class="tag u-mv5 u-mr10" style="background-color:#{{$tag['background']}}">{{$tag['name']}}</span>
                                @endforeach
                        </div>
                        <div class="col-md-3 u-alignright">
                            <label class="c-light u-mt10"><i class="ion ion-android-calendar u-mr5"></i>{{ strftime('%d %B %Y', strtotime($issue['created_at'])) }}</label>
                        </div>
                    </div>

                    @if(strlen($issue['problem']) > 0)
                    <div class="problem u-mb20">
                        <h4 class="c-light">{{ trans('issues.problem') }}</h4>
                        <p>{!! linkifyText($issue['problem']) !!}</p>
                    </div>
                    @endif
                    @if(strlen($issue['solution']) > 0)
                    <div class="solution u-mb5">
                        <h4 class="c-light">{{ trans('issues.solution') }}</h4>
                        <p>{!! linkifyText($issue['solution']) !!}</p>
                    </div>
                    @endif

                    <div class="u-clearfix u-mt20">
                        @if($issue['is_anonymous'] == 0)
                            <div class="badge badge-circle badge-user u-floatleft u-mr10">
                                <img src="{{ getImageURL($issue['user']['picture'], '40x40') }}" alt="{{$issue['user']['first_name']}}" />
                            </div>
                            <div class="c-light u-pt5">
                                {{$issue['user']['first_name']}} {{$issue['user']['last_name']}}
                            </div>
                        @else
                            <small class="c-light"><em>{{ trans('issues.submitted_anonymously') }}</em></small>
                        @endif
                    </div>

                </div>

                <div class="card-footer u-clearfix">
                    <div class="u-floatright">
                        @if(Auth::check() and (Auth::user()->id == $issue['user_id'] or Auth::user()->level > 5))
                            @if($issue_supporters < 10)
                                <a href="/issues/delete/{{$issue['id']}}" class="btn btn-tertiary btn-greytored u-ml10" onclick="return confirm('{{ trans('issues.delete_confirm') }}');"><i class="ion ion-trash-b u-mr5"></i> SİL</a>
                            @else
                                <span class="hasTooltip u-ml10">
                                    <a href="javascript:void(0)" class="btn" disabled><i class="ion ion-trash-b u-mr5"></i> SİL</a>
                                    <span class="tooltip tooltip-alignright u-mr20">
                                        <i class="ion ion-information-circled ion-15x u-floatleft u-mv10 u-mr10"></i>
                                        <div class="u-ml30">{{ trans('issues.delete_restricted_supporters_tooltip') }}.</div>
                                    </span>
                                </span>
                            @endif
                        @else
                            <span class="hasTooltip u-ml10">
                                <a href="https://docs.google.com/forms/d/1Gwyj1OZ_MkMF7QYBN625ADYWIifMsQdFqACA7uTcof0/viewform?entry.22153642&entry.903793893&entry.960103609&entry.512574518={{$issue['title']}}" class="btn btn-tertiary" target="_blank"><i class="ion ion-alert-circled"></i></a>
                                <span class="tooltip tooltip-alignright u-width300 u-mr5">
                                    <i class="ion ion-alert-circled ion-15x u-floatleft u-mv10 u-mr10"></i>
                                    <div class="u-ml30">{{ trans('issues.report_issue_tooltip') }}</div>
                                </span>
                            </span>
                        @endif
                    </div>
                    <ul class="issue-history title">

                        @foreach($issue['updates'] as $update)
                            <li>
                                <i class="ion ion-record u-mr10"></i>
                                <span class="date">{{strftime('%d %h %Y', strtotime($update['created_at']))}}</span> –
                                <strong>{{ trans('issues.issue_status_' . $update['new_status']) }}</strong>.
                            </li>
                        @endforeach

                    </ul>
                </div>

            </div>
            {{-- Card end --}}

            @include('partials.issue-comments', array('issue'=> $issue))

        </div>

    </div>
</section>

@stop
