<?php
// Fallbacks if parameters not defined
$name = isset($user->first_name) ? $user->first_name : '[name]';
$issue_id = isset($comment->issue_id) ? $comment->issue_id : '[issue_id]';
?>

@extends('emails.layouts.default')

@section('title')

    {{ trans('email.supported_idea_solved_title') }}

@stop

@section('content')

    @include('emails.partials.header', array('username' => $name ))

    {{ trans('email.supported_idea_solved_content') }}

    <br /><br />

    @include('emails.partials.button', array(
      'url' => 'http://muhit.co/issues/view/' . $issue_id,
      'text' => trans('email.go_to_idea')
    ))

    @include('emails.partials.footer')

@stop
