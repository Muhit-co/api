@extends('emails.layouts.default')

@section('title')

    {{ trans('email.announcement_muhtar_title') }}

@stop

@section('content')

    @include('emails.partials.header')

    {{ trans('email.announcement_muhtar_content', array('hood' => '[mahalle]', 'muhtar' => '[muhtar_name]')) }}

    <br /><br />

    @include('emails.partials.button', array(
      'url' => '[announcement_url]',
      'text' => trans('email.go_to_announcement')
    ))
    
    @include('emails.partials.footer')
    
@stop