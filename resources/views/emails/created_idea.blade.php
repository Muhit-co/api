<?php
// Fallbacks if parameters not defined
$name = isset($user->first_name) ? $user->first_name : '[name]';
$idea_url = isset($idea_url) ? $idea_url : '[idea_url]';
?>

@extends('emails.layouts.default')

@section('title')

    {{ trans('email.created_idea_title') }}

@stop

@section('content')

    @include('emails.partials.header', array('username' => $name ))

    {{ trans('email.created_idea_content') }}

    <br /><br />

    @include('emails.partials.button', array(
      'url' => $idea_url,
      'text' => trans('email.go_to_idea')
    ))
    
    @include('emails.partials.footer')
    
@stop