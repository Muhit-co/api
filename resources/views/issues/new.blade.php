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

                <div class="form-group u-relative u-mv10">
                    <input type="hidden" id="coordinates" value="" name="coordinates">
                    <input type="checkbox" id="current_location" value="" class="u-floatleft u-mr20" >
                    <label for="current_location">Yerimi belirle</label>
                </div>

                <!-- Mahalle -->
                <div class="form-group form-fullwidth hasDropdown hasIconRight" data-form-state="">
                    <div class="form-appendRight u-aligncenter u-mt5" style="width: 40px;">
                        <i class="form-state form-state-home ion ion-home ion-1x u-mt5 u-hidden"></i>
                        <i class="form-state form-state-static ion ion-location ion-15x u-hidden"></i>
                        <i class="form-state form-state-current ion ion-android-locate ion-1x u-mt5 u-hidden"></i>
                        <i class="form-state form-state-busy ion ion-load-a ion-1x u-ml10 u-mt5 ion-spinning u-hidden" style="margin-right: 7px"></i>
                    </div>
                    <input type="text" class="form-input" id="location_string" name="location" placeholder="Erenköy, Kadıköy" />
                </div>

                <div class="form-group form-fullwidth u-mv20">
                    <label>Etiketler <i class="u-opacity50">(max 3)</i></label>
                    @foreach($tags as $t)
                        <input type="checkbox" id="tag-{{$t->id}}" name="tags[]" value="{{$t->id}}" class="u-floatleft u-mr20">
                        <label class="tag u-mb10" for="tag-{{$t->id}}" style="background-color:#{{$t->background}}">{{$t->name}}</label>
                    @endforeach

                </div>

                <div class="form-group form-fullwidth u-mv20">
                    <label>Resimler <i class="u-opacity50">(max 5)</i></label>
                    <div class="add-images">
                        <div id="image_preview" class="u-floatleft"></div>
                        <div class="badge badge-image u-relative">
                            <i class="ion u-pt30 u-noselect"><strong>Sec...</strong></i>
                            <input type="file" id="image_input" name="images[]" class="u-pinned-cover" style="z-index: 2" accept="image/jpg, image/png, image/jpeg" multiple="multiple" />
                        </div>
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
