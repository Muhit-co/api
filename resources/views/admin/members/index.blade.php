@extends('layouts.default')
@section('content')

<header class="u-relative header-show">
    <div class="row">
        <div class="col-xs-12">

            <div class="u-clearfix">

                <div class="u-floatright">
                    <?php
$param_q = (isset($_GET["q"])) ? $_GET["q"] : '';
$param_loc = (isset($_GET["location"])) ? $_GET["location"] : '';
?>
                    <form method="get">

                        <div class="form-group u-floatleft u-width150">
                            <input class="form-input" name="q" type="text" placeholder="Search..." value="<?php echo $param_q ?>" />
                            @if (strlen($param_q) > 0)
                                <a href="<?php echo '?' . buildRelativeUrl('q', '') ?>" class="form-appendRight u-ph15" style="padding-top: 8px;"><i class="ion ion-close"></i></a>
                            @endif
                        </div>

                        <input type="submit" style="position: absolute; left: -9999px"/>

                    </form>
                </div>

                <h2>Users</h2>

            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php
            $active_tab = (isset($_GET['level'])) ? intval($_GET['level']) : null;
            ?>
            <ul class="tabs">
                <li>
                    <a href="{{ '/' . Request::path() }}" <?php echo ($active_tab === null) ? 'class="active"' : ''; ?> >
                        ALL
                    </a>
                </li>
                @foreach ([0, 3, 4, 5, 10] as $t)
                    <li>
                        <a href="<?php echo '?' . buildRelativeUrl('level', $t) ?>" <?php echo ($active_tab === $t) ? 'class="active"' : ''; ?> >
                            {{ strtoupper( getUserLevel($t, true) ) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

</header>

<section id="members">
    <div class="row">
        <div class="col-xs-12 u-pv20">

            @if (strlen($param_q) > 0)
                <em class="u-block u-mb10">
                    <small>There are {{ count($members) }} results matching your criteria</small>
                </em>
            @endif

            <div class="list list-small list-overflowshow">
                <div class="list-header">
                    <div class="row row-nopadding u-pr100">
                        <div class="col-sm-4">
                            <small class="u-nowrap u-ml40"><em>name (username)</em></small>
                        </div>
                        <div class="col-sm-3 col-sm-hide">
                            <small class="u-nowrap"><em>email</em></small>
                        </div>
                        <div class="col-sm-1 col-sm-hide">
                            <small class="u-nowrap"><em>level</em></small>
                        </div>
                        <div class="col-sm-4 col-sm-hide">
                            <small class="u-nowrap"><em>location</em></small>
                        </div>
                    </div>
                </div>
                <ul class="list-content">

                    @foreach($members as $m)
                        <li class="u-relative">
                            <a href="/admin/view-member/{{$m->id}}" class="u-pr110">
                                <div class="row row-nopadding">
                                    <div class="col-sm-4">
                                        <div class="badge badge-circle-small u-floatleft u-mt5 u-ml5 u-mr15">
                                            <img src="//d1vwk06lzcci1w.cloudfront.net/50x50/{{$m->picture}}" alt="" />
                                        </div>
                                        <div class="u-nowrap u-pt5">
                                            <span class="u-floatleft u-nowrap"><strong>{{$m->first_name}} {{$m->last_name}}</strong> <small class="c-light">({{$m->username}})</small></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-sm-hide">
                                        <div class="u-nowrap u-pt5 c-medium">
                                            <small class="u-nowrap">{{$m->email}}</small>
                                        </div>
                                    </div>
                                    <div class="col-sm-1 col-sm-hide">
                                        <div class="u-nowrap u-pt5 c-medium">
                                            <small class="u-nowrap">{{$m->level}}</small>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-sm-hide">
                                        <div class="u-nowrap u-pt5 c-medium">
                                            <small class="u-nowrap">{{$m->location}}</small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="u-pinned-topright u-ma10">
                                <a href="/admin/view-member/{{$m->id}}" class="btn btn-sm btn-outline u-floatleft">
                                    VIEW
                                </a>
                                <div class="hasDropdown u-floatleft">
                                    <button class="btn btn-sm btn-outline u-ml10">
                                        ACTIONS
                                        <i class="ion ion-chevron-down u-ml5"></i>
                                    </button>
                                    <div class="dropdown dropdown-outline">
                                        <ul>
                                            @if ($m->level == 3 || $m->level == 4)
                                                <li><a href="/admin/approve-muhtar/{{$m->id}}" class="c-green"><i class="ion ion-checkmark-circled u-mr5"></i> Approve</a></li>
                                            @endif
                                            @if ($m->level == 4 || $m->level == 5)
                                                <li><a href="/admin/reject-muhtar/{{$m->id}}" class="c-red"><i class="ion ion-close-circled u-mr5"></i> Reject</a></li>
                                            @endif
                                            <li><a href="/admin/view-member/{{$m->id}}"><i class="ion ion-eye u-mr5"></i> View</a></li>
                                            <li><a href="/admin/edit-member/{{$m->id}}"><i class="ion ion-edit u-mr5"></i> Edit</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach

                    @if (count($members) == 0)
                        <li class="u-aligncenter u-pv20 bg-white">
                            <span class="c-light">
                                <i class="ion ion-checkmark-circled ion-2x"></i><br />
                                No results
                            </span>
                        </li>
                    @endif

                </ul>

            </div>

            <div class="u-aligncenter u-mt20">
                {!! $members->render() !!}
            </div>

        </div>
    </div>
</section>

@stop
