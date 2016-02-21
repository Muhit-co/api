@extends('emails.layouts.default')

@section('title')

    {{ trans('email.sign_up_conf_title') }}

@stop

@section('content')

    {{ trans('email.sign_up_conf_content') }}

    <br /><br />

    <a href="http://muhit.co/confirm/{{$user->id}}/{{$user->verify_token}}" style="display: inline-block; padding: 10px 20px; line-height: 20px; background-color: #44a1e0; color: #fff; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; text-decoration: none;">
        {{ trans('email.go_to_homepage') }}
    </a>

    @include('emails.partials.footer')

@stop
