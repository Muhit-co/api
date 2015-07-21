@extends('layouts.default')
@section('content')

@include('partials.header', array('type'=>'show'))

<section>
    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <div class="card card-issue">
                <div class="card-header u-clearfix u-pv15">
                    <div class="u-floatleft">
                        <a href="/" class="u-mr20 closeCard"><i class="ion ion-android-arrow-back ion-2x"></i></a>
                    </div>
                    <div class="u-floatright u-clearfix">

                        <!-- Share buttons -->
                        <a href="javascript:void(0)" class="btn btn-secondary btn-twitter u-ml5 u-width50"><i class="ion ion-social-twitter"></i></a>
                        <a href="javascript:void(0)" class="btn btn-secondary btn-facebook u-ml5 u-width50"><i class="ion ion-social-facebook ion-15x"></i></a>

                        <!-- (Un)Support button -->
                        @if($role =='public')
                        <a href="javascript:void(0)" data-dialog="dialog_login" class="btn btn-secondary u-ml5"><i class="ion ion-thumbsup"></i> {{ trans('issues.support_cap') }}</a>
                        @elseif($role =='user')
                        <a id="action_support" href="javascript:void(0)" class="btn btn-secondary u-ml5"><i class="ion ion-thumbsup"></i> {{ trans('issues.support_cap') }}</a>
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
                                    <li><a href="javascript:void(0)"><i class="ion ion-muhit-tea u-mr5"></i> {{ trans('issues.come_drink_tea') }}...</a></li>
                                    <li><a href="javascript:void(0)"><i class="ion ion-wrench u-mr5"></i> {{ trans('issues.in_progress') }}...</a></li>
                                    <li><a href="javascript:void(0)"><i class="ion ion-checkmark-circled u-mr5"></i> {{ trans('issues.solved') }}...</a></li>
                                    <li><a href="javascript:void(0)"><i class="ion ion-chatboxes u-mr5"></i> {{ trans('issues.write_comment') }}...</a></li>
                                </ul>
                            </div>
                        </div>
                        @endif

                    </div>
                    <span class="title u-inlineblock u-mt5">{{$issue['location']}}</span>
                </div>
                <div class="card-content">

                    <?php
                    // @TODO: logic should be available in list.blade.php and show.blade.php --> @gcg refactor to be generic logic
                    $issue_supporters = 6; // temporary value until real value is available in view
                    // issue status badge fallback
                    $issue_status = getIssueStatus($issue['status'], $issue_supporters);

                    ?>
                    <div class="u-floatright u-relative">
                        <div class="label label-{{$issue_status['class']}} u-pr80 u-mr10">
                            <i class="ion {{$issue_status['icon']}}"></i>
                            <span class="text">{{$issue_status['title']}}</span>
                        </div>
                        <div id="support_counter" class="badge badge-circle-large badge-support badge-{{$issue_status['class']}} u-pinned-topright u-pt15" style="margin-top: -15px;">
                            <div class="value">{{(int) Redis::get('issue_counter:'.$issue['id'])}}</div>
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
                                        <img src="//d1vwk06lzcci1w.cloudfront.net/600x300/{{$issue['images'][0]['image']}}" alt="{{$issue['title']}}" />
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
                            <div id="map-canvas">
                            </div>
                            <script>
                                mapInitialize();
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

                    <div class="description">
                        <p>{{$issue['desc']}}</p>
                    </div>

                </div>

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

                <div class="card-footer clearfix">
                    <div class="u-floatright">
                        <a href="javascript:void(0)" class="btn btn-sm btn-tertiary u-mr5"><i class="ion ion-alert-circled"></i></a>
                        @if(Auth::check() and (Auth::user()->id == $issue['user_id'] or Auth::user()->level > 5))
                            <a href="/issues/delete/{{$issue['id']}}" class="btn btn-sm btn-tertiary" onclick="return confirm('Bu fikri silmek istediğinizden emin misiniz?');"><i class="ion ion-trash-b u-mr5"></i> SİL</a>
                        @endif
                    </div>
                    <ul class="issue-history title">
                        <li><i class="ion ion-android-checkmark-circle u-mr10"></i> <span class="date">15 Tem 2015</span> <strong>{{ trans('issues.issue_solved') }}</strong>.</li>
                        <li><i class="ion ion-android-time u-mr10"></i> <span class="date">13 Tem 2015</span> <strong>{{ trans('issues.issue_changed_to_development') }}</strong>.</li>
                        <li><i class="ion ion-android-time u-mr10"></i> <span class="date">2 Tem 2015</span> <strong>{{ trans('issues.issue_10_supporters') }}</strong>.</li>
                        <li><i class="ion ion-record u-mr10"></i> <span class="date">27 Haz 2015</span> <strong>{{ trans('issues.issue_created') }}</strong>.</li>
                    </ul>
                </div>

            </div>

        </div>

    </div>
</section>

@stop
