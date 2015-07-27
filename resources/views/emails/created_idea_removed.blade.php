@extends('emails.layouts.default')

@section('title')

    {{ trans('email.created_idea_removed_title') }}

@stop

@section('content')

    @include('emails.partials.header')

    {!! trans('email.created_idea_removed_content', array('idea_title' => '[idea title]', 'email' => '<a href="mailto:destek@muhit.co" target="_blank">destek@muhit.co</a>')) !!}

    <br /><br />
    
    <a href="[tandc_url]" style="display: inline-block; padding: 10px 20px; line-height: 20px; background-color: #44a1e0; color: #fff; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; text-decoration: none;">
        {{ trans('email.read_again_tandc') }}
    </a>
    
    @include('emails.partials.footer')
    
@stop