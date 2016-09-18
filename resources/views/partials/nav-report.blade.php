<div class="navplaceholder"></div>
<nav class="nav-report">
    <div class="row row-nopadding">
        <div class="col-sm-4 col-xs-6">

            <a href="/" target="_self" class="btn btn-outline u-mt15 u-ml15"><i class="ion ion-android-arrow-back ion-15x"></i></a>

        </div>
        <div class="col-xs-4 col-sm-hide u-aligncenter u-pv15">
            @include('partials.logo_svg', array('height' => '36px', 'colour' => 'blue'))
        </div>
        <div class="col-sm-4 col-xs-6 u-alignright u-nowrap">
            @if(Auth::check())
                @include('partials.userinfo')
            @else
                {{-- user is not logged in --}}
                <div class="u-floatright u-nowrap">

                    <div class="u-inlineblock u-lineheight30 col-xs-hide c-blue">
                        @include('partials.lang-switcher', ['state' => 'full'])
                    </div>

                    <a href="/login" class="btn btn-quaternary u-mt15 u-mr5">GİRİŞ<span class="extended"> YAP</span></a>
                    <a href="/register" class="btn btn-primary u-mt15 u-mr15">KAYIT<span class="extended"> OL</span></a>
                </div>
            @endif
        </div>
    </div>
</nav>