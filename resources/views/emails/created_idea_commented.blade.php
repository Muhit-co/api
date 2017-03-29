<?php
// Fallbacks if parameters not defined
$commenter_name = isset($comment_user->first_name) ? $comment_user->first_name : '[commenter]';
$receiver_name = isset($receiving_user->first_name) ? $receiving_user->first_name : '[receiver]';
$issue_id = isset($comment->issue_id) ? $comment->issue_id : '[isue_id]';
$comment_id = isset($comment->id) ? $comment->id : '[comment_id]';
?>

@extends('emails.layouts.default')

@section('title')

    {{ trans('email.created_idea_commented_title', array('sender' => $commenter_name)) }}

@stop

@section('content')

    @include('emails.partials.header', array('username' =>  $receiver_name))

    {{ trans('email.created_idea_commented_content', array('sender' => $commenter_name)) }}

    <br /><br />

    @include('emails.partials.button', array(
      'url' => 'http://muhit.co/issues/view/' . $issue_id . '#comment-' . $comment_id,
      'text' => trans('email.go_to_idea')
    ))

    @include('emails.partials.footer')

@stop
