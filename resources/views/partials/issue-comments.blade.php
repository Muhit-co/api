<?php
function commentIsEditable($comment, $issue, $role) {
    $commentIsEditable = false;
    $isOwnComment = (Auth::check() && Auth::user()->id == $comment['muhtar']['id']) ? true : false;

    // Allow editing/removing of comments if Admin and if Own Comment
    if($role == 'admin' && $isOwnComment == true) { $commentIsEditable = true; }
    // Allow editing/removing of comments if Superadmin
    if($role == 'superadmin') { $commentIsEditable = true; }

    return $commentIsEditable;
}
?>

{{-- Comments start --}}
<div class="clearfix u-mb50">

    <h4 class="c-medium">{{ trans('issues.comments') }}</h4>

    @if(!empty($issue['comments']))

        @foreach($issue['comments'] as $comment)
            <?php $isOwnIssue = (Auth::check() and Auth::user()->id == $comment['muhtar']['id']) ? true : false; ?>
            <div class="comment {!! ($isOwnIssue) ? 'comment-opposite' : '' !!}" id="comment-{{ $comment['id'] }}">
                <div class="u-floatright c-medium u-lineheight20">
                    <small>{{ strftime('%d %h %Y – %k:%M', strtotime($comment['created_at'])) }}</small>
                    @if(commentIsEditable($comment, $issue, $role) == true)
                        <a data-dialog="dialog_edit_comment" data-comment-id="{{$comment['id']}}" class="btn btn-sm btn-subtle u-ml5" onclick="dialogCommentEditData($(this));" style="margin: -4px -8px 0 0;">
                            <i class="ion ion-edit"></i>
                        </a>
                    @endif
                </div>

                <p class="u-lineheight20">
                    <strong {!! ($isOwnIssue) ? 'class="c-blue"' : '' !!}>
                        {{ $comment['muhtar']['first_name'] }} {{ $comment['muhtar']['last_name'] }}
                    </strong>
                    <span class="{!! ($isOwnIssue) ? 'c-darkblue' : 'c-medium' !!}">
                        @if($comment['muhtar']['level'] == 5 and !empty($comment['muhtar']['location']))
                            ( {{ explode(',', $comment['muhtar']['location'])[0] }} muhtarı)
                        @endif
                    </span>
                </p>
                <p class="u-mt5"><em class="comment-message" data-comment="{{$comment['comment']}}">
                    {!! linkifyText($comment['comment']) !!}
                </em></p>
            </div>
        @endforeach

    @endif

    <div class="comment comment-opposite {!! (!empty($issue['comments'])) ? 'u-mt30' : '' !!}">
        @if(Auth::check())
            <form class="u-mv5" method="post" action="/comments/comment">
                <input type="hidden" name="issue_id" value="{{ $issue['id'] }}">
                <div class="form-group form-fullwidth">
                    <textarea class="form-input form-grey" value="" name="comment" rows="4" placeholder="{{ trans('issues.placeholder_your_message') }}" required></textarea>
                </div>

                <div class="u-alignright">
                    <button type="submit" class="btn btn-secondary">{{ trans('auth.send_cap') }}</button>
                </div>

            </form>
        @else
            <div class="u-mt5 u-aligncenter c-light">
                <div class="form-group form-fullwidth u-mb0" onclick="openDialog('dialog_login');">
                    <textarea class="form-input" value="" name="comment" rows="3" disabled="disabled" placeholder="{{ trans('issues.placeholder_your_message') }}" style="cursor: text;"></textarea>
                </div>

                <div class="u-alignright">
                    <div class="btn btn-secondary btn-disabled u-opacity50" disabled onclick="openDialog('dialog_login');">{{ trans('auth.send_cap') }}</div>
                </div>
            </div>
        @endif
    </div>

</div>
{{-- Comments end --}}
