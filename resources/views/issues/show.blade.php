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
                        <a href="javascript:void(0)" data-dialog="dialog_login" class="btn btn-secondary u-ml5"><i class="ion ion-thumbsup"></i> DESTEKLE</a>
                        @elseif($role =='user')
                        <a id="action_support" href="javascript:void(0)" class="btn btn-secondary u-ml5"><i class="ion ion-thumbsup"></i> DESTEKLE</a>
                        <a id="action_unsupport" href="javascript:void(0)" class="btn btn-tertiary u-ml5 u-hidden u-has-hidden-content">
                            <i class="ion ion-fw ion-thumbsup u-hide-on-hover"></i>
                            <i class="ion ion-fw ion-close u-show-on-hover"></i>
                            DESTEKLEDİM
                        </a>
                        @elseif($role =='admin')
                        <!-- Action button for Muhtar -->
                        <div class="hasDropdown u-inlineblock u-ml5">
                            <a href="javascript:void(0)" class="btn btn-secondary">HAREKETE GEÇ <i class="ion ion-chevron-down u-ml5"></i></a>
                            <div class="dropdown dropdown-outline">
                                <ul>
                                    <li><a href="javascript:void(0)"><i class="ion ion-muhit-tea u-mr5"></i> Çayımı iç...</a></li>
                                    <li><a href="javascript:void(0)"><i class="ion ion-wrench u-mr5"></i> Gelişmekte...</a></li>
                                    <li><a href="javascript:void(0)"><i class="ion ion-checkmark-circled u-mr5"></i> Çözüldü...</a></li>
                                    <li><a href="javascript:void(0)"><i class="ion ion-chatboxes u-mr5"></i> Yorum Yaz...</a></li>
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
                    $issue_status = array(
                        'class' => '',
                        'icon' => 'ion-lightbulb',
                        'title' => ''
                    );
                    if($issue['status'] == 'new') {
                        $issue_status = array(
                            'class' => $issue['status'],
                            'icon' => 'ion-lightbulb',
                            'title' => 'Oluşturuldu'
                        );
                        if($issue_supporters < 5) {
                            $issue_status['class'] = $issue['status'] . '-empty';
                        }
                    } elseif($issue['status'] == 'progress') {
                        $issue_status = array(
                            'class' => $issue['status'],
                            'icon' => 'ion-wrench',
                            'title' => 'Gelişmekte'
                        );
                    } elseif($issue['status'] == 'solved') {
                        $issue_status = array(
                            'class' => $issue['status'],
                            'icon' => 'ion-ios-checkmark',
                            'title' => 'Çözüldü'
                        );
                    }
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
                                <!-- wrap with a <a href="javascript:void(0)"></a> to enlarge -->
                                <img src="/images/street.jpg" alt="" />
                                <img src="/images/street.jpg" alt="" />
                                <img src="/images/street.jpg" alt="" />

                                <!-- @foreach($issue['images'] as $image)
                                    <img src="//d1vwk06lzcci1w.cloudfront.net/100x100/{{$issue['images'][0]['image']}}" alt="{{$issue['title']}}" />
                                @endforeach -->
                            </div>

                            <script>
                                $(function(){
                                    $("#slides").slidesjs({
                                        width: 500,
                                        height: 300,
                                    });
                                });
                            </script>

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
                            <label class="c-light"><i class="ion ion-android-calendar u-mr5"></i>[Date]</label>
                        </div>
                    </div>

                    <div class="description">
                        <p>{{$issue['is_anonymous']}}</p>
                        <p>{{$issue['desc']}}</p>
                    </div>

                </div>

                <div class="card-footer clearfix">
                    <h3 class="c-blue u-mb10">{{ trans('issues.comments_from_muhtar') }}</h3>
                    <div class="comment u-ph50">
                        <h4 class="title">
                            <div class="u-floatright">
                                <small>Date...</small>
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
                    <span class="title">A019 8589910</span>
                </div>

            </div>

        </div>

    </div>
</section>

@stop
