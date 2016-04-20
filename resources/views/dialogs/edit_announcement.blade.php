<dialog id="dialog_edit_announcement">
    <a href="javascript:void(0)" onclick="closeDialog();" class="u-pinned-topright u-mr30 u-ml25 u-mt25"><i
                class="ion ion-ios-close-empty ion-3x"></i></a>

    <form method="post" action="/duyuru/ekle">

        <div class="dialog-content">
            <h2 class="u-mr30">
                {{ trans('issues.edit_announcement') }}
            </h2>
            <p class="u-mv20">
            </p>

            <div class="form-group form-fullwidth u-mb20">
                <input type="text" name="title" class="form-input form-grey" value="" rows="4"
                       placeholder="{{ trans('issues.title') }}"/>
            </div>

            <div class="form-group form-fullwidth">
                <textarea class="form-input form-grey" value="" rows="4" name="content"
                          placeholder="{{ trans('issues.placeholder_your_message') }}"></textarea>
            </div>
        </div>
        <hr>

        <div>
            <div class="u-floatright">
                <a href="javascript:void(0)" onclick="closeDialog();"
                   class="btn btn-tertiary u-mr10">{{ trans('auth.cancel_cap') }}</a>
                <button type="submit" class="btn btn-secondary">{{ trans('auth.send_cap') }}</button>
            </div>

            <!-- Show only for edit announcement -->
            <a href="javascript:alert('{{ trans('issues.delete_announcement_confirmation') }}')"
               class="btn btn-greytored">{{ trans('auth.delete_cap') }}</a>
        </div>
    </form>

</dialog>
