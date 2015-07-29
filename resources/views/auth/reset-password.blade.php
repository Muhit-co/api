@extends('layouts.compact')
@section('content')

<section class="login bg-blue u-pt50">

    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 u-mb40">
            <form method="post" action="">
                <h2 class="u-mv20">{{ trans('auth.reset_password') }}</h2>

                <p class="c-white u-mb20">{!! trans('auth.reset_password_msg', ['email' => '<strong>[user_email]</strong>']) !!}.</p>

                <div class="form-group form-fullwidth u-mb20">
                    <input type="password" class="form-input" value="" placeholder="{{ trans('auth.password') }}" name="password" />
                </div>

                <div class="form-group form-fullwidth u-mb20">
                    <input type="password" class="form-input" value="" placeholder="{{ trans('auth.password_again') }}" name="password" />
                </div>

                <button type="submit" class="btn btn-primary u-floatright">
                    {{ trans('auth.reset_password_cap') }}
                </button>

            </form>

        </div>
    </div>

</section>

@stop
