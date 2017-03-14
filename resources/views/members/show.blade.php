@extends('layouts.default')

@section('content')

    <section>
        <div class="row u-pv20">

            <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                <div class="card u-mt0">
                    <div class="card-header">
                        <div class="u-floatright">
                            <a href="/members/edit-profile" class="btn btn-outline u-mt20">
                                {!! trans('auth.edit_cap') !!}
                            </a>
                        </div>
                        <div class="badge badge-circle-xlarge u-floatleft u-mr20 u-mb20">
                            <img src="{{ getImageURL(Auth::user()->picture, '80x80') }}"
                                 alt="{{ Auth::user()->first_name }}">
                        </div>
                        <h2 class="u-mt20">
                            {!! Auth::user()->first_name . ' ' . Auth::user()->last_name !!}
                        </h2>
                        <span class="">{!! Auth::user()->username !!}</span>
                    </div>
                    <div class="card-content">

                        <div class="row u-mv10">
                            <div class="col-xs-2 u-aligncenter u-pr30">
                                <i class="ion ion-location ion-2x c-light"></i>
                            </div>
                            <div class="col-xs-9">
                                <div class="u-floatleft u-mv5">

                                    @if($user->hood &&  $user->hood->district && $user->hood->district->city)
                                        {!! $user->hood->name !!},
                                        {!! $user->hood->district->name !!},
                                        {!! $user->hood->district->city->name !!}
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="row u-mv10">
                            <div class="col-xs-2 u-aligncenter u-pr30">
                                <i class="ion ion-email ion-2x c-light"></i>
                            </div>
                            <div class="col-xs-9">
                                <div class="u-floatleft u-mv5">{!! Auth::user()->email !!}</div>
                            </div>
                        </div>
                        <div class="row u-mv10">
                            <div class="col-xs-2 u-aligncenter u-pr30">
                                <i class="ion ion-calendar ion-15x c-light u-mt5"></i>
                            </div>
                            <div class="col-xs-9">
                                <div class="u-floatleft u-mv5">
                                    {!! Date::parse(Auth::user()->created_at)->format('d F Y') !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            @if (Auth::user()->level < 5)
                <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 u-mt20">
                    <div class="list">
                        <div class="list-header u-pa15">
                            <h4>
                                {!! trans('issues.added_ideas') !!}
                            </h4>
                        </div>
                        <ul>
                            @if($user->issues)

                                @foreach($user->issues as $issue)
                                    <li>
                                        <a href="/issues/view/{!! $issue->id !!}">
                                            <div class="badge badge-image u-floatleft u-mr15">
                                                <img src="{{ getImageURL('placeholders/issue.jpg', '50x50') }}"
                                                     alt="" />
                                            </div>
                                            <div class="badge badge-status u-floatright u-mt10 u-ph10 u-pv5">
                                                <i class="ion ion-wrench u-mr5"></i>
                                                <strong>
                                                    {!! (int) Redis::get('supporter_counter:'. $issue->id) !!}
                                                </strong>
                                            </div>
                                            <strong>{!! $issue->title !!}</strong>
                                            <p>
                                                <span class="date">
                                                    {!! Date::parse($issue->created_at)->format('d F Y') !!}
                                                </span>
                                            </p>
                                        </a>
                                    </li>
                                @endforeach

                            @endif
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </section>

@stop
