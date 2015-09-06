<dialog id="dialog_login">
    <a href="javascript:void(0)" id="closeDialog"><i class="ion ion-ios-close-empty ion-3x u-floatright u-pinned-topright u-mr30 u-mt15"></i></a>
    <div class="dialog-content">
            <h2 class="u-mb10">
                {{ trans('issues.log_in_needed') }}.
            </h2>

            <div class="u-aligncenter u-mt10">
                <a href="javascript:void(0)" onclick="closeDialog();" class="btn btn-tertiary u-ma5">{{ trans('auth.cancel_cap') }}</a>
                <a href="/login" onclick="closeDialog();" class="btn btn-secondary u-ma5">{{ trans('auth.log_in_cap') }}</a>
                <a href="/login/facebook" onclick="closeDialog();" class="btn btn-facebook u-ma5"><i class="ion ion-social-facebook ion-15x u-floatleft u-ph5"></i> <span class="u-floatleft u-mt5">{{ trans('auth.connect_cap') }}</span></a>
            </div>

            <hr />

            <i class="ion ion-person-add ion-3x u-floatleft c-light u-mr20"></i>

            <p class="u-mb10 u-pr20">
                {{ trans('issues.log_in_needed_explanation') }}.
            </p>

            <div class="u-nowrap u-aligncenter">
                <a href="/register" onclick="closeDialog();" class="btn btn-primary u-ma5">{{ trans('auth.sign_up_cap') }}</a>
                <!-- <a href="javascript:void(0)" class="btn btn-twitter u-ma5"><i class="ion ion-social-twitter u-floatleft u-pa5"></i></a>
                <a href="javascript:void(0)" class="btn btn-googleplus u-ma5"><i class="ion ion-social-googleplus u-floatleft u-pa5"></i></a> -->
            </div>
    </div>
</dialog>
