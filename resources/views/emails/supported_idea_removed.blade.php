<?php
// Fallbacks if parameters not defined
$name = isset($user->first_name) ? $user->first_name : '[name]';
$issue_title = isset($issue->title) ? $issue->title : '[issue_title]';
?>

@extends('emails.layouts.default')

@section('title')

    {{ trans('email.supported_idea_removed_title') }}

@stop

@section('content')

    @include('emails.partials.header', array('username' => $name ))

    {!! trans('email.supported_idea_removed_content', array('idea_title' => $issue_title, 'email' => '<a href="mailto:destek@muhit.co" target="_blank">destek@muhit.co</a>')) !!}

    <br /><br />

    @include('emails.partials.button', array(
      'url' => 'http://muhit.co',
      'text' => trans('email.go_to_homepage')
    ))

    @include('emails.partials.footer')

@stop
