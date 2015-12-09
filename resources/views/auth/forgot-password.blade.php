@extends('layouts.compact')
@section('content')

<section class="login bg-blue u-pt50">

    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 u-mb40">
            <form method="post" action="/auth/forgot-password">
                <h2 class="u-mv20">{{ trans('auth.forgot_password') }}</h2>

                <p class="c-white u-mb20">{{ trans('auth.forgot_password_msg') }}</p>

                <div class="form-group form-fullwidth u-mb20">
                    <input type="email" required class="form-input" name="email" value="{{ Input::old('email') }}" placeholder="{{ trans('auth.email_address') }}" />
                </div>
                <button type="submit" class="btn btn-primary u-floatright">
                    {{ trans('auth.send_info_cap') }}
                    <i class="ion ion-paper-airplane ion-15x u-ml5"></i>
                </button>
            </form>

        </div>
    </div>

</section>

@stop
