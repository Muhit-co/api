@extends('layouts.default')
@section('content')
@section('dialogs')
    @if($role =='admin')
        @include('dialogs.write_comment', ['issue_id' => $issue['id']])
        @include('dialogs.edit_comment', ['issue_id' => $issue['id']])
        @include('dialogs.come_drink_tea', ['issue_id' => $issue['id']])
        @include('dialogs.change_status_progress', ['issue_id' => $issue['id']])
        @include('dialogs.change_status_solved', ['issue_id' => $issue['id']])
    @endif
@stop

@include('partials.header', array('type'=>'show'))

<?php setlocale(LC_TIME, 'tr_TR.utf8', 'tr_TR.UTF-8', 'tr_TR');?>

<section>
    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <?php
            $issue_supporters = (int) Redis::get('supporter_counter:' . $issue['id']);
            $issue_status = getIssueStatus($issue['status'], $issue_supporters);
            ?>

            <div class="card card-issue">
                <div class="card-header u-clearfix u-pv15">
                    <div class="u-floatright u-clearfix">

                        <!-- Share buttons -->
                        <?php
                        $twitter_url = "http://twitter.com/share";
                        $twitter_url .= "?text=" . trans('issues.twitter_text', array('issue_title' => substr($issue['title'], 0, 120)));
                        $twitter_url .= "&url=" . Request::url();
                        $twitter_url .= "&hashtags=muhit";
                        foreach ($issue['tags'] as $tag):
                        	$twitter_url .= "," . strTRtoEN(strtolower($tag['name']));
                        endforeach;
                        $facebook_url = "http://www.facebook.com/dialog/feed";
                        $facebook_url .= "?app_id=" . "1458298001134890";
                        $facebook_url .= "&link=" . Request::url();
                        $facebook_url .= "&picture=";
                        $facebook_url .= "&name=" . $issue['title'];
                        $facebook_url .= "&caption=" . $issue['problem'];
                        $facebook_url .= "&description=" . $issue['solution'];
                        $facebook_url .= "&message=" . $issue['solution'];
                        $facebook_url .= "&redirect_uri=" . 'http://www.muhit.co';
                        ?>
                        <a href="<?php echo $twitter_url ?>" class="btn btn-secondary btn-twitter u-width40" target="_blank"><i class="ion ion-social-twitter"></i></a>
                        <a href="<?php echo $facebook_url ?>" class="btn btn-secondary btn-facebook u-width40 u-ml5" target="_blank"><i class="ion ion-social-facebook ion-15x"></i></a>

                        <!-- (Un)Support button -->
                        @if($role =='public' && $issue['status'] != "solved")
                        <a href="javascript:void(0)" data-dialog="dialog_login" class="btn btn-secondary u-ml5"><i class="ion ion-thumbsup"></i> {{ trans('issues.support_cap') }}</a>
                        @elseif($role =='user' || $role =='superadmin')
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
                        @elseif($role =='admin' && isset(Auth::user()->hood_id) && $issue['hood_id'] == Auth::user()->hood_id)
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

                    </div>
                    <a href="javascript:window.history.back()" class="u-floatleft u-mr15"><i class="ion ion-android-arrow-back ion-2x"></i></a>
                    <span class="title u-inlineblock u-mt5">{{$issue['location']}}</span>
                </div>
                <div class="card-content">

                    <div class="u-floatright u-relative">
                        <div class="label label-{{$issue_status['class']}} u-pr80 u-mr10">
                            <i class="ion {{$issue_status['icon']}}"></i>
                            <span class="text extended">{{$issue_status['title']}}</span>
                        </div>
                        <div id="support_counter" class="badge badge-circle-xlarge badge-support badge-{{$issue_status['class']}} u-pinned-topright u-pt15" style="margin-top: -15px;">
                            <div class="value">{{ $issue_supporters }}</div>
                            <label>DESTEKÇİ</label>
                        </div>
                    </div>

                    <h3 class="u-mh5 u-mv10">
                        {{$issue['title']}}
                    </h3>


                    <?php
                    // map longitude & latitude, and hide if no information
                    $lon = ((!empty($issue['coordinates'])) ? trim(explode(",", $issue['coordinates'])[0]) : 0);
                    $lat = ((!empty($issue['coordinates'])) ? trim(explode(",", $issue['coordinates'])[1]) : 0);
                    $showmap = ($lon > 0 && $lat > 0) ? true : false;

                    $numimages = count($issue['images']);
                    $imagecol = ($numimages == 0) ? 'col-xs-4 extended' : 'col-sm-8';
                    $mapcol = ($numimages == 0) ? 'col-sm-8 compact' : 'col-sm-4';
                    ?>


                    <div class="row row-nopadding media u-mv20">
                        <div class="media-images {{ $imagecol }}">

                            <div id="slides">
                                <?php ;?>

                                @if($numimages == 0)
                                    <div class="bg-lightest u-pa30 u-aligncenter">
                                        <i class="ion ion-image ion-4x c-lighter"></i>
                                        <div class="c-light"><strong>{{ trans('issues.no_images_present') }}</strong></div>
                                    </div>
                                @elseif($numimages >= 1)
                                    @foreach($issue['images'] as $image)
                                        <div style="height: 100%;">
                                            <div class="media-image" style="background-image: url('//d1vwk06lzcci1w.cloudfront.net/600x300/{{$image['image']}}')" title="{{$issue['title']}}"></div>
                                        </div>
                                    @endforeach
                                @endif

                            </div>

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
                        @if($showmap)
                        <div class="media-map {{ $mapcol }}" data-status="">
                            <div id="map-canvas">
                            </div>
                            <script>
                                mapInitializeForIssue({{$lon}}, {{$lat}}, '{{$issue['status']}}');
                            </script>
                        </div>
                        @endif
                    </div>

                    <div class="row row-nopadding u-mv10">
                        <div class="col-md-9">
                                @foreach($issue['tags'] as $tag)
                                        <span class="tag u-mv5 u-mr10" style="background-color:#{{$tag['background']}}">{{$tag['name']}}</span>
                                @endforeach
                        </div>
                        <div class="col-md-3 u-alignright">
                            <label class="c-light u-mt10"><i class="ion ion-android-calendar u-mr5"></i>{{ strftime('%d %B %Y', strtotime($issue['created_at'])) }}</label>
                        </div>
                    </div>

                    @if(strlen($issue['problem']) > 0)
                    <div class="problem u-mb20">
                        <h4 class="c-light">{{ trans('issues.problem') }}</h4>
                        <p>{{$issue['problem']}}</p>
                    </div>
                    @endif
                    @if(strlen($issue['solution']) > 0)
                    <div class="solution u-mb5">
                        <h4 class="c-light">{{ trans('issues.solution') }}</h4>
                        <p>{{$issue['solution']}}</p>
                    </div>
                    @endif

                    <div class="u-clearfix u-mt20">
                        @if($issue['is_anonymous'] == 0)
                            <div class="badge badge-circle badge-user u-floatleft u-mr10">
                                <img src="//d1vwk06lzcci1w.cloudfront.net/40x40/{{$issue['user']['picture']}}" alt="{{$issue['user']['first_name']}}" />
                            </div>
                            <div class="c-light u-pt5">
                                {{$issue['user']['first_name']}} {{$issue['user']['last_name']}}
                            </div>
                        @else
                            <small class="c-light"><em>{{ trans('issues.submitted_anonymously') }}</em></small>
                        @endif
                    </div>

                </div>

                @if(!empty($issue['comments']))

                    <div class="card-footer clearfix">

                        <h4>Muhtardan gelen yorumlar</h4>

                        @foreach($issue['comments'] as $comment)
                            <div class="comment" id="comment-{{ $comment['id'] }}">
                                <div class="u-floatright c-medium">
                                    <small>{{ strftime('%d %h %Y – %k:%M', strtotime($comment['created_at'])) }}</small>
                                    @if($role =='admin')
                                        <a data-dialog="dialog_edit_comment" data-comment-id="{{$comment['id']}}" class="btn btn-sm btn-blueempty u-ml5" onclick="dialogCommentEditData($(this));" style="margin-right: -5px;">
                                            <i class="ion ion-edit"></i>
                                        </a>
                                    @endif
                                </div>
                                <p>
                                    <strong>
                                        {{ $comment['muhtar']['first_name'] }} {{ $comment['muhtar']['last_name'] }}
                                    </strong>
                                    <span class="c-medium">
                                        @if(!empty($comment['muhtar']['location']))
                                            ( {{ explode(',', $comment['muhtar']['location'])[0] }} muhtarı)
                                        @endif
                                    </span>
                                </p>
                                <p><em class="comment-message">
                                    {{ $comment['comment'] }}
                                </em></p>
                            </div>
                        @endforeach

                    </div>

                @endif
                {{--

                --}}

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
                                <a href="https://docs.google.com/forms/d/1Gwyj1OZ_MkMF7QYBN625ADYWIifMsQdFqACA7uTcof0/viewform?entry.22153642&entry.903793893&entry.960103609&entry.512574518={{$issue['title']}}" class="btn btn-tertiary" target="_blank"><i class="ion ion-alert-circled"></i></a>
                                <span class="tooltip tooltip-alignright u-width300 u-mr5">
                                    <i class="ion ion-alert-circled ion-15x u-floatleft u-mv10 u-mr10"></i>
                                    <div class="u-ml30">{{ trans('issues.report_issue_tooltip') }}</div>
                                </span>
                            </span>
                        @endif
                    </div>
                    <ul class="issue-history title">

                        @foreach($issue['updates'] as $update)
                            <li>
                                <i class="ion ion-record u-mr10"></i>
                                <span class="date">{{strftime('%d %h %Y', strtotime($update['created_at']))}}</span> –
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
