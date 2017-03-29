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

    @include('emails.partials.button', array(
      'url' => 'http://muhit.co/confirm/' . $user_id . '/' . $token,
      'text' => trans('email.go_to_homepage')
    ))

    @include('emails.partials.footer')

@stop
