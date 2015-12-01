@extends('layouts.default')
@section('content')

<section id="members">
	<div class="row">
		<div class="col-xs-12 u-pv20">

			<h3>Users</h3>

			<div class="list list-small u-mv20">
                <div class="list-header">
                    <div class="u-floatleft u-width40">
                    	<p>&nbsp;</p>
                    </div>
                    <div class="u-floatright" style="width: 107px;">
                    	<p>&nbsp;</p>
                    </div>
                    <div class="u-nowrap">
						<small class="u-floatleft u-width20p u-nowrap c-medium"><em>name</em></small>
						<small class="u-floatleft u-width20p u-nowrap c-medium"><em>username</em></small>
						<small class="u-floatleft u-width10p u-nowrap c-medium"><em>id</em></small>
						<small class="u-floatleft u-width15p u-nowrap c-medium"><em>creation date</em></small>
						<small class="u-floatleft u-width30p u-nowrap c-medium"><em>location</em></small>
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
                                <strong class="u-floatleft u-width20p u-nowrap">{{$m->first_name}} {{$m->last_name}}</strong>
                                <small class="u-floatleft u-width20p u-nowrap c-medium">{{$m->username}}</small>
                                <small class="u-floatleft u-width10p u-nowrap c-medium">{{$m->level}}</small>
                                <small class="u-floatleft u-width15p u-nowrap c-medium">{{$m->created_at}}</small>
                                <small class="u-floatleft u-width30p u-nowrap c-medium">{{$m->location}}</small>
							</div>
						</a>
					</li>
                    @endforeach

				</ul>
			</div>

		</div>
	</div>
</section>

@stop
