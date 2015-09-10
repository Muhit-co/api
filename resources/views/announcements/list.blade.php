@extends('layouts.default')

{{$role}}

@section('dialogs')
    @if($role =='admin')
        @include('dialogs.new_announcement')
    @endif
@stop

@section('content')

<header class="u-relative header-list">

    <div class="row u-pb40">
        <div class="col-md-6 col-sm-7 col-md-offset-1 u-mb10">
            @if($role =='admin')
                <h2>{{ trans('issues.my_announcements') }}</h2>
                <h4 class="u-opacity50">[{{$hood->name}}], [{{$hood->district->name}}]</h4>
            @endif
        </div>
        <div class="col-md-4 col-sm-5">
            @if($role =='admin')
                <a href="javascript:void(0)" data-dialog="dialog_new_announcement" class="btn btn-primary u-floatright u-ml10">
                    <i class="ion ion-compose u-mr5"></i>
                    {{ trans('issues.post_new_announcement_cap') }}
                </a>
            @else
                <a href="/members/edit-profile" class="btn btn-sm btn-whiteoutline u-floatright u-ml10">
                    <i class="ion ion-edit"></i>
                </a>
                <p class="c-white u-nowrap"><strong>{{$hood->name}}, {{$hood->district->name}}</strong> <span class="u-ml10">{{$hood->district->city->name}}</span></p>
            @endif
        </div>
    </div>

</header>

<section class="u-mv20">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            @foreach($announcements as $a)

                <div class="card u-mv20" id="{{$a->id}}"> <!-- id = announement id (for permalink) -->
                    <div class="card-header">

                        <div class="row row-nopadding">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="u-floatright u-ml10">
                                    <span class="date c-medium">{{strftime('%d %h %Y', strtotime($a->created_at))}}</span>
                                </div>
                                <h3 class="u-nowrap">{{$a->title}}</h3>
                            </div>
                        </div>

                    </div>
                    <div class="card-content">

                        <div class="row row-nopadding">
                            <div class="col-md-10 col-md-offset-1">
                                <p>{{$a->content}}</p>

                                <a href="/muhtar" class="u-inlineblock u-clearfix u-mt10">
                                    <div class="badge badge-circle badge-small u-floatleft u-mr10">
                                        <img src="//d1vwk06lzcci1w.cloudfront.net/50x50/{{$a->user->picture}}" alt="" />
                                    </div>
                                    <strong class="username u-floatleft u-mt5 u-mr20">
                                        {{$a->user->first_name}} {{$a->user->last_name}}
                                    </strong>
                                    <span class="u-floatleft u-mt5 c-light">
                                        {{$hood->name}}
                                    </span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            @endforeach

            @if(count($announcements) == 0)
            <div class="u-aligncenter u-pv20">
                <span class="c-light">
                    <i class="ion ion-checkmark-circled ion-2x"></i><br />
                    <strong>{{ trans('issues.no_announcements') }}</strong>
                </span>
            </div>
            @endif

        </div>
    </div>

</section>

@stop
