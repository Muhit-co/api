@extends('layouts.default')
@section('content')

<header class="u-relative header-list">

    <div class="row u-pb40">
        <div class="col-md-6 col-sm-7 col-md-offset-1 u-mb10">
            <h2>{{ trans('issues.announcements_from_muhtar') }}</h2>
        </div>
        <div class="col-md-4 col-sm-5">
            <a href="/user-edit" class="btn btn-sm btn-whiteoutline u-floatright u-ml10">
                <i class="ion ion-edit"></i>
            </a>
            <p class="c-white u-nowrap"><strong>Erenköy, Kadıköy</strong> <span class="u-ml10">İstanbul</span></p>
        </div>
    </div>

</header>

<section class="u-mv20">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <div class="card u-mv20" id="announcement_id"> <!-- id = announement id (for permalink) -->
                <div class="card-header">

                    <div class="row row-nopadding">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="u-floatright u-ml10">
                                <span class="date c-medium"><?php echo date('j M Y', strtotime(time())) ?></span>
                            </div>
                            <h3 class="u-nowrap">Announcement title</h3>
                        </div>
                    </div>

                </div>
                <div class="card-content">

                    <div class="row row-nopadding">
                        <div class="col-md-10 col-md-offset-1">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>

                            <a href="/muhtar" class="u-inlineblock u-clearfix u-mt10">
                                <div class="badge badge-circle badge-small u-floatleft u-mr10">
                                    <img src="//d1vwk06lzcci1w.cloudfront.net/50x50/placeholders/profile.png" alt="" />
                                </div>
                                <strong class="username u-floatleft u-mt5 u-mr20">
                                    Sayim Çavuş
                                </strong>
                                <span class="u-floatleft u-mt5 c-light">
                                    Erenköy Mahallesi
                                </span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</section>

@stop
