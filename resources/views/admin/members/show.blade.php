@extends('layouts.default')
@section('content')

@include('partials.header', array('type'=>'show'))

<?php setlocale(LC_TIME, 'tr_TR.utf8', 'tr_TR.UTF-8', 'tr_TR');?>

<section>

    <div class="row u-mt40">
        <div class="col-md-10 col-md-offset-1">
            <div class="card card-issue">
                <div class="card-header u-aligncenter">
                    <div class="u-floatright u-pt10">
                        @if ($member->level == 4 || $member->level == 5)
                            <a href="/admin/reject-muhtar/{{$member->id}}" class="btn btn-blueempty" title="Reject">
                                <i class="ion ion-close-circled"></i>
                            </a>
                        @endif
                        @if ($member->level == 3 || $member->level == 4)
                            <a href="/admin/approve-muhtar/{{$member->id}}" class="btn btn-blueempty u-ml10" title="Approve">
                                <i class="ion ion-checkmark-circled"></i>
                            </a>
                        @endif
                        <a href="/admin/edit-member/{{$member->id}}" class="btn btn-outline u-ml10">
                            <i class="ion ion-edit"></i>
                            {{ trans('auth.edit_cap') }}
                        </a>
                    </div>
                    <a href="javascript:window.history.back()" class="u-floatleft u-mr15 u-mt15"><i class="ion ion-android-arrow-back ion-2x"></i></a>
                    <div class="u-inlineblock u-alignleft">
                        <div class="badge badge-circle-large u-floatleft u-mr20">
                            <img src="//d1vwk06lzcci1w.cloudfront.net/80x80/{{$member->picture}}" alt="{{$member->first_name}}">
                        </div>
                        <h2 class="u-mt10 u-nowrap u-lineheight20" style="overflow: visible;">{{ $member->first_name }} {{ $member->last_name }}</h2>
                        <span class="">{{ getUserLevel(intval($member->level)) }}</span>
                    </div>
                </div>
                @if ($member->level == 4)
                <div class="bg-light u-pa15 u-aligncenter">
                    <strong class="u-block u-mb10"><em>This user has requested muhtar access to Muhit. Is their information correct?</em></strong>
                    <div class="u-block">
                        <a href="/admin/reject-muhtar/{{$member->id}}" class="btn btn-greytored u-ml10">
                            <i class="ion ion-close-circled u-mr5"></i>
                            REJECT
                        </a>
                        <a href="/admin/approve-muhtar/{{$member->id}}" class="btn btn-greytogreen u-ml10">
                            <i class="ion ion-checkmark-circled u-mr5"></i>
                            APPROVE
                        </a>
                    </div>
                </div>
                @endif
                <div class="card-content">

                    <div class="u-mv10 u-clearfix">
                        <div class="u-floatleft u-aligncenter u-width100">
                            <i class="ion ion-email ion-2x c-light u-mr20"></i>
                        </div>
                        <div class="u-floatleft u-mv5">
                            {{(strlen($member->email) > 0) ? $member->email : '—' }}
                        </div>
                    </div>
                    <div class="u-mv10 u-clearfix">
                        <div class="u-floatleft u-aligncenter u-width100">
                            <i class="ion ion-location ion-2x c-light u-mr20"></i>
                        </div>
                        <div class="u-floatleft u-mv5">
                            {{ (strlen($member->location) > 0) ? $member->location : '–' }}
                        </div>
                    </div>
                    <div class="u-mv10 u-clearfix">
                        <div class="u-floatleft u-aligncenter u-width100">
                            <i class="ion ion-navicon ion-2x c-light u-mr20"></i>
                        </div>
                        <div class="u-floatleft u-mv5">
                            {{ $member->level }}
                        </div>
                    </div>
                    <div class="u-mv10 u-clearfix">
                        <div class="u-floatleft u-aligncenter u-width100">
                            <i class="ion ion-calendar ion-2x c-light u-mr20"></i>
                        </div>
                        <div class="u-floatleft u-mv5">
                            {{ strftime('%d %h %Y', strtotime($member->created_at)) }}
                        </div>
                    </div>
                    <div class="u-mv10 u-clearfix">
                        <div class="u-floatleft u-aligncenter u-width100">
                            <i class="ion ion-android-call ion-2x c-light u-mr20"></i>
                        </div>
                        <div class="u-floatleft u-mv5">
                            {{ (strlen($member->phone) > 0) ? $member->phone : '–' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@stop
