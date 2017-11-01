<div class="navplaceholder"></div>
<nav class="nav-report">
    <div class="row row-nopadding">
        <div class="col-xs-12">

            <div class="extended u-floatleft"><a href="/" target="_self" class="btn btn-blueempty u-mt15 u-ml15"><i class="ion ion-chevron-left"></i></a></div>

            <a href="/" class="u-floatleft u-pv15 u-pl10">
                @include('partials.logo_svg', array('height' => '36px', 'colour' => 'blue'))
            </a>
            
            @if(Auth::check())
                @include('partials.userinfo')
            @else
                {{-- user is not logged in --}}
                <div class="u-floatright u-nowrap">

                    <div class="lang-switcher u-inlineblock u-pv20 u-ph10 u-lineheight30 col-xs-hide c-blue">
                        @include('partials.lang-switcher', ['state' => 'full'])
                    </div>

                    <a href="/login" class="btn btn-quaternary u-mt15 u-mr5">
                        <span class="condensed"><i class="ion ion-log-in ion-15x u-floatleft"></i></span>
                        <span class="extended">{{ trans('auth.log_in_cap') }}</span></a>
                    <span class="extended">
                        <a href="/register" class="btn btn-primary u-mt15 u-mr15">{{ trans('auth.sign_up_cap') }}</a>
                    </span>

                </div>
            @endif
        </div>
    </div>
</nav>