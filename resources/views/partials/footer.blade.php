 <footer>
    <div class="row">
        <div class="col-sm-3 u-clearfix u-mb20">
            <div class="u-clearfix">
                <a href="#top" id="nav_logo" class="u-floatleft">
                    @include('partials.logo_svg', array('height' => '30px', 'colour' => 'grey'))
                </a>
            </div>
            <div class="u-clearfix u-pa5">
                @include('partials.lang-switcher', ['state' => 'expanded'])
            </div>
        </div>
        <div class="col-sm-3">
            <a href="{{ getStoryLink() }}" class="u-inlineblock u-pa5">
                <i class="ion ion-chatbubble ion-fw u-aligncenter u-mr5"></i>
                {{ trans('issues.muhit_story') }}
            </a>
            <br />
            <a href="{{ getStoryLink('kullanim-kosullari') }}" class="u-inlineblock u-pa5">
                <i class="ion ion-document-text ion-fw u-aligncenter u-mr5"></i>
                {{ trans('issues.terms_and_conditions') }}
            </a>
        </div>
        <div class="col-sm-3">
            <a href="{{ getStoryLink('hakkimizda') }}" class="u-inlineblock u-pa5">
                <i class="ion ion-person-stalker ion-fw u-aligncenter u-mr5"></i>
                {{ trans('issues.about_muhit') }}
            </a>
            <br />
            <a href="{{ getStoryLink('manifestomuz') }}" class="u-inlineblock u-pa5">
                <i class="ion ion-speakerphone ion-fw u-aligncenter u-mr5"></i>
                {{ trans('issues.our_manifesto') }}
            </a>
        </div>
        <div class="col-sm-3">
            <a href="{{ getStoryLink('iletisim') }}" class="u-inlineblock u-pa5">
                <i class="ion ion-paper-airplane ion-fw u-aligncenter u-mr5"></i>
                {{ trans('issues.contact') }}
            </a>
            <br />
            <a href="{{ getSupportLink() }}" class="u-inlineblock u-pa5" target="_blank">
                <i class="ion ion-bug ion-fw u-aligncenter u-mr5"></i>
                {{ trans('issues.technical_problems') }}
                <i class="ion ion-android-open u-ml5 c-light"></i>
            </a>
        </div>
    </div>
</footer>

