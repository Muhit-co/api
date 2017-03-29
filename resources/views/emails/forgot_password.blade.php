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

    <a href="{{url('auth/reset-password', [$email, $string])}}" style="display: inline-block; padding: 10px 20px; line-height: 20px; background-color: #44a1e0; color: #fff; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; text-decoration: none;">
        {{ trans('email.change_password') }}
    </a>

    @include('emails.partials.footer')

@stop
