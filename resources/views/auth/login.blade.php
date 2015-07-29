@extends('layouts.compact')
@section('content')

<section class="login bg-blue u-pt50">

    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <form method="post" action="/login">
                <h2 class="u-mv20">{{ trans('auth.log_in') }}</h2>

                <div class="form-group form-fullwidth u-mb20">
                    <input type="text" class="form-input" name="email" value="" placeholder="{{ trans('auth.email_address') }}" />
                </div>

                <div class="form-group form-fullwidth u-mb20">
                    <input type="password" class="form-input" value="" placeholder="{{ trans('auth.your_password') }}" name="password" />
                </div>

                <button type="submit" class="btn btn-primary u-floatright">
                    {{ trans('auth.log_in_cap') }}
                    <i class="ion ion-log-in ion-15x"></i>
                </button>
                <a href="/forgot-password" class="btn btn-empty btn-sm u-mr10 u-mt5">
                    {{ trans('auth.forgot_password_cap') }}
                </a>
            </form>

        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3 u-aligncenter u-pv20">

            <hr class="u-mb35" />

            <a href="javascript:void(0)" class="btn btn-facebook u-ma5"><i class="ion ion-social-facebook ion-15x u-floatleft u-ph5"></i> <span class="u-floatleft u-mt5">{{ trans('auth.connect_cap') }}</span></a>
            <a href="javascript:void(0)" class="btn btn-twitter u-ma5"><i class="ion ion-social-twitter u-floatleft u-pa5"></i> {{ trans('auth.connect_cap') }}</a>
            <a href="javascript:void(0)" class="btn btn-googleplus u-ma5"><i class="ion ion-social-googleplus u-floatleft u-pa5"></i> {{ trans('auth.connect_cap') }}</a>

        </div>
    </div>

</section>

@stop
