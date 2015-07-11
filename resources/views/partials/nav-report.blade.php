<div class="navplaceholder"></div>
<nav class="nav-report">
    <div class="row">
        <div class="col-sm-3 col-xs-6">

            <a href="/" target="_self" class="btn btn-outline u-mt20"><i class="ion ion-android-arrow-back ion-15x"></i></a>

        </div>
        <div class="col-xs-6 col-sm-hide u-aligncenter u-pv20">
            <img src="/images/logo_blue.png" height="40px" alt="" />
        </div>
        <div class="col-sm-3 col-xs-6 u-alignright u-nowrap">
            @if(Auth::check())
                @include('partials.userinfo')
            @else
                {{-- user is not logged in --}}
                <div class="u-floatright u-nowrap">
                    <a href="/login" class="btn btn-quaternary u-mt20 u-mr5">GİRİŞ<span class="extended"> YAP</span></a>
                    <a href="/register" class="btn btn-primary u-mt20 u-mr15">KAYIT<span class="extended"> OL</span></a>
                </div>
            @endif
        </div>
    </div>
</nav>