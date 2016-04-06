@extends('layouts.empty')
@section('content')

<div class="row" style="padding-top: 10vh;">
  <div class="col-xs-12 u-aligncenter">
    <img src="images/broken-link.svg" alt="" class="u-mb50" style="width: 80px; height: 80px;" />
    <h2>{{ trans('error.something_went_wrong') }}</h2>
    <p class="u-inlineblock u-mt20 u-mb20 c-white">{{ trans('error.dont_worry_explanation') }}:</p>
    <div class="">
      <a href="javascript:window.history.back()" target="_self" class="btn btn-empty u-mr10 u-mt5"><i class="ion ion-android-arrow-back ion-15x"></i></a>
      <a href="/" class="btn btn-lg btn-primary u-mr60">
        <i class="ion ion-android-home u-mr5"></i>
        {{ trans('error.homepage') }}
      </a>
    </div>
    <div style="padding-top: 10vh;">
      <p class="u-inlineblock c-bluedark">{{ trans('error.report_a_bug_text') }}:</p>
      <br />
      <a href="{{ getSupportLink() }}" class="btn btn-sm btn-quaternary u-mt10 u-opacity75" target="_blank">
        <i class="ion ion-bug u-mr5"></i>
        {{ trans('error.report_a_bug_action') }}
      </a>
    </div>
  </div>
</div>

@stop