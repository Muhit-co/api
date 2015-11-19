<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div id="intro_message" class="flash message u-pv10 u-mb20 u-hidden">

            <a href="javascript:void(0)" id="message_close" class="u-floatright u-ml10">
                <i class="ion ion-android-close ion-15x"></i>
            </a>

            <div class="row row-nopadding">
                <div class="col-xs-10 u-aligncenter">
                    <i class="ion ion-muhit-tea-white u-floatleft u-mr10" style="margin-top: 3px;"></i>
                    <div class="col-xs-hide">
                        <span class="message-expanded">
                            <h3 class="u-floatleft u-mr20">Muhit'e hoş geldin!</h3>
                        </span>
                    </div>
                    <a href="javascript:void(0)" id="message_expand" class="btn btn-sm btn-empty" style="margin-top: -2px;">
                        {{ trans('intro.how_does_it_work_cap') }}
                        <span class="message-expanded">
                            <i class="ion ion-chevron-down u-ml5"></i>
                        </span>
                        <span class="message-expanded u-hidden">
                            <i class="ion ion-chevron-up u-ml5"></i>
                        </span>
                    </a>
                </div>
            </div>

            <div class="message-expanded u-hidden">

                <div class="u-ph15 u-mt20">
                    <h2>{{ trans('intro.title') }}</h2>
                </div>

                <div class="row u-aligncenter u-pv20">
                    <div class="col-sm-3 col-xs-6 u-pv20">
                        <i class="ion ion-iphone ion-3x"></i>
                        <h3 class="u-mb25">{{ trans('intro.usp1_title') }}<br /><br /></h3>
                        <p class="c-white u-alignleft"><small>{{ trans('intro.usp1_text') }}</small></p>
                    </div>
                    <div class="col-sm-3 col-xs-6 u-pv20">
                        <i class="ion ion-person-stalker ion-3x"></i>
                        <h3>{{ trans('intro.usp2_title') }}<br /><br /></h3>
                        <p class="c-white u-alignleft"><small>{{ trans('intro.usp2_text') }}</small></p>
                    </div>
                    <div class="col-sm-3 col-xs-6 u-pv20">
                        <i class="ion ion-speakerphone ion-3x"></i>
                        <h3>{{ trans('intro.usp3_title') }}<br /><br /></h3>
                        <p class="c-white u-alignleft"><small>{{ trans('intro.usp3_text') }}</small></p>
                    </div>
                    <div class="col-sm-3 col-xs-6 u-pv20">
                        <i class="ion ion-paper-airplane ion-3x"></i>
                        <h3>{{ trans('intro.usp4_title') }}<br /><br /></h3>
                        <p class="c-white u-alignleft"><small>{{ trans('intro.usp4_text') }}</small></p>
                    </div>
                </div>
                <div class="row u-aligncenter u-pv10">
                    <a href="http://hikaye.muhit.co" class="btn btn-sm btn-whiteoutline">{{ trans('auth.learn_more_cap') }}</a>
                </div>

            </div>

        </div>
    </div>
</div>
