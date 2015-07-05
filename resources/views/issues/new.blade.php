@extends('layouts.default')
@section('content')

<section>

    <div class="row u-pt20 u-pb50">

        <div class="col-md-10 col-md-offset-1">
            <form method="post" action="/issues/add">
                <div class="form-group form-fullwidth u-mv20">
                    <label>Başlık</label>
                    <input type="text" class="form-input" value="" name="title" placeholder="Yazin..." />
                </div>

                <div class="form-group form-fullwidth u-mv20">
                    <label>Açıklama</label>
                    <textarea class="form-input" value="" name="desc" placeholder="Yazin..." rows="3"></textarea>
                </div>

                <div class="form-group u-mv10">
                    <input type="checkbox" id="location" value="" class="u-floatleft u-mr20" >
                    <label for="location">Yerimi belirle</label>
                </div>

                <!-- Mahalle -->
                <div class="form-group form-autosuggest form-fullwidth hasDropdown">
                    <input type="text" class="form-input form-disabled" id="location_string" name="location"  placeholder="Erenköy, Kadıköy" />

                </div>

                <div class="form-group form-fullwidth u-mv20">
                    <label>Etiketler <span class="u-opacity50">(max 3)</span></label>
                    @foreach($tags as $t)
                        <input type="checkbox" id="tag-{{$t->id}}" name="tags[]" value="{{$t->id}}" class="u-floatleft u-mr20">
                        <label class="tag u-mb10" for="tag-{{$t->id}}" style="background-color:#{{$t->background}}">{{$t->name}}</label>
                    @endforeach


                </div>

                <div class="form-group form-fullwidth u-mv20">
                    <div class="add-images">
                        <label>Resimler</label>
                        <div class="badge badge-image u-mr5" style="background-image: url('../images/street_thumbnail.jpg')"><a href="badge-close"><i class="ion ion-close u-pt10 c-white"></i></a></div>
                        <div class="badge badge-image u-mr5 u-pt10" style="background-image: url('../images/street_thumbnail.jpg')"><i class="ion ion-load-a ion-spinning c-white"></i></div>
                        <div class="badge badge-image u-mr5"><a href="badge-close"><i class="ion ion-plus ion-15x u-pt5"></i></a></div>
                    </div>
                </div>

                <div class="form-group u-mv10">
                    <input type="checkbox" id="anonymous" name="is_anonymous" value="1" class="u-floatleft u-mr20">
                    <label for="anonymous">Anonim olarak başvuru yap</label>
                </div>

                <hr>

                <div class="u-alignright">
                    <a href="javascript:void(0)" id="closeDialog" class="btn btn-tertiary u-mr10">VAZGEÇ</a>
                    <button type="submit" class="btn btn-secondary">KAYDET</button>
                </div>
            </form>
        </div>
    </div>
</section>

@stop
