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
    
    <a href="{{ $idea_url }}" style="display: inline-block; padding: 10px 20px; line-height: 20px; background-color: #44a1e0; color: #fff; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; text-decoration: none;">
        {{ trans('email.go_to_idea') }}
    </a>
    
    @include('emails.partials.footer')
    
@stop