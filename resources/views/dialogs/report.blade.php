<dialog id="dialog_report">
    <a href="javascript:void(0)" onclick="closeDialog();" class="u-pinned-topright u-mr30 u-ml25 u-mt25"><i class="ion ion-ios-close-empty ion-3x"></i></a>
    <div class="dialog-content">
        <h2 class="u-mr30">
            {{ trans('issues.problems_or_suggestions') }}.
        </h2>
        <p class="u-mv20">{{ trans('issues.experience_problems_report_well_get_back_to_you') }}</p>

        <div class="form-group form-fullwidth">
            <!-- <label>Adınız</label> -->
            <textarea class="form-input form-grey" value="" rows="4" placeholder="Yazin..."></textarea>
        </div>
    </div>

    <hr>

    <div class="u-alignright">
        <a href="javascript:void(0)" id="closeDialog" class="btn btn-tertiary u-mr10">{{ trans('auth.cancel_cap') }}</a>
        <a href="javascript:void(0)" class="btn btn-secondary">{{ trans('auth.send_cap') }}</a>
    </div>
</dialog>
