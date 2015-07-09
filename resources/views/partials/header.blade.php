<header class="u-relative bg-blue <?php echo (isset($type) && $type === 'show') ? "header-show" : "header-list"; ?>">

    <?php if(!isset($type) || $type !== 'show'): ?>

        @if(!Auth::check())
        <div class="row">
            <div class="col-md-10 col-md-offset-1 u-pt20 u-ph0">
                <div class="u-ph15">
                    <h2>Mahallenin Mahalleni değiştirmek senin elinde.</h2>
                    <h3 style="font-weight: normal;">Nasıl çalışıyor?</h3>
                </div>

                <div class="row u-aligncenter u-pv20 u-">
                    <div class="col-sm-3 col-xs-6 u-pv20">
                        <i class="ion ion-iphone ion-3x"></i>
                        <h3 class="u-mb20">Fikir Yarat<br /><br /></h3>
                        <p class="c-white u-alignleft"><small>Mahalleni geliştirmek için kolayca önerilerini paylaşabilirsin. İstersen bunu anonim olarak yapabilirsin.</small></p>
                    </div>
                    <div class="col-sm-3 col-xs-6 u-pv20">
                        <i class="ion ion-person-stalker ion-3x"></i>
                        <h3 class="u-mb20">Beğendiğin Fikirleri Destekle</h3>
                        <p class="c-white u-alignleft"><small>Mahallenin uygulanmasını istediği fikirler öncelikli projeler olarak ilgili kurumlara iletilir.</small></p>
                    </div>
                    <div class="col-sm-3 col-xs-6 u-pv20">
                        <i class="ion ion-speakerphone ion-3x"></i>
                        <h3 class="u-mb20">Mahallenden Haberdar Ol</h3>
                        <p class="c-white u-alignleft"><small>Muhtardan ve belediyeden gelen duyurulara kolayca erişebilirsin.</small></p>
                    </div>
                    <div class="col-sm-3 col-xs-6 u-pv20">
                        <i class="ion ion-paper-airplane ion-3x"></i>
                        <h3 class="u-mb20">Muhtarına Kolayca Ulaş</h3>
                        <p class="c-white u-alignleft"><small>Muhtarının ve ilgili belediye kurumlarının iletişim bilgilerine kolayca ulaşabilirsin.</small></p>
                    </div>
                </div>

            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-md-4 col-md-offset-1 col-sm-6">

                <!-- change mahalle -->
                <div class="form-group form-autosuggest form-fullwidth hasIconLeft" data-form-state="is-home">
                    <input id="location_string" name="location" type="text" class="form-input" placeholder="Mahalleni seç..." />
                    <div class="form-appendLeft u-aligncenter" style="width: 40px;">
                        <i class="form-state form-state-home ion ion-home ion-15x u-mt5 c-blue"></i>
                        <i class="form-state form-state-static ion ion-location ion-2x c-blue u-hidden"></i>
                        <i class="form-state form-state-current ion ion-android-locate ion-15x u-mt5 c-blue u-hidden"></i>
                        <i class="form-state form-state-busy ion ion-load-a ion-15x u-ml10 u-mt5 ion-spinning c-blue u-hidden" style="margin-right: 7px"></i>
                    </div>
                </div>

            </div>
            <div class="col-md-6 col-sm-6 u-clearfix">

                <!-- use current location -->
                <div class="u-floatleft u-mr20">
                    <input type="checkbox" id="location" value="" class="u-floatleft u-mr20" >
                    <label for="location" class="btn btn-whiteoutline"><i class="ion ion-android-locate ion-15x"></i></label>
                </div>

                <!-- use profile home location -->
                <div class="u-floatleft u-mr10">
                    <a href="javascript:void(0)" id="home_location" data-val="Firuzağa Mahallesi, Beyoğlu, Turkey" class="btn btn-whiteoutline"><i class="ion ion-home ion-15x"></i></a>
                </div>
                
                <!-- search issues -->
                <!-- <div class="form-group form-fullwidth">
                    <input type="text" class="form-input" value="" placeholder="Ara..." />
                    <a class="form-appendRight"><i class="ion ion-search ion-15x u-pa10"></i></a>
                </div> -->

                <!-- @TODO: @gcg button should only be visible to normal user logged in and public; not formuhtar -->
                <a href="/issues/new" class="btn btn-primary u-floatright"><i class="ion ion-plus u-mr5"></i> FİKİR <span class="extended">EKLE</span></a>

            </div>
        </div>

        <div class="row"> <!-- u-pinned-bottom -->
            <div class="col-md-10 col-md-offset-1">
                <!-- Sorting tabs for issue list -->
                <ul class="tabs">
                    <li>
                        <a href="javascript:void(0)" class="active" data-target="latest">
                            EN SON
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" data-target="popular">
                            POPÜLER
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" data-target="map">
                            HARİTA
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    <?php endif; ?>

</header>

