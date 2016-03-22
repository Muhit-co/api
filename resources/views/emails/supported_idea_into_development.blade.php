@extends('emails.layouts.default')

@section('title')

    {{ trans('email.supported_idea_into_development_title') }}

@stop

@section('content')

    @include('emails.partials.header')

    {{ trans('email.supported_idea_into_development_content', array('sender' => $comment->muhtar->first_name)) }}

    <br /><br />

    <a href="http://muhit.co/issues/view/{{$comment->issue_id}}" style="display: inline-block; padding: 10px 20px; line-height: 20px; background-color: #44a1e0; color: #fff; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; text-decoration: none;">
        {{ trans('email.go_to_idea') }}
    </a>

    @include('emails.partials.footer')

@stop
