<?php
// Fallbacks if parameters not defined
$commenter_name = isset($comment_user->first_name) ? $comment_user->first_name : '[commenter]';
$receiver_name = isset($receiving_user->first_name) ? $receiving_user->first_name : '[receiver]';
$issue_id = isset($comment->issue_id) ? $comment->issue_id : '[isue_id]';
$comment_id = isset($comment->id) ? $comment->id : '[comment_id]';
?>

@extends('emails.layouts.default')

@section('title')

    {{ trans('email.supported_idea_commented_title', array('sender' => $commenter_name)) }}

@stop

@section('content')

    @include('emails.partials.header', array('username' => $receiver_name ))

    {{ trans('email.supported_idea_commented_content', array('sender' => $commenter_name)) }}

    <br /><br />

    <a href="http://muhit.co/issues/view/{{ $issue_id }}#comment-{{ $comment_id }}" style="display: inline-block; padding: 10px 20px; line-height: 20px; background-color: #44a1e0; color: #fff; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; text-decoration: none;">
        {{ trans('email.go_to_idea') }}
    </a>

    @include('emails.partials.footer')

@stop
