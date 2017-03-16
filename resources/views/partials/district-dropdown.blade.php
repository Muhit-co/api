<div id="district_dropdown" class="dropdown dropdown-inline dropdown-oncenter u-pv15 u-ph20 u-mb10 u-mt10">

    <a href="javascript:$('#district_dropdown').toggleClass('isOpen');">
        <i class="ion ion-android-close ion-15x u-floatright u-ml10 u-mb10"></i>
    </a>

    <h4 class="c-bluedark u-mb10">{{ trans('issues.districts') }}</h4>

    <div class="row row-nopadding">
        @foreach($all_districts as $d)
            @if($d->issues->count() > 0)
                <div class="col-md-3 col-sm-4 col-xs-6 u-truncate">
                    <a href="/?district={{ urlencode($d->name . ', ' . $d->city->name) }}" class="u-block u-lineheight20 u-pb10">
                        <?php if(isset($district) && $d->name === $district->name) { echo '<strong>'; } ?>
                        <span class="u-mr5">{{ $d->name }}</span>
                        <div class="u-sm-show"></div>
                        <small class="u-opacity75">{{ $d->city->name }}</small>
                        @if($d->issues->count() > 0)
                            <span class="c-light">({{ $d->issues->count() }})</span>
                        @endif
                        <?php if(isset($district) && $d->name === $district->name) { echo '</strong>'; } ?>
                    </a>
                </div>
            @endif
        @endforeach
    </div>

</div>