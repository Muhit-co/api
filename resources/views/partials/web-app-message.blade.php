<div id="add_home_message" class="pinned-message message u-pinned-bottomfixed c-lighter u-hidden">
  <div class="row">
    <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 u-lineheight20 u-pr45">
      <a href="javascript:void(0)" id="message_expand" class="message-expanded u-pinned-topright u-pa10" style="margin-top: -40px;">
        <div class="btn btn-circle btn-quaternary u-pr0">
          <i class="ion ion-iphone ion-15x u-floatleft u-ml5"></i><span class="u-floatleft" style="margin: -2px 0 0 2px">+</span>
        </div>
      </a>
      <a href="javascript:void(0)" id="message_close" class="message-expanded u-hidden u-pinned-topright u-pa10" style="margin-top: -20px;">
        <div class="btn btn-sm btn-circle btn-quaternary">
          <i class="ion ion-close"></i>
        </div>
      </a>
    </div>
  </div>

  <div class="row message-expanded u-hidden">
    <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 u-mv20">

      <img src="/images/app-icons/launcher-icon-3x.png" width="40px" class="u-floatleft u-mr10" />
      <strong class="u-block u-mb20" style="line-height: 16px;">{{ trans('auth.add_to_home') }}</strong>

      <div class="text-android">
        {!! trans('auth.add_to_home_explain', ['icon' => '<i class="ion ion-android-more-vertical u-mh5"></i>']) !!}
      </div>
      <div class="text-ios u-hidden">
        {!! trans('auth.add_to_home_explain', ['icon' => '<i class="ion ion-ios-upload-outline u-mh5"></i>']) !!}
      </div>

    </div>
  </div>
</div>
