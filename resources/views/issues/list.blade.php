@extends('layouts.default')
@section('content')

@include('partials.header')

<section>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="list list-expanded list_block u-mt20 u-mb40">
                <div class="list-header"></div>
                    <ul>
                        @foreach($issues as $issue)
                            <li>
                                <a href="/issues/view/{{$issue['id']}}">
                                    <div class="badge badge-image u-floatleft u-mr15">
                                        <!-- first image in issue -->
                                        <img src="/images/street_thumbnail.jpg" alt="" />
                                    </div>
                                    <!-- status/support badge -->
                                    <div class="badge badge-status u-floatright u-mt10">
                                        <i class="ion ion-wrench u-mr5"></i>
                                        <strong>{{(int) Redis::get('issue_counter:'.$issue['id'])}}</strong>
                                    </div>
                                    <!-- issue title -->
                                    <strong>{{$issue['title']}}</strong>
                                    <p>
                                        <!-- issue tags (max 3) -->
                                        @if(isset($issue['tags']) and !empty($issue['tags']))
                                            @foreach($issue['tags'] as $tag)
                                                <span class="tag u-mr10" style="background-color: #{{$tag['background']}};">
                                                    {{$tag['name']}}
                                                </span>

                                            @endforeach
                                        @endif
                                        <!-- issue date -->
                                        <span class="date">{{$issue['created_at']}}</span>
                                    </p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@stop
