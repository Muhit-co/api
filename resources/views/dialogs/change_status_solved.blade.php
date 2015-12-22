<dialog id="dialog_change_status_solved">

    <a href="javascript:void(0)" onclick="closeDialog();" class="u-pinned-topright u-mr30 u-ml25 u-mt25"><i class="ion ion-ios-close-empty ion-3x"></i></a>

    <form method="post" action="">
        <input type="hidden" name="issue_id" value="{{$issue_id}}">

        <div class="dialog-content">
            <div class="badge badge-circle badge-circle-xlarge u-floatleft u-mr20 u-mb30 u-ph10 u-pv20 col-sm-hide">
                <i class="ion ion-checkmark-circled ion-2x c-light" style="margin-top: 3px;"></i>
            </div>
            <h2 class="u-mr30">
                {{ trans('issues.change_status_solved') }}
            </h2>
            <p class="u-mv20">{{ trans('issues.change_status_progress_descr') }}</p>

            <div class="form-group form-fullwidth u-pl100">
                <textarea class="form-input form-grey" value="" name="comment" rows="4" placeholder="{{ trans('issues.placeholder_solvedmessage') }}"></textarea>
            </div>

        </div>

        <hr>

        <div class="u-alignright">
            <a href="javascript:void(0)" onclick="closeDialog();" class="btn btn-tertiary u-mr10">{{ trans('auth.cancel_cap') }}</a>
            <button type="submit" class="btn btn-solved">{{ trans('issues.solved_cap') }}</button>
        </div>

    </form>
    
</dialog>
