@extends('layouts.default')

@section('content')

    <section class="u-mv20">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                @if($muhtar)

                    <div class="card u-mv20">
                        <div class="card-content">

                            <div class="card u-mt0">
                                <div class="card-header">
                                    <div class="u-floatright">
                                        @if(Auth::user()->id == $muhtar->id)
                                            <a href="/user-edit" class="btn btn-outline u-mt20">
                                                {{ trans('auth.edit_cap') }}
                                            </a>
                                        @endif
                                    </div>
                                    <div class="badge badge-circle-xlarge u-floatleft u-mr20 u-mb20">
                                        <img src="//d1vwk06lzcci1w.cloudfront.net/80x80/{{$muhtar->picture}}"
                                             alt="{{$muhtar->full_name}}">
                                    </div>
                                    <h2 class="u-mt20">
                                        {{ $muhtar->full_name }}
                                    </h2>
                                    <span class="">{{ $muhtar->username }}</span>
                                </div>
                                <div class="card-content">

                                    <div class="row u-mv10">
                                        <div class="col-xs-2 u-aligncenter u-pr30">
                                            <i class="ion ion-location ion-2x c-light"></i>
                                        </div>
                                        <div class="col-xs-9">
                                            <div class="u-floatleft u-mv5">{!! $muhtar->location !!}</div>
                                        </div>
                                    </div>
                                    <div class="row u-mv10">
                                        <div class="col-xs-2 u-aligncenter u-pr30">
                                            <i class="ion ion-email ion-2x c-light"></i>
                                        </div>
                                        <div class="col-xs-9">
                                            <div class="u-floatleft u-mv5">{{ $muhtar->email }}</div>
                                        </div>
                                    </div>
                                    <div class="row u-mv10">
                                        <div class="col-xs-2 u-aligncenter u-pr30">
                                            <i class="ion ion-calendar ion-15x c-light u-mt5"></i>
                                        </div>
                                        <div class="col-xs-9">
                                            <div class="u-floatleft u-mv5">
                                                {!! Date::parse($muhtar->created_at)->format('d F Y') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @else

                                <div class="u-aligncenter u-pv20">
                                    <span class="c-light">
                                        <i class="ion ion-person-add ion-2x"></i><br/>
                                        <h4>{{ trans('issues.your_muhtar_didnt_sign_up_yet') }}</h4>
                                    </span>
                                </div>
                            @endif

                        </div>
                    </div>
            </div>
        </div>

    </section>

@stop
