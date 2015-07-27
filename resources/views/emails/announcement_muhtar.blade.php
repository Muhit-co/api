@extends('emails.layouts.default')

@section('title')

    {{ trans('email.announcement_muhtar_title') }}

@stop

@section('content')

    @include('emails.partials.header')

    {{ trans('email.announcement_muhtar_content', array('hood' => '[mahalle]', 'muhtar' => '[muhtar_name]')) }}

    <br /><br />
    
    <a href="[announcement_url]" style="display: inline-block; padding: 10px 20px; line-height: 20px; background-color: #44a1e0; color: #fff; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; text-decoration: none;">
        {{ trans('email.go_to_announcement') }}
    </a>
    
    @include('emails.partials.footer')
    
@stop