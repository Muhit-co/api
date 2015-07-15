@extends('layouts.default')
@section('content')

@include('partials.header', array('type'=>'show'))

<section>
    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <div class="card card-issue">
                <div class="card-header clearfix u-pv15">
                    <div class="u-floatleft">
                        <a href="/" class="u-ml10 u-mr20 closeCard"><i class="ion ion-android-arrow-back ion-2x"></i></a>
                    </div>
                    <div class="u-floatright u-clearfix">
                        <a href="javascript:void(0)" class="btn btn-secondary u-mr5"><i class="ion ion-android-share-alt"></i></a>
                        <a href="javascript:void(0)" class="btn btn-secondary"><i class="ion ion-thumbsup"></i> DESTEKLE</a>
                    </div>
                    <span class="title">{{$issue['location']}}</span>
                </div>
                <div class="card-content">

                    <style>
                        .badge.badge-large {
                            width: 80px;
                            height: 80px;
                            padding: 18px 10px;
                        }
                        .badge.badge-support {
                            background-color: #44a1e0;
                            color: #fff;
                        }
                        .badge.badge-support label {
                            font-size: 0.75em;
                        }
                        .badge.badge-support .value {
                            font-size: 2em;
                            font-weight: bold;
                        }
                    </style>

                    <div class="badge badge-circle-large badge-support u-floatright u-pt15">
                        <div class="value">54</div>
                        <label>DESTEKÇİ</label>
                    </div>

                        <h3 class="u-mh5 u-mv10">
                                {{$issue['title']}}
                        </h3>

                    <div class="media u-mv20">
                        <div class="media-image col-md-8">
                            <img src="/images/street.jpg" alt="" />

                            @foreach($issue['images'] as $image)
                                <img src="//d1vwk06lzcci1w.cloudfront.net/100x100/{{$issue['images'][0]['image']}}" alt="{{$issue['title']}}" />
                            @endforeach
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
                    <em class="c-light u-block u-mb10">For development purposes only: all available issue data</em>
                    <p>...</p>
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
