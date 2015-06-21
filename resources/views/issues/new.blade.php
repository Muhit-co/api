@extends('layouts.default')
@section('content')

<section>

  <div class="row">

    <div class="col-md-10 col-md-offset-1">

      <div class="form-group form-fullwidth u-mv20">
      <label>Başlık</label>
      <input type="text" class="form-input" value="" placeholder="Yazin..." />
    </div>

    <div class="form-group form-fullwidth u-mv20">
      <label>Açıklama</label>
      <textarea class="form-input" value="" placeholder="Yazin..." rows="3"></textarea>
    </div>

    <div class="form-group u-mv10">
      <input type="checkbox" id="location" value="" class="u-floatleft u-mr20" checked>
      <label for="location">Yerimi belirle</label>
    </div>

    <!-- Mahalle -->
    <div class="form-group form-autosuggest form-fullwidth hasDropdown">
      <input type="text" class="form-input form-disabled" disabled value="Erenköy, Kadıköy" />
      <a class="form-appendRight"><i class="ion ion-chevron-down u-pa15"></i></a>
      <div class="dropdown u-fullWidth">
      <ul>
        <li><a href="#"><b>Alt</b>ınşehir, Başakşehir</a></li>
        <li><a href="#">Kart<b>alt</b>epe, Bakırköy</a></li>
        <li><a href="#"><b>Alt</b>ıntepsi, Bayrampaşa</a></li>
        <li><a href="#">Kart<b>alt</b>epe, Küçükçekmece</a></li>
        <li><a href="#"><b>Alt</b>ayçeşme, M<b>alt</b>epe</a></li>
        <li><a href="#"><b>Alt</b>ıntepe, M<b>alt</b>epe</a></li>
        <li><a href="#" class="light">Daha yukle...</a></li>
      </ul>
      </div>
    </div>

    <div class="form-group form-fullwidth u-mv20">
      <label>Etiketler <span class="u-opacity50">(max 3)</span></label>
      <span class="tag bg-tag-lightgreen u-mb10">AĞAÇLANDIRMA <a href="javascript:void(0)" class="tag-close u-pl10 u-ml5"><i class="ion ion-close ion-x"></i></a></span><br />
      <select>
        <option>Etiketler</option>
        <option>Etiketler</option>
        <option>Etiketler</option>
      </select>
    </div>

    <div class="form-group form-fullwidth u-mv20">
      <label>Resimler</label>
      <div class="badge badge-image u-mr5" style="background-image: url('images/street.jpg')"><a href="badge-close"><i class="ion ion-close u-pt10 c-white"></i></a></div>
      <div class="badge badge-image u-mr5" style="background-image: url('images/street.jpg')"><a href="badge-close"><i class="ion ion-close u-pt10 c-white"></i></a></div>
      <div class="badge badge-image u-mr5"><a href="badge-close"><i class="ion ion-plus ion-15x u-pt5"></i></a></div>
    </div>

    <div class="form-group u-mv10">
      <input type="checkbox" id="anonymous" value="" class="u-floatleft u-mr20">
      <label for="anonymous">Anonim olarak başvuru yap</label>
    </div>

    <hr>

    <div class="u-alignright">
      <a href="javascript:void(0)" id="closeDialog" class="btn btn-tertiary u-mr10">VAZGEÇ</a>
      <a href="javascript:void(0)" class="btn btn-secondary">KAYDET</a>
    </div>
    
  </div>
</section>