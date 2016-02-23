<div class="userinfo hasDropdown u-floatright">
    <a href="javascript:void(0)" id="userinfo" class="u-inlineblock u-nowrap">
        <span class="badge badge-circle badge-user u-floatright u-ml10">
            <img src="//d1vwk06lzcci1w.cloudfront.net/40x40/{{Auth::user()->picture}}" alt="{{Auth::user()->first_name}}">
        </span>
      <span class="text">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
    </a>
    <div class="dropdown u-mr15">
        <ul>
            <li>
                @include('partials.add_idea_button', ['text' => 'Fikir ekle', 'class' => ''])
            </li>
            <li><a href="/members/my-profile"><i class="ion ion-person u-mr5"></i> {{ trans('issues.my_profile') }}</a></li>
            <li><a href="{{ getSupportLink() }}" target="_blank"><i class="ion ion-bug u-mr5"></i> {{ trans('issues.problems_and_recommendations') }} <i class="ion ion-android-open u-ml5 c-light"></i></a></li>
            <li><a href="/logout" class="c-red"><i class="ion ion-log-out u-mr5"></i> {{ trans('auth.log_out') }}</a></li>
        </ul>
    </div>
</div>
