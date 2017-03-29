<?php
// Fallbacks if parameters not defined
$name = isset($user->first_name) ? $user->first_name : '[name]';
$issue_id = isset($issue->id) ? $issue->id : '[issue_id]';
?>

@extends('emails.layouts.default')

@section('title')

    {{ trans('email.created_idea_supported_title') }}

@stop

@section('content')

    @include('emails.partials.header', array('username' => $name ))

    {{ trans('email.created_idea_supported_content') }}

    <br /><br />

    @include('emails.partials.button', array(
      'url' => 'http://muhit.co/issues/view/' . $issue_id,
      'text' => trans('email.go_to_idea')
    ))

    @include('emails.partials.footer')

@stop
