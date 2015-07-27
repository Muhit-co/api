@extends('emails.layouts.default')

@section('title')

  All emails

@stop

@section('content')

  <ol><li>
      <a href="/email/sign_up_conf">Sign up confirmation</a>
    </li>
    <li>
      <a href="/email/forgot_password">Forgot password</a>
    </li>
    <li>
      <a href="/email/created_idea">You have added a new idea</a>
    </li>
    <li>
      <a href="/email/created_idea_supported">Idea has been supported</a>
    </li>
    <li>
      <a href="/email/created_idea_commented">Idea has been commented on</a>
    </li>
    <li>
      <a href="/email/created_idea_removed">Idea has been removed</a>
    </li>
    <li>
      <a href="/email/created_idea_into_development">Idea has been taken into development</a>
    </li>
    <li>
      <a href="/email/created_idea_solved">Idea has been solved</a>
    </li>
    <li>
      <a href="/email/supported_idea_into_development">idea you supported has been taken into development</a>
    </li>
    <li>
      <a href="/email/supported_idea_solved">idea you supported has been solved</a>
    </li>
    <li>
      <a href="/email/supported_idea_removed">idea you supported has been removed</a>
    </li>
    <li>
      <a href="/email/supported_idea_commented">idea you supported has been commented on</a>
    </li>
    <li>
      <a href="/email/announcement_muhtar">new announcement from your muhtar</a>
    </li>
    <li>
      <a href="/email/announcement_municipality">new announcement from your municipality</a>
    </li>
    <li>
      <a href="/email/invite_cayimi_ic">invitation from muhtar to 'have a tea'</a>
    </li>
  </ol>

@stop