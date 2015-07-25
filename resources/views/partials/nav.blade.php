<div id="top" class="navplaceholder"></div>
<nav>
    <div class="row row-nopadding">
        <div class="col-xs-12 u-aligncenter">

            @if(Auth::check())
                @include('partials.userinfo')
                <a href="/issues/new" id="nav_quickadd" class="btn btn-sm btn-primary u-floatright u-mr10 u-mt20"><i class="ion ion-plus"></i></a>
            @else
                {{-- user is not logged in --}}
                <div class="u-floatright u-nowrap">
                    <a href="/login" class="btn btn-quaternary u-mt20 u-mr5">GİRİŞ<span class="extended"> YAP</span></a>
                    <a href="/register" class="btn btn-primary u-mt20 u-mr15">KAYIT<span class="extended"> OL</span></a>
                </div>
            @endif

            @if(Auth::check())
                <a href="#top" id="navbutton" class="u-floatleft">
                    <i class="ion ion-navicon ion-2x"></i>
                    <i class="ion ion-android-close ion-2x"></i>
                </a>
            @endif
            
            <a href="<?php echo (Request::is('/')) ? '#top' : '/' ?>" id="nav_logo" class="u-floatleft"><img src="/images/logo.png" height="40px" alt="" /></a>

            @if(Auth::check())
                @include('partials.menu')
            @endif

        </div>
    </div>
</nav>

