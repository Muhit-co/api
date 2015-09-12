@extends('layouts.compact')
@section('content')

<section class="login bg-blue u-pt50 u-pb50">

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form method="post" action="/register">
                <h2 class="u-mv20">{{ trans('auth.muhtar_signup_title') }}</h2>

                <!-- TODO: @gcg how to we switch the sign up logic from muhtar to belediye? -->
                <div class="form-group form-fullwidth u-mb10">
                    <div class="row row-nopadding">
                        <div class="col-xs-6">
                            <input id="type_muhtar" type="radio" checked="checked" class="form-input" value="" name="admin_type" />
                            <label for="type_muhtar">{{ trans('auth.muhtar') }}</label>
                        </div>
                        <div class="col-xs-6">
                            <input id="type_municipality" type="radio" class="form-input" value="" name="admin_type" />
                            <label for="type_municipality">{{ trans('auth.municipality') }}</label>
                        </div>
                    </div>
                </div>

                <label>{{ trans('auth.neighbourhood') }}</label>
                @include('partials.field-hood')

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
                    <input type="email" class="form-input" value="" name="email" placeholder="{{ trans('auth.email_address_placeholder') }}" />
                </div>

                <div class="form-group form-fullwidth u-mb20">
                    <label>{{ trans('auth.password') }}</label>
                    <input type="password" class="form-input" value="" name="password" placeholder="{{ trans('auth.password_placeholder') }}" />
                </div>

                <div class="form-group form-fullwidth u-mt30 u-mb20">
                    <input id="termsagree" type="checkbox" class="form-input u-floatleft u-mr20" value="" name="user.agree" />
                    <label for="termsagree">
                        {!! trans('auth.agree_with_terms', ['tagstart' => '<a href="http://hikaye.muhit.co/kullanim-kosullari" target="_blank">', 'tagend' => '</a>']) !!}
                    </label>
                </div>
                <input type="hidden" name="level" value="4">
                <button type="submit" class="btn btn-quaternary u-floatright">{{ trans('auth.request_access_cap') }}</i></button>
            </form>
        </div>
    </div>

</section>

@stop
