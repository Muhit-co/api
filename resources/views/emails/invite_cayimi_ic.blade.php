@extends('emails.layouts.default')

@section('title')

    {{ trans('email.invite_cayimi_ic_title') }}

@stop

@section('content')

    @include('emails.partials.header')

    {!! trans('email.invite_cayimi_ic_content', array('hood' => '[mahalle]', 'muhtar' => '[muhtar_name]', 'idea_title' => '[idea_title]')) !!}

    <br /><br />
    
    <a href="[muhtar_url]" style="display: inline-block; padding: 10px 20px; line-height: 20px; background-color: #44a1e0; color: #fff; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; text-decoration: none;">
        {{ trans('email.go_to_muhtar_info') }}
    </a>
    &nbsp;&nbsp;
    <a href="[idea_url]" style="display: inline-block; padding: 10px 20px; line-height: 20px; background-color: #44a1e0; color: #fff; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; text-decoration: none;">
        {{ trans('email.go_to_idea') }}
    </a>
    
    @include('emails.partials.footer')
    
@stop