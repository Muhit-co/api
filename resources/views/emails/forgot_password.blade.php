<?php
// Fallbacks if parameters not defined
$name = isset($user->first_name) ? $user->first_name : '[name]';
$email = isset($email) ? $email : '[email]';
$string = isset($string) ? $string : '[string]';
?>

@extends('emails.layouts.default')

@section('title')

    {{ trans('email.forgot_password_title') }}

@stop

@section('content')

    @include('emails.partials.header', array('username' => $name ))

    {{ trans('email.forgot_password_content') }}

    <br /><br />

    @include('emails.partials.button', array(
      'url' => url('auth/reset-password', [$email, $string]),
      'text' => trans('email.change_password')
    ))

    @include('emails.partials.footer')

@stop
