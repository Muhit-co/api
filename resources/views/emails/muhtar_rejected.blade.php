@extends('emails.layouts.default')

@section('title')

    {{ trans('email.muhtar_account_rejected_title') }}

@stop

@section('content')

    <p>{{ trans('email.muhtar_account_rejected_text') }}</p>

    <br />

    <p>{{ trans('email.muhtar_account_rejected_elaboration') }}</p>

    <a href="mailto:iletisim@muhit.co?subject=[Muhtar girişi sorunu]" style="display: inline-block; padding: 10px 20px; line-height: 20px; background-color: #44a1e0; color: #fff; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; text-decoration: none;">
        {{ trans('email.email_us_button') }}
    </a>

    <br /><br />

    @include('emails.partials.footer')

@stop
