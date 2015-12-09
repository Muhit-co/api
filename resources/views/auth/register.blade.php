@extends('layouts.compact')
@section('content')

<section class="login bg-blue u-pt50">

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form method="post" action="/register">
                <a href="/register-muhtar" class="u-floatright"><em>{{ trans('auth.sign_up_muhtar_link') }}</em> <i class="ion ion-android-arrow-forward u-ml5"></i></a>
                <h2 class="u-mv20">{{ trans('auth.sign_up') }}</h2>

                <div class="form-group form-fullwidth u-mb20">
                    <label>{{ trans('auth.your_first_name') }}</label>
                    <input type="text" class="form-input" name="first_name" value="{{ Input::old('first_name') }}" placeholder="{{ trans('auth.first_name_placeholder') }}" required />
                </div>

                <div class="form-group form-fullwidth u-mb20">
                    <label>{{ trans('auth.your_last_name') }}</label>
                    <input type="text" class="form-input" name="last_name" value="{{ Input::old('last_name') }}"  placeholder="{{ trans('auth.last_name_placeholder') }}" required />
                </div>

                <div class="form-group form-fullwidth u-mb20">
                    <label>{{ trans('auth.your_email_address') }}</label>
                    <input type="email" class="form-input" name="email" value="{{ Input::old('email') }}" placeholder="{{ trans('auth.email_address_placeholder') }}" required />
                </div>

                <div class="form-group form-fullwidth u-mb20">
                    <label>{{ trans('auth.password') }}</label>
                    <input type="password" class="form-input" name="password" value="{{ Input::old('password') }}"  placeholder="{{ trans('auth.password_placeholder') }}" required />
                </div>

                <label>{{ trans('auth.your_neighbourhood') }}</label>
                <div class="c-blue">@include('partials.field-hood')</div>

                <div class="form-group form-fullwidth u-mt30 u-mb20">
                    <input id="termsagree" type="checkbox" class="form-input u-floatleft u-mr20" value="" name="user.agree" required />
                    <label for="termsagree">
                        {!! trans('auth.agree_with_terms', ['tagstart' => '<a href="http://hikaye.muhit.co/kullanim-kosullari" target="_blank">', 'tagend' => '</a>']) !!}
                    </label>
                </div>

                <button type="submit" class="btn btn-primary u-floatright">KAYIT OL</i></button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3 u-aligncenter u-pv20">

            <hr class="u-mb20" />

            <a href="/login/facebook" class="btn btn-facebook u-ma5 u-mb20"><i class="ion ion-social-facebook ion-15x u-floatleft u-ph5"></i> <span class="u-floatleft u-mt5">{{ trans('auth.connect_cap') }}</span></a>
            <!-- <a href="javascript:void(0)" class="btn btn-twitter u-ma5"><i class="ion ion-social-twitter u-floatleft u-pa5"></i> {{ trans('auth.connect_cap') }}</a>
            <a href="javascript:void(0)" class="btn btn-googleplus u-ma5"><i class="ion ion-social-googleplus u-floatleft u-pa5"></i> {{ trans('auth.connect_cap') }}</a> -->

        </div>
    </div>

</section>

@stop
