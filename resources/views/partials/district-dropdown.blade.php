<div id="district_dropdown" class="dropdown dropdown-inline dropdown-notriangle u-pb15 u-pt5 u-ph20 u-mb10 u-mt10">

    <span class="dropdown-triangle" style="left: 60%;"></span>

    <a href="javascript:$('#district_dropdown').toggleClass('isOpen');" class="u-pinned-topright u-pa15" style="z-index: 2;">
        <i class="ion ion-android-close ion-15x"></i>
    </a>

    <div class="row row-nopadding">
        @foreach($all_districts as $d)
            <?php
            if (!isset($currentCity) || $currentCity !== $d->city_name) :
                echo '<h4 class="col-xs-12 c-light u-mt10 u-mb5">' .  $d->city_name . '</h4>';
            endif;
            ?>
            <div class="col-md-3 col-sm-4 col-xs-6">
                <a href="/fikirler?{{ buildRelativeUrl('district', $d->name . ', ' . $d->city_name, 'location' ) }}" class="u-block u-lineheight20 u-pb10 u-truncate" title="{{ $d->name . ', ' . $d->city_name }}">
                    <?php if(isset($district) && $d->name === $district->name) { echo '<strong>'; } ?>
                    <span class="u-mr5">{{ $d->name }}</span>
                    <span class="c-light">({{ $d->issue_count }})</span>
                    <?php if(isset($district) && $d->name === $district->name) { echo '</strong>'; } ?>
                </a>
            </div>

            <?php $currentCity = $d->city_name; ?>
        @endforeach
    </div>

</div>