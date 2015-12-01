@extends('layouts.default')
@section('content')

<?php 
// Clears $url from given query parameter $key
function clearParam($url, $key) { 
	$url = preg_replace('/(.*)(?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&'); 
	$url = substr($url, 0, -1); 
	return $url; 
}

$levels = array(
	array(
		'id' => '', 
		'name' => '[none]'
	),
	array(
		'id' => 0, 
		'name' => 'User'
	),
	array(
		'id' => 3, 
		'name' => 'Rejected muhtar'
	),
	array(
		'id' => 4, 
		'name' => 'Pending muhtar'
	),
	array(
		'id' => 5, 
		'name' => 'Muhtar'
	),
	array(
		'id' => 10, 
		'name' => 'Admin'
	),
);
?>

<section id="members">
	<div class="row">
		<div class="col-xs-12 u-pv20">

			<div class="u-clearfix">

				<div class="u-floatright">
					<?php 
					$param_q = (isset($_GET["q"])) ? $_GET["q"] : '';
					$param_loc = (isset($_GET["location"])) ? $_GET["location"] : '';
					?>
					<form method="get">

						<!-- <a href="<?php clearParam($_SERVER['REQUEST_URI'], $param_q) ?>" class="btn btn-sm u-floatright"><?php echo $_SERVER['REQUEST_URI'] ?></a> -->

		                <div class="form-group u-floatleft u-mr20 u-width150">
		                    <input name="q" type="text" placeholder="Search..." value="<?php echo $param_q ?>" />
		                </div>
		                <div class="form-group u-floatleft u-mr20 u-width150">
							<input name="location" type="text" placeholder="Location..." value="<?php echo $param_loc ?>" />
						</div>

						<div class="form-group u-floatleft u-mt5 u-width5p">
							<select name="level">
								@foreach($levels as $l)
								<option value="{{ $l['id'] }}">{{ $l['name'] }}</option>
								</option>
								@endforeach
							</select>
						</div>

						<input type="submit" style="position: absolute; left: -9999px"/>

					</form>
				</div>

				<h2>Users</h2>

			</div>

			<div class="list list-small u-mv20">
                <div class="list-header">
                    <div class="u-floatleft u-width40">
                    	<p>&nbsp;</p>
                    </div>
                    <div class="u-floatright" style="width: 107px;">
                    	<small class="c-medium"><em>actions</em></small>
                    </div>
                    <div class="u-nowrap">
						<small class="u-floatleft u-width20p u-nowrap c-medium"><em>name</em></small>
						<small class="u-floatleft u-width10p u-nowrap c-medium"><em>username</em></small>
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
								<!-- user profile image -->
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

                {!! $members->render() !!}
			</div>

		</div>
	</div>
</section>

@stop
