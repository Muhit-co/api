<dialog id="dialog_login">
    <a href="javascript:void(0)" id="closeDialog"><i class="ion ion-ios-close-empty ion-3x u-floatright u-pinned-topright u-mr30 u-mt15"></i></a>
    <div class="dialog-content">
            <h2 class="u-mb10">
                {{ trans('issues.log_in_needed') }}.
            </h2>

            <div class="form-group form-fullwidth">
                <input type="text" class="form-input form-grey" name="email" value="" placeholder="{{ trans('auth.email_address') }}" />
            </div>

            <div class="form-group form-fullwidth">
                <input type="password" class="form-input form-grey" value="" placeholder="{{ trans('auth.password') }}" name="password" />
            </div>

            <div class="u-alignright u-mt10">
                <a href="javascript:void(0)" id="closeDialog" class="btn btn-tertiary u-mr10">{{ trans('auth.cancel_cap') }}</a>
                <a href="javascript:void(0)" class="btn btn-secondary">{{ trans('auth.log_in_cap') }}</a>
            </div>

            <hr />

            <i class="ion ion-person-add ion-3x u-floatleft c-light u-mr20"></i>

            <p class="u-mb10 u-pr20">
                {{ trans('issues.log_in_needed_explanation') }}.
            </p>

            <div class="u-nowrap u-aligncenter">
                <a href="javascript:void(0)" class="btn btn-primary u-ma5">{{ trans('auth.sign_up_cap') }}</a>
                <a href="javascript:void(0)" class="btn btn-facebook u-ma5"><i class="ion ion-social-facebook ion-15x u-floatleft u-ph5"></i></a>
                <a href="javascript:void(0)" class="btn btn-twitter u-ma5"><i class="ion ion-social-twitter u-floatleft u-pa5"></i></a>
                <a href="javascript:void(0)" class="btn btn-googleplus u-ma5"><i class="ion ion-social-googleplus u-floatleft u-pa5"></i></a>
            </div>
    </div>
</dialog>
