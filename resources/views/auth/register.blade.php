@extends('layouts.compact')
@section('content')

<section class="bg-blue u-pt50">

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form method="post" action="/register">
                <h2 class="u-mv20">Kayıt Ol</h2>

                <div class="form-group form-fullwidth u-mb20">
                    <label>Ad</label>
                    <input type="text" class="form-input" value="" name="first_name" placeholder="i.e. John" />
                </div>

                <div class="form-group form-fullwidth u-mb20">
                    <label>Soyad</label>
                    <input type="text" class="form-input" value="" name="last_name" placeholder="i.e. Doe" />
                </div>

                <div class="form-group form-fullwidth u-mb20">
                    <label>E-posta adresi</label>
                    <input type="text" class="form-input" value="" name="email" placeholder="i.e. john@example.com" />
                </div>

                <div class="form-group form-fullwidth u-mb20">
                    <label>Şifre</label>
                    <input type="password" class="form-input" value="" name="password" placeholder="min. 8 characters" />
                </div>

                <div class="form-group form-fullwidth u-mb20">
                    <label>Mahalle</label>
                    <input type="text" class="form-input" value="" name="user.hood" placeholder="Start typing your mahalle..." />
                </div>
                <div class="form-group form-fullwidth u-mt30 u-mb20">
                    <input id="termsagree" type="checkbox" class="form-input u-floatleft u-mr20" value="" name="user.agree" />
                    <label for="termsagree">I agree with the <a href="javascript:void(0)">Terms of service</a></label>
                </div>

                <button type="submit" class="btn btn-primary u-floatright">KAYIT OL</i></button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3 u-aligncenter u-pv20">

            <hr class="u-mb35" />

            <a href="javascript:void(0)" class="btn btn-facebook u-ma5"><i class="ion ion-social-facebook ion-15x u-floatleft u-ph5"></i> CONNECT</a>
            <a href="javascript:void(0)" class="btn btn-twitter u-ma5"><i class="ion ion-social-twitter u-floatleft u-pa5"></i> CONNECT</a>
            <a href="javascript:void(0)" class="btn btn-googleplus u-ma5"><i class="ion ion-social-googleplus u-floatleft u-pa5"></i> CONNECT</a>

        </div>
    </div>

</section>

@stop
