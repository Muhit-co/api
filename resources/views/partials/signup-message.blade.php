
@if ($role == 'public')
  <div class="u-pinned-bottomfixed bg-blueDark75 u-pv20" style="z-index: 3;">
    <div class="row">
      <div class="col-xs-12 u-pb20">
        <a href="javascript:void(0)" id="message_close" class="u-floatright u-pv5 u-ph15">
          <i class="ion ion-close c-white"></i>
        </a>
        <h3 class="u-ph15 c-white">Join the conversation? <span class="u-opacity75">Sign up to vote and create ideas.</span></h3>
      </div>
      <div class="col-sm-12">
        <form method="post" action="/register" class="row">

          <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="form-group form-fullwidth u-mb10">
              <input type="text" class="form-input" name="first_name" value="{{ Input::old('first_name') }}" placeholder="{{ trans('auth.first_name_placeholder') }}" required />
            </div>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="form-group form-fullwidth u-mb10">
              <input type="text" class="form-input" name="last_name" value="{{ Input::old('last_name') }}"  placeholder="{{ trans('auth.last_name_placeholder') }}" required />
            </div>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="form-group form-fullwidth u-mb10">
              <input type="email" class="form-input" name="email" value="{{ Input::old('email') }}" placeholder="{{ trans('auth.email_address_placeholder') }}" required />
            </div>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="form-group form-fullwidth u-mb10">
              <input type="password" class="form-input" name="password" value="{{ Input::old('password') }}"  placeholder="{{ trans('auth.password_placeholder') }}" required />
            </div>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-6" style="margin-bottom: -10px;">
            <div class="c-blue">@include('partials.field-hood')</div>
          </div>

          <div class="form-group form-fullwidth u-mt30 u-mb20 u-hidden">
          </div>

          <div class="col-md-2 col-sm-4 col-xs-6">
            <button type="submit" class="btn btn-primary u-floatright">KAYIT OL</i></button>
            <div class="hasTooltip u-relative u-inlineblock u-mt10">
              <input id="termsagree" type="checkbox" class="form-input u-floatleft u-mr20" value="" name="user.agree" required />
              <label for="termsagree" class="c-white"></label>
              <span class="tooltip tooltip-alignright tooltip-solid u-width300 u-mr5 u-nowrap">
                {!! trans('auth.agree_with_terms', ['tagstart' => '<a href="http://hikaye.muhit.co/kullanim-kosullari" target="_blank">', 'tagend' => '</a>']) !!}
              </span>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endif
