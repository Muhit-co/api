@extends('layouts.compact')
@section('content')

<section class="login bg-blue u-pt50">

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form method="post" action="/register">
                <a href="/register-muhtar" class="u-floatright"><em>Ben muhtarım</em> <i class="ion ion-android-arrow-forward u-ml5"></i></a>
                <h2 class="u-mv20">Kayıt Ol</h2>

                <div class="form-group form-fullwidth u-mb20">
                    <label>{{ trans('auth.first_name') }}</label>
                    <input type="text" class="form-input" value="" name="first_name" placeholder="{{ trans('auth.first_name_placeholder') }}" />
                </div>

                <div class="form-group form-fullwidth u-mb20">
                    <label>{{ trans('auth.last_name') }}</label>
                    <input type="text" class="form-input" value="" name="last_name" placeholder="{{ trans('auth.last_name_placeholder') }}" />
                </div>

                <div class="form-group form-fullwidth u-mb20">
                    <label>{{ trans('auth.email_address') }}</label>
                    <input type="text" class="form-input" value="" name="email" placeholder="{{ trans('auth.email_address_placeholder') }}" />
                </div>

                <div class="form-group form-fullwidth u-mb20">
                    <label>{{ trans('auth.password') }}</label>
                    <input type="password" class="form-input" value="" name="password" placeholder="{{ trans('auth.password_placeholder') }}" />
                </div>

                <label>{{ trans('auth.neighbourhood') }}</label>
                <div class="form-group form-autosuggest form-fullwidth hasIconRight u-mb20" data-form-state="">
                    <input id="location_string" type="text" class="form-input" value="" name="user.hood" placeholder="{{ trans('auth.neighbourhood_placeholder') }}" />
                    <div class="form-appendRight u-aligncenter" style="width: 40px;">
                        <i class="form-state form-state-home ion ion-home ion-15x u-mt5 c-blue"></i>
                        <i class="form-state form-state-static ion ion-location ion-2x c-blue u-hidden"></i>
                        <i class="form-state form-state-current ion ion-android-locate ion-15x u-mt5 c-blue u-hidden"></i>
                        <i class="form-state form-state-busy ion ion-load-a ion-15x u-ml10 u-mt5 ion-spinning c-blue u-hidden" style="margin-right: 7px"></i>
                    </div>
                </div>

                <div class="form-group form-fullwidth u-mt30 u-mb20">
                    <input id="termsagree" type="checkbox" class="form-input u-floatleft u-mr20" value="" name="user.agree" />
                    <label for="termsagree">
                        {{ trans('auth.agree_with_terms', ['tagstart' => '<a href="javascript:void(0)">', 'tagend' => '</a>']) }}
                    </label>
                </div>

                <button type="submit" class="btn btn-primary u-floatright">KAYIT OL</i></button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3 u-aligncenter u-pv20">

            <hr class="u-mb35" />

            <a href="javascript:void(0)" class="btn btn-facebook u-ma5"><i class="ion ion-social-facebook ion-15x u-floatleft u-ph5"></i> {{ trans('auth.connect_cap') }}</a>
            <a href="javascript:void(0)" class="btn btn-twitter u-ma5"><i class="ion ion-social-twitter u-floatleft u-pa5"></i> {{ trans('auth.connect_cap') }}</a>
            <a href="javascript:void(0)" class="btn btn-googleplus u-ma5"><i class="ion ion-social-googleplus u-floatleft u-pa5"></i> {{ trans('auth.connect_cap') }}</a>

        </div>
    </div>

</section>

@stop
