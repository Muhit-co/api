<?php
$inputClassList = (isset($inputClassList)) ? $inputClassList : '';
$disabledState = (isset($disabledState) && $disabledState === true) ? 'disabled ' : '';
// hood name + district name + city name
$defaultValue = (isset($defaultValue)) ? $defaultValue : '';
if(strlen(Input::old('location')) > 0) {
  $defaultValue = Input::old('location');
}
$defaultValueHood = explode(',', $defaultValue)[0];
$location_form_state = 'is-empty';
if(strlen($defaultValue) > 0) {
  $location_form_state = 'is-static';
}
?>
{{-- Choose mahalle (location) field --}}
<div class="form-group form-fullwidth hasDropdown hasIconRight" data-form-state="{{ $location_form_state }}">
    <div class="form-appendRight u-aligncenter u-mt5" style="width: 40px;">
        <i class="form-state form-state-home ion ion-home ion-1x u-mt5"></i>
        <i class="form-state form-state-static ion ion-location ion-15x"></i>
        <i class="form-state form-state-current ion ion-android-locate ion-1x u-mt5"></i>
        <i class="form-state form-state-busy ion ion-load-a ion-1x u-ml10 u-mt5 ion-spinning" style="margin-right: 7px"></i>
    </div>
    <input id="hood" type="text" class="form-input u-floatleft {{ $inputClassList }}" placeholder="Mahalleni seç..." value="{{ $defaultValueHood }}" required {{ $disabledState }}/>
    <input id="location_string" value="{{ $defaultValue }}" name="location" class="u-hidden" />
</div>
