 <footer>
    <div class="row">
        <div class="col-sm-3 u-clearfix u-mb20">
            <a href="#top" id="nav_logo" class="u-floatleft"><img src="/images/logo_grey.png" height="30px" alt="" /></a>
            <small class="u-floatleft u-ml20" style="margin-top: 3px;">&copy; {{strftime('%Y')}}</small>
        </div>
        <div class="col-sm-3">
            <a href="//hikaye.muhit.co/" class="u-inlineblock u-pa5">
                <i class="ion ion-chatbubble ion-fw u-aligncenter u-mr5"></i>
                {{ trans('issues.muhit_story') }}
            </a>
            <br />
            <a href="//hikaye.muhit.co/kullanim-kosullari" class="u-inlineblock u-pa5">
                <i class="ion ion-document-text ion-fw u-aligncenter u-mr5"></i>
                {{ trans('issues.terms_and_conditions') }}
            </a>
        </div>
        <div class="col-sm-3">
            <a href="//hikaye.muhit.co/hakkimizda" class="u-inlineblock u-pa5">
                <i class="ion ion-person-stalker ion-fw u-aligncenter u-mr5"></i>
                {{ trans('issues.about_muhit') }}
            </a>
            <br />
            <a href="//hikaye.muhit.co/manifestomuz" class="u-inlineblock u-pa5">
                <i class="ion ion-speakerphone ion-fw u-aligncenter u-mr5"></i>
                {{ trans('issues.our_manifesto') }}
            </a>
        </div>
        <div class="col-sm-3">
            <a href="//hikaye.muhit.co/iletisim" class="u-inlineblock u-pa5">
                <i class="ion ion-paper-airplane ion-fw u-aligncenter u-mr5"></i>
                {{ trans('issues.contact') }}
            </a>
            <br />
            <a href="{{ getSupportLink() }}" class="u-inlineblock u-pa5" target="_blank">
                <i class="ion ion-bug ion-fw u-aligncenter u-mr5"></i>
                {{ trans('issues.problems_and_recommendations') }}
                <i class="ion ion-android-open u-ml5 c-light"></i>
            </a>
        </div>
    </div>
</footer>

