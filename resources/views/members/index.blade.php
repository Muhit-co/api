@extends('layouts.default')
@section('content')

<?php 
// Clears $url from given query parameter $key
function clearParam($url, $key) { 
    $url = preg_replace('/(.*)(?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&'); 
    $url = substr($url, 0, -1); 
    return $url; 
}

// array with currently active levels
$levels = array(
    array(
        'id' => null,
        'name' => 'All'
    ),
    array(
        'id' => 0, 
        'name' => 'Users'
    ),
    array(
        'id' => 3, 
        'name' => 'Rejected muhtars'
    ),
    array(
        'id' => 4, 
        'name' => 'Pending muhtars'
    ),
    array(
        'id' => 5, 
        'name' => 'Muhtars'
    ),
    array(
        'id' => 10, 
        'name' => 'Admins'
    ),
);
?>

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

                        <!-- <div class="form-group u-floatleft u-mr20 u-width150">
                            <input name="location" type="text" placeholder="Location..." value="<?php echo $param_loc ?>" />
                        </div>

                        <div class="form-group u-floatleft u-mt5 u-width5p">
                            <select name="level">
                                @foreach($levels as $l)
                                <option value="{{ $l['id'] }}">{{ $l['name'] }}</option>
                                </option>
                                @endforeach
                            </select>
                        </div> -->

                        <input type="submit" style="position: absolute; left: -9999px"/>

                    </form>
                </div>

                <h2>Users</h2>

            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            @if(count($levels) > 0)
                <?php 
                $active_tab = (isset($_GET['level'])) ? intval($_GET['level']) : null;
                ?>
                <ul class="tabs">
                    @foreach($levels as $l)
                    <li>
                        <a href="<?php echo '?' . buildRelativeUrl('level', $l['id']) ?>" <?php echo ($active_tab === $l['id']) ? 'class="active"' : ''; ?> >
                            {{ strtoupper($l['name']) }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            @endif
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

            <div class="list list-small">
                <div class="list-header">
                    <div class="u-floatleft u-width40">
                        <p>&nbsp;</p>
                    </div>
                    <div class="u-floatright" style="width: 107px;">
                        <small class="c-medium"><em>actions</em></small>
                    </div>
                    <div class="u-nowrap">
                        <small class="u-floatleft u-width30p u-nowrap c-medium"><em>name (username)</em></small>
                        <small class="u-floatleft u-width20p u-nowrap c-medium"><em>email</em></small>
                        <small class="u-floatleft u-width10p u-nowrap c-medium"><em>level</em></small>
                        <small class="u-floatleft u-width15p u-nowrap c-medium"><em>creation date</em></small>
                        <small class="u-floatleft u-width25p u-nowrap c-medium"><em>location</em></small>
                    </div>
                </div>
                <ul class="list-content">

                    @foreach($members as $m)
                        <li>
                            <a href="/admin/view-member/{{$m->id}}">
                                <div class="badge badge-circle-small u-floatleft u-mt5 u-ml5 u-mr15">
                                    <img src="//d1vwk06lzcci1w.cloudfront.net/50x50/{{$m->picture}}" alt="" />
                                </div>
                                <div class="hasDropdown u-floatright">
                                    <button class="btn btn-sm btn-outline u-ml10">
                                        ACTIONS
                                        <i class="ion ion-chevron-down u-ml5"></i>
                                    </button>
                                    <div class="dropdown u-mr15">
                                        this is the dropdown, without lists
                                    </div>
                                </div>
                                <div class="u-nowrap u-pt5">
                                    <span class="u-floatleft u-width30p u-nowrap"><strong>{{$m->first_name}} {{$m->last_name}}</strong> <small class="c-light">({{$m->username}})</small></span>
                                    <small class="u-floatleft u-width20p u-nowrap c-medium">{{$m->email}}</small>
                                    <small class="u-floatleft u-width10p u-nowrap c-medium">{{$m->level}}</small>
                                    <small class="u-floatleft u-width15p u-nowrap c-medium">{{$m->created_at}}</small>
                                    <small class="u-floatleft u-width25p u-nowrap c-medium">{{$m->location}}</small>
                                </div>
                            </a>
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

                <div class="u-aligncenter u-mt20">
                    {!! $members->render() !!}
                </div>

            </div>

        </div>
    </div>
</section>

@stop
