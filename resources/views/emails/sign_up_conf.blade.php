<?php
// Fallbacks if parameters not defined
$user_id = isset($user->id) ? $user->id : '1';
$token = isset($user->verify_token) ? $user->verify_token : 'token';
?>

@extends('emails.layouts.default')

@section('title')

    {{ trans('email.sign_up_conf_title') }}

@stop

@section('content')

    {{ trans('email.sign_up_conf_content') }}

    <br /><br />

    <a href="http://muhit.co/confirm/{{ $user_id }}/{{ $token }}" style="display: inline-block; padding: 10px 20px; line-height: 20px; background-color: #44a1e0; color: #fff; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; text-decoration: none;">
        {{ trans('email.go_to_homepage') }}
    </a>

    @include('emails.partials.footer')

@stop
