@extends('layouts.default')
@section('content')

<?php setlocale(LC_TIME, 'tr_TR.utf8', 'tr_TR.UTF-8', 'tr_TR'); ?>

<section>

    <div class="row u-pv20">
        <div class="col-md-10 col-md-offset-1">
            <div class="card u-mt0">
                <div class="card-header">
                    <div class="u-floatright">
                        <a href="/admin/edit-member/{{$member->id}}" class="btn btn-outline u-mt20">
                            <i class="ion ion-edit u-mr5"></i>
                            {{ trans('auth.edit_cap') }}
                        </a>
                        @if ($member->level == 4 || $member->level == 5)
                            <a href="/admin/reject/muhtar" class="btn btn-outline u-mt20 u-ml10">
                                <i class="ion ion-close-circled u-mr5"></i>
                                REJECT
                            </a>
                        @endif
                        @if ($member->level == 3 || $member->level == 4)
                            <a href="/admin/approve/muhtar" class="btn btn-outline u-mt20 u-ml10">
                                <i class="ion ion-checkmark-circled u-mr5"></i>
                                APPROVE
                            </a>
                        @endif
                    </div>
                    <div class="badge badge-circle-large u-floatleft u-mr20 u-mb20">
                        <img src="//d1vwk06lzcci1w.cloudfront.net/80x80/{{$member->picture}}" alt="{{$member->first_name}}">
                    </div>
                    <h2 class="u-mt15">
                        {{ $member->first_name }} {{ $member->last_name }}
                    </h2>
                    <span class="">{{ $member->username }}</span>
                </div>
                <div class="card-content">

                    <div class="u-mv10 u-clearfix">
                        <div class="u-floatleft u-aligncenter u-width100">
                            <i class="ion ion-email ion-2x c-light u-mr20"></i>
                        </div>
                        <div class="u-floatleft u-mv5">
                                {{ $member->email }}
                        </div>
                    </div>
                    <div class="u-mv10 u-clearfix">
                        <div class="u-floatleft u-aligncenter u-width100">
                            <i class="ion ion-location ion-2x c-light u-mr20"></i>
                        </div>
                        <div class="u-floatleft u-mv5">
                                {{ $member->location }}
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
                </div>
            </div>
        </div>
    </div>

</section>

@stop