@extends('emails.layouts.default')

@section('title')

    {{ trans('email.muhtar_account_approved_title') }}

@stop

@section('content')

    {{ trans('email.muhtar_account_approved_text') }}

    <br /><br />

    <a href="http://muhit.co/" style="display: inline-block; padding: 10px 20px; line-height: 20px; background-color: #44a1e0; color: #fff; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; text-decoration: none;">
        {{ trans('email.go_to_homepage') }}
    </a>

    <br /><br />

    <p><em>{!! trans('email.muhtar_help_guides_text', ['tagstart' => '<a href="http://hikaye.muhit.co/nasil-yapilir" target="_blank">', 'tagend' => '</a>']) !!}</em></p>

    <a href="http://hikaye.muhit.co/nasil-yapilir" style="display: inline-block; padding: 5px 10px; line-height: 20px; background-color: #ccccdd; color: #fff; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; text-decoration: none;">
        {{ trans('email.how_to_guides_button') }}
    </a>

    @include('emails.partials.footer')

@stop
