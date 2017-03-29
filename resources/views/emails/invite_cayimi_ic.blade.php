@extends('emails.layouts.default')

@section('title')

    {{ trans('email.invite_cayimi_ic_title') }}

@stop

@section('content')

    @include('emails.partials.header')

    {!! trans('email.invite_cayimi_ic_content', array('hood' => '[mahalle]', 'muhtar' => '[muhtar_name]', 'idea_title' => '[idea_title]')) !!}

    <br /><br />

    @include('emails.partials.button', array(
      'url' => '[muhtar_url]',
      'text' => trans('email.go_to_muhtar_info')
    ))
    
    &nbsp;&nbsp;

    @include('emails.partials.button', array(
      'url' => '[idea_url]',
      'text' => trans('email.go_to_idea')
    ))
    
    @include('emails.partials.footer')
    
@stop