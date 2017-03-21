<?php
$inputClassList = (isset($inputClassList)) ? $inputClassList : '';
$disabledState = (isset($disabledState) && $disabledState === true) ? 'disabled ' : '';

// hood name + district name + city name
$defaultValue = (isset($defaultValue)) ? $defaultValue : '';
if(strlen(Input::old('location')) > 0) {
  $defaultValue = Input::old('location');
}
$defaultValueArray = explode(',', $defaultValue);
$defaultValueHood = $defaultValueArray[0];
$defaultValueDistrict = (isset($defaultValueArray[1])) ? $defaultValueArray[1] . ', ' : '';
$defaultValueCity = (isset($defaultValueArray[2])) ? $defaultValueArray[2] : '';

// set location form state (icon)
$location_form_state = (strlen($defaultValue) > 0) ? 'is-static' : 'is-empty';

?>
{{-- Choose mahalle (location) field --}}
<div class="form-group form-fullwidth hasDropdown hasIconRight u-mb0" data-form-state="{{ $location_form_state }}">
    <div class="form-appendRight u-aligncenter u-mt5" style="width: 40px;">
        <i class="form-state form-state-home ion ion-home ion-1x u-mt5"></i>
        <i class="form-state form-state-static ion ion-location ion-15x"></i>
        <i class="form-state form-state-current ion ion-android-locate ion-1x u-mt5"></i>
        <i class="form-state form-state-busy ion ion-load-a ion-1x u-ml10 u-mt5 ion-spinning" style="margin-right: 7px"></i>
    </div>
    <input id="hood" type="text" class="form-input u-floatleft {{ $inputClassList }}" placeholder="{{ trans('auth.choose_hood_form') }}" value="{{ $defaultValueHood }}" required {{ $disabledState }} data-allow-districts="false" />
    <input id="location_string" value="{{ $defaultValue }}" name="location" class="u-hidden" />
</div>
<div id="location_form_message" class="form-message u-mb20 u-mt5 bg-bluedark" style="display: none;">
    <a href="javascript:void(0)" id="message_close" class="u-floatright u-ph10">
        <i class="ion ion-android-close ion-15x c-white"></i>
    </a>
    <span class="message"></span>
</div>

<small class="u-block u-ml10 u-opacity50 u-mb20 u-lineheight20">

    <span id="district">{{ $defaultValueDistrict }}</span><span id="city">{{ $defaultValueCity }}</span>

</small>
