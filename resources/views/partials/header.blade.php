<header class="bg-blue <?php echo (isset($type) && $type === 'show') ? "header-show" : "header-list"; ?>">

    <?php if(!isset($type) || $type !== 'show'): ?>
        <div class="row">
            <div class="col-md-4 col-md-offset-1 col-sm-6">

                <!-- change mahalle -->
                <div class="form-group form-autosuggest form-fullwidth hasDropdown hasIconLeft">
                    <input id="location_string" name="location" type="text" class="form-input" placeholder="Mahalleni seç..." />
                    <div class="form-appendLeft u-aligncenter" style="width: 40px;">
                        <i class="form-state-static ion ion-location ion-2x c-blue"></i>
                        <i class="form-state-current ion ion-android-locate ion-15x u-mt5 c-blue u-hidden"></i>
                        <i class="form-state-working ion ion-load-a ion-15x u-ml10 u-mt5 ion-spinning c-blue u-hidden" style="margin-right: 7px"></i>
                    </div>
                </div>

            </div>
            <div class="col-md-3">

                <!-- use current location -->
                <div class="u-floatleft u-mr20">
                    <input type="checkbox" id="location" value="" class="u-floatleft u-mr20" >
                    <label for="location" class="btn btn-whiteoutline"><i class="ion ion-android-locate ion-15x"></i></label>
                </div>

                <!-- use profile home location -->
                <div class="u-floatleft u-mr10">
                    <a href="javascript:void(0)" for="home_location" class="btn btn-whiteoutline"><i class="ion ion-home ion-15x"></i></a>
                </div>
                
                <!-- search issues -->
                <!-- <div class="form-group form-fullwidth">
                    <input type="text" class="form-input" value="" placeholder="Ara..." />
                    <a class="form-appendRight"><i class="ion ion-search ion-15x u-pa10"></i></a>
                </div> -->

            </div>
            <div class="col-sm-3 col-sm-6">
                <div class="u-alignright">
                    <!-- @TODO: @gcg button should only be visible to normal user logged in and public; not formuhtar -->
                    <a href="/issues/new" class="btn btn-primary"><i class="ion ion-plus u-mr5"></i> FİKİR EKLE</a>
                </div>
            </div>
        </div>
    <?php endif; ?>

</header>

