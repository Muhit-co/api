@extends('layouts.compact')
@section('content')

<section class="login u-pt50">

  <div class="row u-pv50">
    <div class="col-md-6 col-md-offset-3">

      <h2 class="u-mv20">Giriş yap</h2>

      <div class="form-group form-fullwidth u-mb20">
        <input type="text" class="form-input" value="" placeholder="Kullanıcı adı" />
      </div>

      <div class="form-group form-fullwidth u-mb20">
        <input type="password" class="form-input" value="" placeholder="Şifre" />
      </div>

      <a href="javascript:void(0)" class="btn btn-primary u-floatright">GİRİŞ YAP <i class="ion ion-log-in ion-15x"></i></a>

    </div>
  </div>

  <div class="row">
    <div class="col-md-6 col-md-offset-3 u-aligncenter u-pv20">
    
      <em>veya</em>
      <br />
      <br />

      <a href="" ng-click='login();' class="btn btn-facebook u-mr10"><i class="ion ion-social-facebook ion-15x"></i> CONNECT</a>
      <a href="javascript:void(0)" class="btn btn-twitter u-mr10"><i class="ion ion-social-twitter"></i> CONNECT</a>

    </div>
  </div>

</section>

@stop
