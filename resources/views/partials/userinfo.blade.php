<div class="userinfo hasDropdown u-floatright">
    <a href="javascript:void(0)" id="userinfo" class="u-inlineblock u-nowrap">
        <span class="badge badge-circle badge-user u-floatright u-ml10">
            <img src="{{ getImageURL(Auth::user()->picture, '80x80') }}" alt="{{Auth::user()->first_name}}">
        </span>
      <span class="text">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
    </a>
    <div class="dropdown u-mr15">
        <ul>
            <li>
                @include('partials.add_idea_button', ['text' => trans('issues.add_idea'), 'class' => ''])
            </li>
            <li><a href="/members/my-profile"><i class="ion ion-person u-mr5"></i> {{ trans('issues.my_profile') }}</a></li>
            <li><a href="{{ getSupportLink() }}" target="_blank"><i class="ion ion-bug u-mr5"></i> {{ trans('issues.technical_problems') }} <i class="ion ion-android-open u-ml5 c-light"></i></a></li>
            <li>
                @include('partials.lang-switcher', ['state' => 'expanded'])
            </li>
            <li><a href="/logout" class="c-red"><i class="ion ion-log-out u-mr5"></i> {{ trans('auth.log_out') }}</a></li>
        </ul>
    </div>
</div>
