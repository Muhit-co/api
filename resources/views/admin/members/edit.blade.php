@extends('layouts.default')
@section('content')

<section class="profile-edit">
    <div class="row u-pv20">

        <div class="col-md-8 col-md-offset-2">
            <div class="card u-mt0">
                <div class="card-header u-clearfix">
                    <h2 class="u-mt5">
                        Edit user
                    </h2>
                </div>
                <div class="card-content">

                    <form method="post" action="/admin/save-member">
                        <input type="hidden" name="id" value="{{$member['id']}}">
                        <div class="form-group form-fullwidth u-mt10">
                            <label>{{ trans('auth.first_name') . ' + ' . trans('auth.last_name') }}</label>
                            <div class="row" style="margin-left: -15px; margin-right: -15px;">
                                <div class="col-sm-6 u-mb10">
                                    <input type="text" class="form-input form-grey" value="{{ $member['first_name']  }}" name="first_name" placeholder="First name..." />
                                </div>
                                <div class="col-sm-6 u-mb10">
                                    <input type="text" class="form-input form-grey" value="{{$member['last_name']}}" name="last_name" placeholder="Last name..." />
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-fullwidth u-mv10">
                            <label>{{ trans('auth.email_address') }}</label>
                            <input type="text" class="form-input form-grey" value="{{$member['email']}}" name="email" placeholder="{{ trans('auth.email_address_placeholder') }}" />
                        </div>

                        <div class="form-group form-fullwidth u-mv10">
                            <label>{{ trans('auth.username') }}</label>
                            <input type="text" class="form-input form-grey" value="{{$member['username']}}" name="username" placeholder="{{ trans('auth.email_address_placeholder') }}" />
                        </div>

                        <label class="u-mt20">{{ trans('issues.neighbourhood') }}</label>
                        @if(isset($member['location']))
                            @include('partials.field-hood', array('inputClassList' => 'form-grey', 'defaultValue' => $member['hood']['name'].", ".$member['hood']['district']['name'].", ".$member['hood']['district']['city']['name']))
                        @else
                            @include('partials.field-hood', array('inputClassList' => 'form-grey'))
                        @endif

                        <div class="form-group form-fullwidth hasIconRight u-mv10">
                            <label>User role</label>
                            <div class="u-relative">
                                <select class="form-input form-grey">
                                    <option disabled selected>-</option>
                                @foreach ([0, 3, 4, 5, 10] as $l)
                                    <option value="{{ $l }}" {{ ($member['level'] == $l) ? 'selected' : '' }}>
                                        {{ getUserLevel($l) . ' (' . $l . ')' }}
                                    </option>
                                @endforeach
                                </select>
                                <div class="form-appendRight u-aligncenter u-width40 u-mt5">
                                    <i class="ion ion-chevron-down"></i>
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-fullwidth u-mv10">
                            <label>Phone</label>
                            <input type="text" class="form-input form-grey" value="{{$member['phone']}}" name="phone" />
                        </div>

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
