<div id="add_home_message" class="pinned-message message u-pinned-bottomfixed c-lighter u-pv10 u-hidden">
  <div class="row">
    <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 u-lineheight20 u-pr45">
      <a href="javascript:void(0)" id="message_close" class="u-pinned-topright u-pa10" style="margin-top: -30px;">
        <div class="btn btn-sm btn-circle btn-quaternary">
          <i class="ion ion-close"></i>
        </div>
      </a>
      <a href="javascript:void(0)" id="message_expand" class="u-inlineblock c-white">
        <img src="/images/app-icons/launcher-icon-3x.png" width="40px" class="u-floatleft u-mr10" />
        <small>{{ trans('auth.add_to_home') }} <span class="btn btn-sm btn-whiteoutline u-lineheight10 u-ml10" style="paddiing: 3px 0; height: auto;"><i class="ion ion-plus"></i></span></small>
      </a>
    </div>
  </div>

  <div class="row message-expanded u-hidden">
    <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 u-mb10">

      <hr class="subtle" />

      <div class="text-android u-hidden">
        {!! trans('auth.add_to_home_explain', ['icon' => '<i class="ion ion-android-more-vertical ion-15x u-mh5"></i>']) !!}
      </div>
      <div class="text-ios">
        {!! trans('auth.add_to_home_explain', ['icon' => '<i class="ion ion-ios-upload-outline ion-15x u-mh5"></i>']) !!}
      </div>

    </div>
  </div>
</div>
