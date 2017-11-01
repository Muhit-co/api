<!-- Share buttons -->
<?php
// Build Twitter URL
$twitter_url = "http://twitter.com/share";
$twitter_url .= "?text=" . trans('issues.twitter_text', array('issue_title' => substr($issue['title'], 0, 120)));
$twitter_url .= "&url=" . Request::url();
$twitter_url .= "&hashtags=muhit";
foreach ($issue['tags'] as $tag):
  $twitter_url .= "," . strTRtoEN(strtolower($tag['name']));
endforeach;

// Build Facebook URL
$facebook_url = "http://www.facebook.com/dialog/feed";
$facebook_url .= "?app_id=" . "1458298001134890";
$facebook_url .= "&link=" . Request::url();
$facebook_url .= "&picture=";
$facebook_url .= "&name=" . $issue['title'];
$facebook_url .= "&caption=" . $issue['problem'];
$facebook_url .= "&description=" . $issue['solution'];
$facebook_url .= "&message=" . $issue['solution'];
$facebook_url .= "&redirect_uri=" . 'http://www.muhit.co';

// Build Whatsapp text
$whatsapp_text = '%22' . $issue['title'] . '%22%0A' . urlencode(Request::url());
?>

<a href="whatsapp://send?text=<?php echo $whatsapp_text; ?>" id="whatsapp_share_button" class="btn btn-secondary btn-whatsapp u-hidden"><i class="ion ion-social-whatsapp"></i></a>
<a href="<?php echo $twitter_url; ?>" id="twitter_share_button" class="btn btn-secondary btn-twitter" target="_blank"><i class="ion ion-social-twitter"></i></a>
<a href="<?php echo $facebook_url; ?>" id="facebook_share_button" class="btn btn-secondary btn-facebook" target="_blank"><i class="ion ion-social-facebook ion-15x"></i></a>

<!-- (Un)Support button -->
<?php
// var_dump(Auth::user()->id);
$supportable_roles = ['user', 'superadmin'];
$supportable = (in_array($role, $supportable_roles) && Auth::user()->id !== $issue['user_id']) ? true : false;
$actionable = ($role =='admin' && isset(Auth::user()->hood_id) && $issue['hood_id'] == Auth::user()->hood_id) ? true : false;
if ($role == 'municipality-admin' && $user_district_id == $issue['district_id']) {
    $actionable = true;
}
?>
@if($role =='public' && $issue['status'] != "solved")
    <a href="javascript:void(0)" data-dialog="dialog_login" class="btn btn-secondary u-ml5"><i class="ion ion-thumbsup"></i> {{ trans('issues.support_cap') }}</a>
@elseif($supportable == true && $issue['status'] != "solved")
    @if($issue['is_supported'] == 1)
        <a href="/unsupport/{{$issue['id']}}" class="btn btn-tertiary u-ml5 u-has-hidden-content">
            <i class="ion ion-fw ion-thumbsup u-hide-on-hover"></i>
            <i class="ion ion-fw ion-close u-show-on-hover"></i>
            <span class="extended">{{ trans('issues.supported_cap') }}</span>
            <span class="condensed"><i class="ion ion-checkmark"></i></span>
        </a>
    @else
        <a id="action_support" href="/support/{{$issue['id']}}" class="btn btn-secondary u-ml5"><i class="ion ion-thumbsup"></i> {{ trans('issues.support_cap') }}</a>
    @endif
@elseif($actionable == true)
    <!-- Action button for Muhtar -->
    <div class="hasDropdown u-inlineblock u-ml5">
        <a href="javascript:void(0)" class="btn btn-secondary">{{ trans('issues.take_action_cap') }} <i class="ion ion-chevron-down u-ml5"></i></a>
        <div class="dropdown dropdown-outline">
            <ul>
                <li><a href="javascript:void(0)" data-dialog="dialog_write_comment"><i class="ion ion-chatboxes u-mr5"></i> {{ trans('issues.write_comment') }}...</a></li>
                @if($issue['status'] != "solved")
                {{-- <li><a href="javascript:void(0)" data-dialog="dialog_come_drink_tea"><i class="ion ion-muhit-tea u-mr5"></i> {{ trans('issues.come_drink_tea') }}...</a></li> --}}
                <li><a href="javascript:void(0)" data-dialog="dialog_change_status_progress"><i class="ion ion-wrench u-mr5"></i> {{ trans('issues.in_progress') }}...</a></li>
                <li><a href="javascript:void(0)" data-dialog="dialog_change_status_solved"><i class="ion ion-checkmark-circled u-mr5"></i> {{ trans('issues.solved') }}...</a></li>
                @endif
            </ul>
        </div>
    </div>
@endif