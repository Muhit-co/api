<dialog id="dialog_edit_comment" class="u-width600">

    <a href="javascript:void(0)" onclick="closeDialog();" class="u-pinned-topright u-mr30 u-ml25 u-mt25"><i class="ion ion-ios-close-empty ion-3x"></i></a>

    <form method="post" action="/muhtar/edit-comment/">
        <div class="dialog-content">
            <h2 class="u-mr30 u-mb10">
                {{ trans('issues.edit_comment') }}
            </h2>

            <div class="form-group form-fullwidth u-mb0">
                <textarea class="form-input form-grey" value="" name="comment" rows="4" placeholder="{{ trans('issues.placeholder_yourmessage') }}" required></textarea>
            </div>
        </div>

        <hr>

        <div class="u-alignright">
            <a id="comment_delete" href="/muhtar/delete-comment/" onclick="return confirm('{{trans('issues.delete_comment_confirmation')}}'); closeDialog();" class="btn btn-greytored btn-busyOnClick u-mr10 u-floatleft">{{ trans('auth.delete_cap') }}</a>
            <a href="javascript:void(0)" onclick="closeDialog();" class="btn btn-tertiary u-mr10">{{ trans('auth.cancel_cap') }}</a>
            <button type="submit" class="btn btn-secondary">{{ trans('auth.save_cap') }}</button>
        </div>

    </form>

</dialog>
