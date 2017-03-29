<?php
// Fallbacks if parameters not defined
$name = isset($user->first_name) ? $user->first_name : '[name]';
$muhtar_name = isset($comment->muhtar->first_name) ? $comment->muhtar->first_name : '[muhtar_name]';
$issue_id = isset($comment->issue_id) ? $comment->issue_id : '[issue_id]';
?>

@extends('emails.layouts.default')

@section('title')

    {{ trans('email.created_idea_into_development_title') }}

@stop

@section('content')

    @include('emails.partials.header', array('username' => $name ))

    {{ trans('email.created_idea_into_development_content', array('sender' => $muhtar_name)) }}

    <br /><br />

    @include('emails.partials.button', array(
      'url' => 'http://muhit.co/issues/view/' . $issue_id,
      'text' => trans('email.go_to_idea')
    ))

    @include('emails.partials.footer')

@stop
