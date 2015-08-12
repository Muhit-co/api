<header class="u-relative <?php echo (isset($type) && $type === 'show') ? "header-show" : "header-list"; ?>">

    <?php if(!isset($type) || $type !== 'show'): ?>

        @if($role =='public')
            @include('partials.intro-message')
        @endif

        <div class="row">
            <div class="col-md-6 col-md-offset-1 col-sm-6">

                <h2 class="u-clearfix">
                    <!-- change mahalle -->
                    <div class="form-group form-autosuggest u-floatleft u-clearfix u-mh5" data-form-state="is-home">
                        <div class="u-floatleft u-aligncenter" style="width: 40px;">
                            <i class="form-state form-state-home ion ion-home ion-1x u-mt5"></i>
                            <i class="form-state form-state-static ion ion-location ion-15x u-hidden"></i>
                            <i class="form-state form-state-current ion ion-android-locate ion-1x u-mt5 u-hidden"></i>
                            <i class="form-state form-state-busy ion ion-load-a ion-1x u-ml10 u-mt5 ion-spinning u-hidden" style="margin-right: 7px"></i>
                        </div>
                        <input id="hood" type="text" class="form-input u-floatleft" style="width: 250px;" placeholder="Mahalleni seç..." value="{{$hood->name or ''}}" />
                        <input id="location_string" name="location" class="u-hidden" value="" />

                        @if(isset($redir) and $redir == 'list')
                            <input type="hidden" id="redir" value="list">
                        @endif
                    </div>
                    <div class="u-floatleft u-mt5"><span class="extended">{{ trans('issues.ideas_for') }}</span></div>
                    <br />
                </h2>

                <div id="location_form_message" class="form-message u-ml45 u-mb20 u-hidden">
                    <a href="javascript:void(0)" id="message_close" class="u-floatright u-ph10 u-pv5">
                        <i class="ion ion-android-close ion-15x"></i>
                    </a>
                    <span class="message"></span>
                </div>

                <h3 id="district" class="u-floatleft u-ml50 u-mb20">

                    <span class="text">
                        @if(isset($hood) and isset($hood->district))
                            {{$hood->district->name}},
                        @endif
                        @if(isset($hood) and isset($hood->district) and isset($hood->district->city))
                            {{$hood->district->city->name}}
                        @endif
                    </span>

                    @if(isset($hood) and isset($hood->district))
                    <a href="/report" class="btn btn-sm btn-whiteoutline u-ml15 u-has-hidden-content">
                        <i class="ion ion-clipboard"></i>
                        <span class="u-show-on-hover u-ml5">İlçe raporu <i class="ion ion-arrow-right-b u-ml5"></i></span>
                    </a>
                    @endif

                </h3>

            </div>
            <div class="col-md-4 col-sm-6 u-clearfix">

                <!-- use current location -->
                <div class="u-floatleft u-mr20">
                    <input type="checkbox" id="current_location" value="" class="u-floatleft u-mr20" >
                    <label for="current_location" class="btn btn-whiteoutline"><i class="ion ion-android-locate ion-15x"></i></label>
                </div>

                @if(Auth::check() and isset(Auth::user()->hood_id) and Auth::user()->hood_id > 0)
                    <!-- use profile home location -->
                    <div class="u-floatleft u-mr10">
                        <a href="/fikirler/{{Auth::user()->hood_id}}"   class="btn btn-whiteoutline"><i class="ion ion-home ion-15x"></i></a>
                    </div>
                @endif

                <!-- search issues -->
                <!-- <div class="form-group form-fullwidth">
                    <input type="text" class="form-input" value="" placeholder="Ara..." />
                    <a class="form-appendRight"><i class="ion ion-search ion-15x u-pa10"></i></a>
                </div> -->

                @if($role =='public')
                <a href="javascript:void(0)" data-dialog="dialog_login" class="btn btn-primary u-floatright"><i class="ion ion-plus u-mr5"></i> FİKİR <span class="extended">EKLE</span></a>
                @elseif($role =='user')
                    <a href="/issues/new" class="btn btn-primary u-floatright"><i class="ion ion-plus u-mr5"></i> FİKİR <span class="extended">EKLE</span></a>
                @endif
            </div>
        </div>

        <div class="row"> <!-- u-pinned-bottom -->
            <div class="col-md-10 col-md-offset-1">
                <!-- Sorting tabs for issue list -->
                <ul class="tabs">
                    <li>
                        <a href="/{{Request::path()}}?sort=latest" <?php echo ((isset($active_tab) and $active_tab == 'latest') ? 'class="active"' : ''); ?> >
                            EN SON
                        </a>
                    </li>
                    <li>
                        <a href="/{{Request::path()}}?sort=popular" <?php echo ((isset($active_tab) and $active_tab == 'popular') ? 'class="active"' : ''); ?>>
                            POPÜLER
                        </a>
                    </li>
                    <li>
                        <a href="/map" <?php echo ((isset($active_tab) and $active_tab == 'map') ? 'class="active"' : ''); ?>>
                            HARİTA
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    <?php endif; ?>

</header>

