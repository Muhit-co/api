@extends('layouts.empty')
@section('content')

<section class="u-aligncenter">

  <img src="/images/logo.svg" alt="" class="u-mv50" style="height: 40px;" />
  <br>

  <i class="ion ion-wand ion-4x c-bluedark"></i>
  <h2 class="u-mt20">{{ trans('intro.account_created') }}</h2>

  <div class="row u-mt30">
    <div class="col-xs-12 col-sm-6 col-md-5 col-md-offset-1">
      <div class="flash message u-pv20 u-mb20 u-alignleft">

        <div class="u-opacity50 u-aligncenter u-mb20">
          <i class="ion ion-android-list ion-3x u-mr10"></i>
          <i class="ion ion-map ion-3x"></i>
        </div>

        <h3>{{ trans('intro.welcome_browse_header') }}</h3>
        <p class="c-white u-mt10">{{ trans('intro.welcome_browse_text') }}</p>
        <a href="/" class="btn btn-secondary u-mt20">{{ trans('intro.welcome_browse_action') }} <i class="ion ion-arrow-right-c ion-15x u-floatright u-ml5"></i></a>
        <br>

        <small id="redir_msg">
          (Will automatically redirect in <span id="redir_sec">0</span> seconds) <b><a class="c-bluedark u-opacity75 u-ml5" href="javascript:void(0)" onclick="clearTimeout(redirect); $('#redir_msg').hide();">Stop</a></b>
        </small>

      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-5">
      <div class="flash message u-pv20 u-mb20 u-alignleft">

        <div class="u-opacity50 u-aligncenter u-mb20">
          <i class="ion ion-chatbox-working ion-3x u-mr10"></i>
        </div>

        <h3>{{ trans('intro.welcome_create_header') }}</h3>
        <p class="c-white u-mt10">{{ trans('intro.welcome_create_text') }}</p>
        <a href="/issues/new" class="btn btn-primary u-mt20">{{ trans('intro.welcome_create_action') }} <i class="ion ion-plus u-ml5"></i></a>

      </div>
    </div>
  </div>

</section>

<script>
redirect_duration = 10000;
redirect_url = '/';

$(document).ready(function() {

  milliseconds = 1000;
  $('#redir_sec').html(redirect_duration / 1000);

  redirect = setInterval(function() {

    console.log(milliseconds / 1000);

    $('#redir_sec').html((redirect_duration - milliseconds) / 1000);

    milliseconds += 1000;
    if(milliseconds > redirect_duration) {
      window.location = redirect_url;
      clearTimeout(redirect);
    }
  }, 1000);

});
</script>

@stop
