<?php
// Fallbacks if parameters not defined
$name = isset($user->first_name) ? $user->first_name : '[name]';
$muhtar_name = isset($comment->muhtar->first_name) ? $comment->muhtar->first_name : '[muhtar_name]';
$issue_id = isset($comment->issue_id) ? $comment->issue_id : '[issue_id]';
?>

@extends('emails.layouts.default')

@section('title')

    {{ trans('email.supported_idea_into_development_title') }}

@stop

@section('content')

    @include('emails.partials.header', array('username' => $name ))

    {{ trans('email.supported_idea_into_development_content', array('sender' => $muhtar_name)) }}

    <br /><br />

    <a href="http://muhit.co/issues/view/{{ $issue_id }}" style="display: inline-block; padding: 10px 20px; line-height: 20px; background-color: #44a1e0; color: #fff; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; text-decoration: none;">
        {{ trans('email.go_to_idea') }}
    </a>

    @include('emails.partials.footer')

@stop
