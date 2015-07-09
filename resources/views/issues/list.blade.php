@extends('layouts.default')
@section('content')

@include('partials.header')

<section class="tabsection" id="list">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <div class="list list-expanded list_block u-mt20 u-mb40">
                <div class="list-header"></div>
                    <ul>
                        @foreach($issues as $issue)
                            <li>
                                <a href="/issues/view/{{$issue['id']}}">
                                    <div class="badge badge-image u-floatleft u-mr15">
                                        @if(isset($issue['images']) and !empty($issue['images']))
                                            <img src="//d1vwk06lzcci1w.cloudfront.net/50x50/{{$issue['images'][0]['image']}}" alt="{{$issue['title']}}" />
                                        @else
                                            <img src="//d1vwk06lzcci1w.cloudfront.net/50x50/placeholders/issue.jpg" alt="{{$issue['title']}}" />
                                        @endif
                                    </div>
                                    <div class="badge badge-status u-floatright u-mt10">
                                        <i class="ion ion-wrench u-mr5"></i>
                                        <strong>{{(int) Redis::get('issue_counter:'.$issue['id'])}}</strong>
                                    </div>
                                    <strong>{{$issue['title']}}</strong>
                                    <p>
                                        @if(isset($issue['tags']) and !empty($issue['tags']))
                                            @foreach($issue['tags'] as $tag)
                                                <span class="tag u-mv5 u-mr5" style="background-color: #{{$tag['background']}};">
                                                    {{$tag['name']}}
                                                </span>

                                            @endforeach
                                        @endif
                                        <span class="date u-mr10"><?php echo date('j M Y', strtotime($issue['created_at'])) ?></span>
                                        |<span class="user u-ml10">user id: <?php echo $issue['user_id'] ?></span>
                                    </p>
                                </a>
                            </li>
                        @endforeach
                        @if (count($issues) == 0)
                            <li class="u-aligncenter u-pt20">
                                <span class="c-light">
                                    <i class="ion ion-checkmark-circled ion-2x"></i><br />
                                    <strong>Fikirleri şu an bulunamadı...</strong>
                                </span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="map" class="tabsection u-opacity0">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <div id="map-canvas">
                <!-- <iframe width="600" height="450" frameborder="0" style="border:0" src=""></iframe> -->
                <script>
                    // google.maps.event.addDomListener(window, 'load', mapInitialize);
                </script>
            </div>

            <div class="u-aligncenter u-pv20">
                <a class="btn btn-secondary" id="map_redraw">MAP REDRAW</a>
            </div>
            
        </div>
    </div>
</section>

@stop
