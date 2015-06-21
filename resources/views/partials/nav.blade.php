<nav>
    <div class="row">
        <div class="col-xs-12 u-aligncenter">

            @if(Auth::check())
                {{-- user is logged in --}}
            @else
                {{-- user is not logged in --}}
            @endif

            <div class="userinfo hasDropdown u-floatright">
                <a href="javascript:void(0)" id="userinfo" class="u-inlineblock">
                    <span class="badge badge-circle badge-user u-floatright u-ml10">
                        <i class="ion ion-person ion-2x"></i>
                    </span>
                    <span class="text">John Doe</span>
                </a>
                <div class="dropdown">
                    <ul>
                        <li><a href="#"><i class="ion ion-plus u-mr5"></i> Fikir ekle</a></li>
                        <li><a href="#"><i class="ion ion-person u-mr5"></i> Profilim</a></li>
                        <li><a href="#" id="logout"><i class="ion ion-log-out u-mr5"></i> Çıkış</a></li>
                    </ul>
                </div>
            </div>

            <a href="#top" id="nav_logo" class="u-floatleft"><img src="/images/logo.png" height="60px" alt="" /></a>

            <a href="#top" id="navbutton"><i class="ion ion-navicon ion-2x"></i></a>

            <ul id="menu">
                <li class="active"><a href=""><i class="ion ion-android-home ion-15x"></i>TÜMÜ</a></li>
                <li><a href=""><i class="ion ion-thumbsup ion-15x"></i>DESTEKLEDİKLERİM</a></li>
                <li><a href=""><i class="ion ion-lightbulb ion-15x"></i>FİKİRLERİM</a></li>
                <li><a href=""><i class="ion ion-speakerphone ion-15x"></i>DUYURULAR</a></li>
                <li><a href=""><i class="ion ion-information-circled ion-15x"></i>MUHTARIM</a></li>
            </ul>

        </div>
    </div>
</nav>

