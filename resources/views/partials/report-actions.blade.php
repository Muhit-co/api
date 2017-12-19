{{-- Report Actions --}}

<div class="form-group hasIconRight u-relative u-mr10">
    <select class="form-input form-outline u-pr20">
        <option selected>{{ trans('issues.all') }}</option>
        {{-- // NB. TEMPORARY! Should be last 12 months  --}}
        <option>{{strftime('%B %Y', strtotime("10/01/2017"))}}</option>
        <option>{{strftime('%B %Y', strtotime("09/01/2017"))}}</option>
        <option>{{strftime('%B %Y', strtotime("08/01/2017"))}}</option>
        <option>{{strftime('%B %Y', strtotime("07/01/2017"))}}</option>
        <option>{{strftime('%B %Y', strtotime("06/01/2017"))}}</option>
        <option>{{strftime('%B %Y', strtotime("05/01/2017"))}}</option>
        <option>{{strftime('%B %Y', strtotime("04/01/2017"))}}</option>
        <option>{{strftime('%B %Y', strtotime("03/01/2017"))}}</option>
        <option>{{strftime('%B %Y', strtotime("02/01/2017"))}}</option>
        <option>{{strftime('%B %Y', strtotime("01/01/2017"))}}</option>
        <option>{{strftime('%B %Y', strtotime("12/01/2016"))}}</option>
        <option>{{strftime('%B %Y', strtotime("11/01/2016"))}}</option>
    </select>
    <div class="form-appendRight u-aligncenter u-width30 u-pr15 u-mt5">
        <i class="ion ion-chevron-down"></i>
    </div>
</div>

<?php
$title = $district->name . ' ' . trans('reports.municipality_report');

// Build Twitter URL
$twitter_url = "http://twitter.com/share";
$twitter_url .= "?text=" . trans('issues.twitter_text', array('issue_title' => $title));
$twitter_url .= "&url=" . Request::url();
$twitter_url .= "&hashtags=muhit";

// Build Facebook URL
$facebook_url = "http://www.facebook.com/dialog/feed";
$facebook_url .= "?app_id=" . "1458298001134890";
$facebook_url .= "&link=" . Request::url();
$facebook_url .= "&picture=";
$facebook_url .= "&name=" . $title;
$facebook_url .= "&caption=Muhit";
$facebook_url .= "&description=" . $title;
$facebook_url .= "&message=" . $title;
$facebook_url .= "&redirect_uri=" . 'http://www.muhit.co';

// Build Whatsapp text
$whatsapp_text = '%22' . $title . '%22%0A' . urlencode(Request::url());
?>

<a href="javascript:window.print();" class="btn btn-blueempty u-ph10 u-nowrap no-print" style="min-width: 3.5rem;">
    <i class="ion ion-document ion-15x"></i>
    <i class="ion ion-ios-arrow-thin-down ion-15x"></i>
</a>
<div class="hasDropdown u-inlineblock u-ml5 no-print">
    <a href="javascript:void(0)" class="btn btn-blueempty">
        <i class="ion ion-android-share-alt ion-15x"></i>
    </a>
    <div class="dropdown dropdown-outline dropdown-onright">
        <ul>
            <li>
                <a href="whatsapp://send?text=<?php echo $whatsapp_text; ?>" id="whatsapp_share_button" class="u-hidden">
                    <i class="ion ion-social-whatsapp"></i>
                    WhatsApp
                </a>
            </li>
            <li>
                <a href="<?php echo $twitter_url; ?>" id="twitter_share_button" target="_blank">
                    <i class="ion ion-social-twitter"></i>
                    Twitter
                </a>
            </li>
            <li>
                <a href="<?php echo $facebook_url; ?>" id="facebook_share_button" target="_blank">
                    <i class="ion ion-social-facebook ion-15x" style="width: 1rem;"></i>
                    Facebook
                </a>
            </li>
        </ul>
    </div>
</div>
