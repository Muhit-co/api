<header class="u-relative <?php echo (isset($type) && $type === 'show') ? "header-show" : "header-list"; ?>">

    @if(!isset($type) || $type !== 'show')

        @if($role =='public')
            @include('partials.intro-message')
        @endif

        <div class="row u-pv10">
            <div class="col-md-6 col-md-offset-1 col-sm-6">

                <h2 class="u-clearfix">
                    <!-- change mahalle -->
                    <div class="{{ (App::getLocale() == 'en') ? 'u-floatleft' : 'u-inlineblock' }} u-mt5"><span class="extended">{{ trans('issues.ideas_for') }}</span></div>
                        <?php
                        $loc_value = '';
                        $form_state = 'is-home';
                        if(isset($hood->name)) {
                            $loc_value = $hood->name;
                            $form_state = 'is-static';
                        } else if(isset($district)) {
                            $loc_value = $district->name;
                            $form_state = 'is-district';
                        }
                        ?>
                    <div class="form-group form-autosuggest u-floatleft u-clearfix u-mh5 u-mb0" data-form-state="{{ $form_state }}">
                        <div class="u-floatleft u-aligncenter" style="width: 40px;">
                            <i class="form-state form-state-home ion ion-home ion-1x u-mt5"></i>
                            <i class="form-state form-state-static ion ion-ios-location u-mt5"></i>
                            <i class="form-state form-state-current ion ion-android-locate u-mt5"></i>
                            <i class="form-state form-state-district ion ion-android-compass u-mt10"></i>
                            <i class="form-state form-state-busy ion ion-load-a ion-1x u-ml10 u-mt5 ion-spinning" style="margin-right: 7px"></i>
                        </div>
                        <input id="hood" type="text" class="form-input u-floatleft{{ (isset($hood->name) && strlen($hood->name) > 20) ? ' form-smallfont' : '' }}" style="width: 250px;" placeholder="{{ trans('issues.choose_hood_header') }}" value="{{ $loc_value }}" />
                        <input id="location_string" name="location" class="u-hidden" value="" />

                        @if(isset($redir) and $redir == 'list')
                            <input type="hidden" id="redir" value="list">
                        @endif
                    </div>
                    <br />
                </h2>

                <div id="location_form_message" class="form-message u-ml45 u-mb20" style="display: none;">
                    <a href="javascript:void(0)" id="message_close" class="u-floatright u-ph10">
                        <i class="ion ion-android-close ion-15x"></i>
                    </a>
                    <span class="message"></span>
                </div>

                <h4 class="u-ml60 u-opacity75" style="min-height: 26px;">

                    <span id="district">
                        @if(isset($hood))
                            <a href="/fikirler?{{ buildRelativeUrl('district', $hood->district->name . ', ' . $hood->district->city->name, 'location' ) }}" class="c-white" style="text-decoration: underline;">
                                {{$hood->district->name}}
                            </a>,
                        @endif
                    </span><span id="city">
                        @if(isset($hood->district))
                            {{$hood->district->city->name}}
                        @elseif(isset($district))
                            {{$district->city->name}}
                        @endif
                    </span>

                </h4>

            </div>
            <div class="col-md-4 col-sm-6 u-clearfix">

                <div class="hasDropdown u-inlineblock u-mt5">
                    <a href="javascript:void(0)" id="district_dropdown_btn" onclick="$('#district_dropdown').toggleClass('isOpen');" class="btn btn-sm <?php if(isset($district)) { echo 'btn-white'; } else { echo 'btn-whiteoutline'; } ?>">
                        {{ trans('issues.districts_cap') }}
                        <i class="ion ion-chevron-down u-ml5"></i>
                    </a>
                </div>

                <!-- use current location -->
                {{-- <div class="u-floatleft u-mr20">
                    <input type="checkbox" id="current_location" value="" class="u-floatleft u-mr20" >
                    <label for="current_location" class="btn btn-whiteoutline"><i class="ion ion-android-locate ion-15x"></i></label>
                </div> --}}

                @if(Auth::check() and isset(Auth::user()->hood_id) and Auth::user()->hood_id > 0)
                    <!-- use profile home location -->
                    {{-- <div class="u-floatleft u-mr10">
                        <a href="/fikirler/{{Auth::user()->hood_id}}"   class="btn btn-whiteoutline"><i class="ion ion-home ion-15x"></i></a>
                    </div> --}}
                @endif

                <!-- search issues -->
                <!-- <div class="form-group form-fullwidth">
                    <input type="text" class="form-input" value="" placeholder="Ara..." />
                    <a class="form-appendRight"><i class="ion ion-search ion-15x u-pa10"></i></a>
                </div> -->

                <div class="u-floatright">
                    @include('partials.add_idea_button', array('hood' => $hood))
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                @include('partials.district-dropdown', ['all_districts' => $all_districts, 'district' => $district])

                @include('partials.issue-list-tabs', array('active_tab' => (isset($_GET['sort'])) ? $_GET['sort'] : 'latest' ))
            </div>
        </div>

    @endif

</header>

