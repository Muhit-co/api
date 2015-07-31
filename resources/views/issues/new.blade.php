@extends('layouts.default')
@section('content')

<section>

    <div class="row u-pt20 u-pb50">

        <div class="col-md-10 col-md-offset-1">
            <form method="post" action="/issues/add">
                <div class="form-group form-fullwidth u-mv10">
                    <label>{{ trans('issues.title') }}</label>
                    <input type="text" class="form-input" value="" name="title" placeholder="{{ trans('issues.your_idea_title') }}..." />
                </div>

                <div class="form-group form-fullwidth u-mv10">
                    <label>{{ trans('issues.problem') }}</label>
                    <textarea class="form-input" value="" name="problem" placeholder="{{ trans('issues.what_is_wrong') }}?" rows="1"></textarea>
                </div>

                <div class="form-group form-fullwidth u-mv10">
                    <label>{{ trans('issues.solution') }}</label>
                    <textarea class="form-input" value="" name="solution"  placeholder="{{ trans('issues.idea_for_improving_descr') }}?" rows="3"></textarea>
                </div>

                <label class="u-mt20">{{ trans('issues.neighbourhood') }}</label>
                @include('partials.field-hood')

                <div class="form-group u-relative u-mv10">
                    <input type="hidden" id="coordinates" value="" name="coordinates">
                    <input type="checkbox" id="current_location" value="" class="u-floatleft u-mr20" >
                    <label for="current_location">{{ trans('issues.use_my_location') }}</label>
                </div>

                <div class="form-group form-fullwidth u-mv10">
                    <label>{{ trans('issues.tags') }} <i class="u-opacity50">(max 3)</i></label>
                    @foreach($tags as $t)
                        <input type="checkbox" id="tag-{{$t->id}}" name="tags[]" value="{{$t->id}}" class="u-floatleft u-mr20">
                        <label class="tag u-mb10" for="tag-{{$t->id}}" style="background-color:#{{$t->background}}">{{$t->name}}</label>
                    @endforeach

                </div>

                <div class="form-group form-fullwidth u-mv10">
                    <label>{{ trans('issues.images') }} <i class="u-opacity50">(max 3)</i></label>
                    <div class="add-images">

                        <!-- Preview images & form data -->
                        <div id="issue_images" class="u-floatleft">
                        </div>

                        <!-- Add image button -->
                        <div class="badge badge-image u-relative">
                            <i class="ion ion-plus ion-2x u-pt5"></i>
                            <!-- <i class="ion u-pt30 u-noselect"><strong>Sec...</strong></i> -->
                            <input type="file" id="image_input" class="u-pinned-cover" style="z-index: 2" accept="image/jpg, image/png, image/jpeg" multiple="multiple" />
                        </div>

                    </div>
                </div>

                <div class="form-group u-mv10">
                    <input type="checkbox" id="anonymous" name="is_anonymous" value="1" class="u-floatleft u-mr20">
                    <label for="anonymous">{{ trans('issues.submit_anonymously') }}</label>
                </div>

                <hr>

                <div class="u-alignright">
                    <a href="javascript:window.history.back()" class="btn btn-tertiary u-mr10">{{ trans('auth.cancel_cap') }}</a>
                    <button type="submit" onclick="addIsBusy($(this))" class="btn btn-secondary">{{ trans('auth.save_cap') }}</button>
                </div>
            </form>
        </div>
    </div>
</section>

@stop
