@extends('layouts.default')
@section('content')

<section class="profile-edit">
    <div class="row u-pv20">

        <div class="col-md-8 col-md-offset-2">
            <div class="card u-mt0">
                <div class="card-header u-clearfix">
                    <h2 class="u-mt5">
                        Profil düzenleme
                    </h2>
                </div>
                <div class="card-content">

                    <form method="post" action="/members/update">

                        <div class="form-group form-fullwidth u-mt10">
                            <label>{{ trans('auth.first_name') . ' + ' . trans('auth.last_name') }}</label>
                            <div class="row" style="margin-left: -15px; margin-right: -15px;">
                                <div class="col-sm-6 u-mb10">
                                    <input type="text" class="form-input form-grey" value="{{ $user['first_name']  }}" name="first_name" placeholder="First name..." />
                                </div>
                                <div class="col-sm-6 u-mb10">
                                    <input type="text" class="form-input form-grey" value="{{$user['last_name']}}" name="last_name" placeholder="Last name..." />
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-fullwidth u-mv10">
                            <label>{{ trans('auth.email_address') }}</label>
                            <input type="text" class="form-input form-grey" value="{{$user['email']}}" name="email" placeholder="{{ trans('auth.email_address_placeholder') }}" />
                        </div>

                        <div class="form-group form-fullwidth u-mv10">
                            <label>{{ trans('auth.password') }}</label>
                            <input type="password"  class="form-input form-grey" name="password" placeholder="{{ trans('auth.password_placeholder') }}" />
                        </div>

                        <label class="u-mt20">{{ trans('issues.neighbourhood') }}</label>
                        <?php $state = ($role == 'admin') ?>
                        <?php $value = (isset($user['hood'])) ? $user['hood']['name'] . ", " . $user['hood']['district']['name'] . ", " . $user['hood']['district']['city']['name'] : '' ?>
                        @include('partials.field-hood', array(
                            'inputClassList' => 'form-grey', 
                            'defaultValue' => $value,
                            'disabledState' => $state))

                        @if($state !== true)
                            <div class="form-group u-relative u-mv10">
                                <input type="hidden" id="coordinates" value="" name="coordinates">
                                <input type="checkbox" id="current_location" value="" class="u-floatleft u-mr20" >
                                <label for="current_location">{{ trans('issues.use_my_location') }}</label>
                            </div>
                        @else
                            <p class="c-medium"><small><em>{!! trans('auth.cant_change_mahalle', ['tagstart' => '<a href="' . getSupportLink() . '" target="_blank">', 'tagend' => '</a>']) !!}</em></small></p>
                        @endif

                        <hr>

                        <div class="u-alignright">
                            <a href="javascript:window.history.back()" class="btn btn-outline u-mr10">
                                {{ trans('auth.cancel_cap') }}
                            </a>
                            <button type="submit" class="btn btn-secondary">
                                {{ trans('auth.save_cap') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</section>

@stop
