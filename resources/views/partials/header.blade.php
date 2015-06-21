<header class="<?php echo (isset($type) && $type === 'show') ? "header-show" : "header-list"; ?>">
  <div class="row u-pt40 u-pb60">
    <div class="col-md-4 col-sm-6">

    <!-- search issues -->
    <div class="form-group form-fullwidth">
      <input type="text" class="form-input" value="" placeholder="Ara..." />
      <a class="form-appendRight"><i class="ion ion-search ion-15x u-pa10"></i></a>
    </div>

    <!-- change mahalle -->
    <div class="form-group form-autosuggest form-fullwidth hasDropdown">
      <input type="text" class="form-input" value="Erenköy, Kadıköy" />
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

    </div>
    <div class="col-md-8 col-sm-6">

    <div class="u-alignright">
      <a href="/issue/new" class="btn btn-primary" data-dialog="dialog_newidea"><i class="ion ion-plus u-mr5"></i> FİKİR EKLE</a>
    </div>

    </div>
  </div>
</header>

