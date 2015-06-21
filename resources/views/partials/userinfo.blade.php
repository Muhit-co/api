<div class="userinfo hasDropdown u-floatright">
    <a href="javascript:void(0)" id="userinfo" class="u-inlineblock">
        <span class="badge badge-circle badge-user u-floatright u-ml10">
            <img src="//d1vwk06lzcci1w.cloudfront.net/40x40/{{Auth::user()->picture}}" alt="{{Auth::user()->first_name}}">
        </span>
      <span class="text">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
    </a>
    <div class="dropdown">
        <ul>
            <li><a href="#"><i class="ion ion-plus u-mr5"></i> Fikir ekle</a></li>
            <li><a href="user/{{ Auth::user()->username }}"><i class="ion ion-person u-mr5"></i> Profilim</a></li>
            <li><a href="#"><i class="ion ion-bug u-mr5"></i> Sorunlar ve öneriler</a></li>
            <li><a href="/logout" id="logout"><i class="ion ion-log-out u-mr5"></i> Çıkış</a></li>
        </ul>
    </div>
</div>