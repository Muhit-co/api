@extends('layouts.default')
@section('content')
@section('dialogs')
    @if($role =='admin')
        @include('dialogs.write_comment')
        @include('dialogs.come_drink_tea')
        @include('dialogs.change_status_progress')
        @include('dialogs.change_status_solved')
        @include('dialogs.report', ['issue_id' => $issue['id']])
    @endif
@stop

@include('partials.header', array('type'=>'show'))

<section>
    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <?php
            $issue_supporters = (int) Redis::get('supporter_counter:'.$issue['id']);
            $issue_status = getIssueStatus($issue['status'], $issue_supporters);
            ?>

            <div class="card card-issue">
                <div class="card-header u-clearfix u-pv15">
                    <div class="u-floatleft">
                        <a href="/" class="u-mr20"><i class="ion ion-android-arrow-back ion-2x"></i></a>
                    </div>
                    <div class="u-floatright u-clearfix">

                        <!-- Share buttons -->
                        <?php
                        // @gcg what is a good location for this function?s

                        function str_trtoeng($source) {
                            $turkish = array("Ü", "Ş", "Ğ", "Ç", "İ", "Ö", "ü", "ş", "ç", "ı", "ö", "ğ"); // turkish letters
                            $english   = array("U", "S", "G", "C", "I", "O", "u", "s", "c", "i", "o", "g"); // corresponding english letters
                            $result = str_replace($turkish, $english, $source); //replace php function
                            return $result;
                        }

                        $twitter_url = "http://twitter.com/share";
                        $twitter_url .= "?text=" . trans('issues.twitter_text', array('issue_title' => substr($issue['title'], 0, 120)) );
                        $twitter_url .= "&url=" . Request::url();
                        $twitter_url .= "&hashtags=muhit";
                        foreach($issue['tags'] as $tag):
                            $twitter_url .= "," . str_trtoeng(strtolower($tag['name']));
                        endforeach;
                        $facebook_url = "http://www.facebook.com/dialog/feed";
                        $facebook_url .= "?app_id=" . "1458298001134890";
                        $facebook_url .= "?link=" . Request::url();
                        $facebook_url .= "?picture=";
                        $facebook_url .= "?name=" . $issue['title'];
                        $facebook_url .= "?caption=" . $issue['title'];
                        $facebook_url .= "?description=" . $issue['problem'];
                        $facebook_url .= "?message=" . $issue['problem'];
                        $facebook_url .= "?redirect_uri" . Request::url();

                        ?>
                        <a href="<?php echo $twitter_url ?>" class="btn btn-secondary btn-twitter share u-ml5 u-width50" target="_blank"><i class="ion ion-social-twitter"></i></a>
                        <a href="<?php echo $facebook_url ?>" class="btn btn-secondary btn-facebook share u-ml5 u-width50" target="_blank"><i class="ion ion-social-facebook ion-15x"></i></a>

                        <!-- (Un)Support button -->
                        @if($role =='public' && $issue['status'] != "solved")
                        <a href="javascript:void(0)" data-dialog="dialog_login" class="btn btn-secondary u-ml5"><i class="ion ion-thumbsup"></i> {{ trans('issues.support_cap') }}</a>
                        @elseif($role =='user')
                        <a id="action_support" href="/issues/support/{{$issue['id']}}" class="btn btn-secondary u-ml5"><i class="ion ion-thumbsup"></i> {{ trans('issues.support_cap') }}</a>
                        <a id="action_unsupport" href="javascript:void(0)" class="btn btn-tertiary u-ml5 u-hidden u-has-hidden-content">
                            <i class="ion ion-fw ion-thumbsup u-hide-on-hover"></i>
                            <i class="ion ion-fw ion-close u-show-on-hover"></i>
                            {{ trans('issues.supported_cap') }}
                        </a>
                        @elseif($role =='admin')
                        <!-- Action button for Muhtar -->
                        <div class="hasDropdown u-inlineblock u-ml5">
                            <a href="javascript:void(0)" class="btn btn-secondary">{{ trans('issues.take_action_cap') }} <i class="ion ion-chevron-down u-ml5"></i></a>
                            <div class="dropdown dropdown-outline">
                                <ul>
                                    @if($issue['status'] != "solved")
                                    <li><a href="javascript:void(0)" data-dialog="dialog_come_drink_tea"><i class="ion ion-muhit-tea u-mr5"></i> {{ trans('issues.come_drink_tea') }}...</a></li>
                                    <li><a href="javascript:void(0)" data-dialog="dialog_change_status_progress"><i class="ion ion-wrench u-mr5"></i> {{ trans('issues.in_progress') }}...</a></li>
                                    <li><a href="javascript:void(0)" data-dialog="dialog_change_status_solved"><i class="ion ion-checkmark-circled u-mr5"></i> {{ trans('issues.solved') }}...</a></li>
                                    @endif
                                    <li><a href="javascript:void(0)" data-dialog="dialog_write_comment"><i class="ion ion-chatboxes u-mr5"></i> {{ trans('issues.write_comment') }}...</a></li>
                                </ul>
                            </div>
                        </div>
                        @endif

                    </div>
                    <span class="title u-inlineblock u-mt5">{{$issue['location']}}</span>
                </div>
                <div class="card-content">

                    <div class="u-floatright u-relative">
                        <div class="label label-{{$issue_status['class']}} u-pr80 u-mr10">
                            <i class="ion {{$issue_status['icon']}}"></i>
                            <span class="text">{{$issue_status['title']}}</span>
                        </div>
                        <div id="support_counter" class="badge badge-circle-large badge-support badge-{{$issue_status['class']}} u-pinned-topright u-pt15" style="margin-top: -15px;">
                            <div class="value">{{ $issue_supporters }}</div>
                            <label>DESTEKÇİ</label>
                        </div>
                    </div>

                    <h3 class="u-mh5 u-mv10">
                        {{$issue['title']}}
                    </h3>

                    <div class="row row-nopadding media u-mv20">
                        <div class="media-image col-md-8">

                            <div id="slides">
                                <?php $numimages = count($issue['images']); ?>

                                @if($numimages == 0)
                                    <div class="bg-lightest u-pa50 u-aligncenter">
                                        <i class="ion ion-image ion-4x c-lighter"></i>
                                        <p class="c-light"><strong>{{ trans('issues.no_images_present') }}</strong></p>
                                    </div>
                                @elseif($numimages >= 1)
                                    @foreach($issue['images'] as $image)
                                        <img src="//d1vwk06lzcci1w.cloudfront.net/600x300/{{$image['image']}}" alt="{{$issue['title']}}" />
                                    @endforeach
                                @endif

                                @if($numimages > 1)
                                    <script>
                                        $(function(){
                                            $("#slides").slidesjs({
                                                width: 500,
                                                height: 300,
                                            });
                                        });
                                    </script>
                                @endif

                            </div>

                        </div>
                        <div class="media-map col-md-4">
                            <?php
                                $lon = ((!empty($issue['coordinates'])) ? trim(explode(",", $issue['coordinates'])[0]) : 0);
                                $lan = ((!empty($issue['coordinates'])) ? trim(explode(",", $issue['coordinates'])[1]) : 0);
                            ?>
                            <div id="map-canvas">
                            </div>
                            <script>
                                mapInitializeForIssue({{$lon}}, {{$lan}});
                            </script>
                        </div>
                    </div>

                    <div class="row row-nopadding u-mv20">
                        <div class="col-md-10">
                                @foreach($issue['tags'] as $tag)
                                        <span class="tag u-mv5 u-mr10" style="background-color:#{{$tag['background']}}">{{$tag['name']}}</span>
                                @endforeach
                        </div>
                        <div class="col-md-2 u-alignright">
                            <label class="c-light"><i class="ion ion-android-calendar u-mr5"></i>{{ date('j M Y', strtotime($issue['created_at'])) }}</label>
                        </div>
                    </div>

                    <div class="problem u-mb20">
                        <h4 class="c-light">{{ trans('issues.problem') }}</h4>
                        <p>{{$issue['problem']}}</p>
                    </div>
                    <div class="solution u-mb5">
                        <h4 class="c-light">{{ trans('issues.solution') }}</h4>
                        <p>{{$issue['solution']}}</p>
                    </div>
                </div>
                <!--
                <div class="card-footer clearfix">
                    <h3 class="c-blue u-mb10">{{ trans('issues.comments_from_muhtar') }}</h3>
                    <div class="comment u-ph20">
                        <h4 class="title">
                            <div class="u-floatright">
                                <small>{{ date('j M Y', strtotime($issue['created_at'])) }}</small>
                            </div>
                            Comment title
                        </h4>
                        <p>
                            <em>
                                Lorem ipsum...
                            </em>
                        </p>
                    </div>
                </div>
                -->

                <div class="card-footer u-clearfix">
                    <div class="u-floatright">
                        @if(Auth::check() and (Auth::user()->id == $issue['user_id'] or Auth::user()->level > 5))
                            @if($issue_supporters < 10)
                                <a href="/issues/delete/{{$issue['id']}}" class="btn btn-tertiary btn-greytored u-ml10" onclick="return confirm('Bu fikri silmek istediğinizden emin misiniz?');"><i class="ion ion-trash-b u-mr5"></i> SİL</a>
                            @else
                                <span class="hasTooltip u-ml10">
                                    <a href="javascript:void(0)" class="btn" disabled><i class="ion ion-trash-b u-mr5"></i> SİL</a>
                                    <span class="tooltip tooltip-alignright u-mr20">
                                        <i class="ion ion-information-circled ion-15x u-floatleft u-mv10 u-mr10"></i>
                                        <div class="u-ml30">{{ trans('issues.delete_restricted_supporters_tooltip') }}.</div>
                                    </span>
                                </span>
                            @endif
                        @else
                            <span class="hasTooltip u-ml10">
                                <a href="javascript:void(0)" data-dialog="dialog_report" class="btn btn-tertiary"><i class="ion ion-alert-circled"></i></a>
                                <span class="tooltip tooltip-alignright u-width300 u-mr5">
                                    <i class="ion ion-alert-circled ion-15x u-floatleft u-mv10 u-mr10"></i>
                                    <div class="u-ml30">{{ trans('issues.report_issue_tooltip') }}.</div>
                                </span>
                            </span>
                        @endif
                    </div>
                    <ul class="issue-history title">

                        @foreach($issue['updates'] as $update)
                            <li>
                                <i class="ion ion-record u-mr10"></i>
                                <span class="date">{{date('d M Y', strtotime($update['created_at']))}}</span> –
                                <strong>{{ trans('issues.issue_status_' . $update['new_status']) }}</strong>.
                            </li>
                        @endforeach

                    </ul>
                </div>

            </div>

        </div>

    </div>
</section>

@stop
