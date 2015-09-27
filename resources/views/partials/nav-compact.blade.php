<div class="navplaceholder"></div>
<nav>
    <div class="row">
        <div class="col-sm-5 col-xs-2">

            <a href="javascript:window.history.back()" target="_self" class="btn btn-empty u-mt15"><i class="ion ion-android-arrow-back ion-15x"></i></a>

        </div>
        <div class="col-sm-2 col-sm-hide u-aligncenter u-pv25">
            <h2>Muhit</h2>
        </div>
        <div class="col-sm-5 col-xs-10 u-alignright u-nowrap">
            <a href="/login" class="btn btn-quaternary u-mt15 u-mr5">
                <span class="extended">
                        {{ trans('auth.log_in_cap') }}
                </span>
                <span class="condensed">
                        {{ trans('auth.log_in_short_cap') }}
                </span>
            </a>
            <a href="/login/facebook" class="btn btn-facebook u-ma5 u-mt15">
                <i class="ion ion-social-facebook ion-15x u-floatleft u-ph5"></i>
                <span class="u-floatleft u-mt5"><span class="extended">{{ trans('auth.connect_cap') }}</span></span>
            </a>
            <a href="/register" class="btn btn-primary u-mt15">
                <span class="condensed">
                    <i class="ion ion-person-add ion-15x"></i>
                </span>
                <span class="extended">
                    {{ trans('auth.sign_up_cap') }}
                </span>
            </a>
        </div>
    </div>
</nav>