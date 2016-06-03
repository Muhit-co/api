@extends('layouts.default')
@section('content')

    <header class="u-relative header-list">

        <div class="row u-pb40">
            <div class="col-md-4 col-sm-7 col-md-offset-1 u-mb10">
                <h2>{{ trans('issues.my_muhtar_info') }}</h2>
            </div>
            <div class="col-md-6 col-sm-5">
                <a href="/members/edit-profile" class="btn btn-sm btn-whiteoutline u-floatright u-ml10">
                    <i class="ion ion-edit"></i>
                </a>
                <?php $hood = (isset(Auth::user()->hood['name'])) ? Auth::user()->hood['name'] : '–'; ?>
                <p class="c-white u-nowrap u-alignright"><strong>{{ $hood }}</strong> <span class="u-ml10"></span></p>
            </div>
        </div>

    </header>

    <section class="u-mv20">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                @if($muhtar)

                    <div class="card u-mv20">
                        <div class="card-content">

                            <div class="row row-nopadding">
                                <div class="col-sm-2 u-aligncenter">
                                    <div class="badge badge-circle-xlarge u-mr20">
                                        <img src="//d1vwk06lzcci1w.cloudfront.net/80x80/placeholders/profile.png"
                                             alt=""/>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-10">
                                    <div class="u-clearfix u-mb20">
                                        <h2 class="u-mt20">{!! $muhtar->full_name !!}</h2>
                                        <p>Muhtar</p>
                                    </div>
                                    <i class="ion ion-android-call ion-fw ion-2x u-aligncenter u-floatleft c-blue u-mt5 u-mr10"></i>
                                    <label>{{ trans('auth.phone_number') }}</label>
                                    <p class="u-mb20">{{ $muhtar->phone }}</p>

                                    <i class="ion ion-email ion-fw ion-2x u-aligncenter u-floatleft c-blue u-mt5 u-mr10"></i>
                                    <label>{{ trans('auth.email_address') }}</label>
                                    <p class="u-mb20">{{ $muhtar->email }}</p>
                                </div>
                                <div class="col-md-5 u-pt20">
                                    <label class="c-blue">Muhtarlık</label>
                                    <p>{{ $muhtar->location }}</p>
                                    <div class="media u-mt20">
                                        {{--<div class="media-map">--}}
                                            {{--<img src="images/map.jpg" alt=""/>--}}
                                        {{--</div>--}}
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
