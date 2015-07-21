@extends('layouts.default')
@section('content')

<header class="u-relative header-list">
    <div class="row u-pb40">
        <div class="col-md-10 col-md-offset-1">
            <h2>Desteklediklerim fikirler</h2>
        </div>
    </div>
</header>

<section class="tabsection" id="latest">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <div class="list list-expanded list_block u-mt20 u-mb40">
                <ul class="list-content">
                    <li>
                        <a href="/issues/view/1">
                            <div class="badge badge-image u-floatleft u-mr15">
                                <img src="//d1vwk06lzcci1w.cloudfront.net/50x50/placeholders/issue.jpg" alt="" />
                            </div>
                            <div class="badge badge-support badge-new-empty u-floatright u-mt10 u-pv5 u-ph10">
                                <i class="ion ion-wrench u-mr5"></i>
                                <strong>0</strong>
                            </div>
                            <strong>An issue title</strong>
                            <p>
                                <span class="tag u-mv5 u-mr5" style="background-color: #c4a26c;">
                                    Geri dönüşüm
                                </span>
                                <span class="tag u-mv5 u-mr5" style="background-color: #a7cc81;">
                                    Ağaçlandırma
                                </span>
                                <span class="date u-mr10"><?php echo date('j M Y', strtotime(time())) ?></span>
                                |<span class="user u-ml10">User</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="/issues/view/1">
                            <div class="badge badge-image u-floatleft u-mr15">
                                <img src="//d1vwk06lzcci1w.cloudfront.net/50x50/placeholders/issue.jpg" alt="" />
                            </div>
                            <div class="badge badge-support u-floatright u-mt10 u-pv5 u-ph10">
                                <i class="ion ion-wrench u-mr5"></i>
                                <strong>0</strong>
                            </div>
                            <strong>An issue title</strong>
                            <p>
                                <span class="tag u-mv5 u-mr5" style="background-color: #c4a26c;">
                                    Geri dönüşüm
                                </span>
                                <span class="tag u-mv5 u-mr5" style="background-color: #a7cc81;">
                                    Ağaçlandırma
                                </span>
                                <span class="date u-mr10"><?php echo date('j M Y', strtotime(time())) ?></span>
                                |<span class="user u-ml10">Anonymous</span>
                            </p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

@stop
