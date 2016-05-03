{{-- An edit announcement dialog requires a parameter $announcement --}}

@if(isset($announcement))

    <dialog id="dialog_edit_announcement_{{ $announcement->id }}">
        <a href="javascript:void(0)" onclick="closeDialog();" class="u-pinned-topright u-mr30 u-ml25 u-mt25"><i
                    class="ion ion-ios-close-empty ion-3x"></i></a>

        <form method="post" id="editAnnouncement1" action="/duyuru/duzenle/{{ $announcement->id }}">

            <div class="dialog-content">
                <h2 class="u-mr30">
                    {{ trans('issues.edit_announcement') }}
                </h2>
                <p class="u-mv20">
                </p>

                <div class="form-group form-fullwidth u-mb20">
                    <input type="text" name="title" id="title" class="form-input form-grey"
                           value="{{ $announcement->title }}"
                           rows="4"
                           placeholder="{{ trans('issues.title') }}"/>
                </div>

                <div class="form-group form-fullwidth">
                    <textarea class="form-input form-grey" rows="4" name="content" id="content"
                              placeholder="{{ trans('issues.placeholder_your_message') }}">{{ $announcement->content }}</textarea>
                </div>
            </div>
            <hr>

            <div>
                <div class="u-floatright">
                    <a href="javascript:void(0)" onclick="closeDialog();"
                       class="btn btn-tertiary u-mr10">{{ trans('auth.cancel_cap') }}</a>
                    <button type="submit" class="btn btn-secondary direct-submit">{{ trans('auth.send_cap') }}</button>
                </div>

                <a href="javascript:alert('{{ trans('issues.delete_announcement_confirmation') }}')"
                   class="btn btn-greytored">{{ trans('auth.delete_cap') }}</a>
            </div>
        </form>

    </dialog>

@endif
