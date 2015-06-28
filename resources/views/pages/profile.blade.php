@extends('layouts.default')
@section('content')

<section>
  <div class="row u-pv20">

    <div class="col-md-7">
      <div class="card u-mt0">
        <div class="card-header">
          <div class="badge badge-circle-large u-floatleft u-mr20 u-mb20">
            <img src="http://d1vwk06lzcci1w.cloudfront.net/80x80/placeholders/profile.png" alt="">
          </div>
          <h2 class="u-mt20">
            Daniel Swakman
          </h2>
          <span class="">daniel-swakman</span>
        </div>
        <div class="card-content">

          <div class="row u-mv10">
            <div class="col-xs-2 u-aligncenter u-pr30">
              <i class="ion ion-location ion-2x c-light"></i>
            </div>
            <div class="col-xs-9">
              <div class="u-floatleft u-mv5">Gümüşsuyu, Beyoğlu</div>
            </div>
          </div>
          <div class="row u-mv10">
            <div class="col-xs-2 u-aligncenter u-pr30">
              <i class="ion ion-email ion-2x c-light"></i>
            </div>
            <div class="col-xs-9">
              <div class="u-floatleft u-mv5">john@example.com</div>
            </div>
          </div>
          <div class="row u-mv10">
            <div class="col-xs-2 u-aligncenter u-pr30">
              <i class="ion ion-calendar ion-15x c-light u-mt5"></i>
            </div>
            <div class="col-xs-9">
              <div class="u-floatleft u-mv5"><span class="c-light">joined:</span> 12 Haz 2015</div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="col-md-5">
      <div class="list list_block list-expanded">
        <!-- <div class="list-header u-pa15">
          <h3>
            Eklediği fikirleri
          </h3>
        </div> -->
        <ul>
          <li>
            <a href="javascript:void(0)">
              <div class="badge badge-image u-floatleft u-mr15">
                <img src="//d1vwk06lzcci1w.cloudfront.net/50x50/placeholders/issue.jpg" alt="" />
              </div>
              <div class="badge badge-status u-floatright u-mt10">
                <i class="ion ion-wrench u-mr5"></i>
                <strong>14</strong>
              </div>
              <strong>Issue title</strong>
              <p><span class="date">Bugün</span></p>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <div class="badge badge-image u-floatleft u-mr15">
                <img src="//d1vwk06lzcci1w.cloudfront.net/50x50/placeholders/issue.jpg" alt="" />
              </div>
              <div class="badge badge-status u-floatright u-mt10">
                <i class="ion ion-wrench u-mr5"></i>
                <strong>14</strong>
              </div>
              <strong>Issue title</strong>
              <p><span class="date">Bugün</span></p>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <div class="badge badge-image u-floatleft u-mr15">
                <img src="//d1vwk06lzcci1w.cloudfront.net/50x50/placeholders/issue.jpg" alt="" />
              </div>
              <div class="badge badge-status u-floatright u-mt10">
                <i class="ion ion-wrench u-mr5"></i>
                <strong>14</strong>
              </div>
              <strong>Issue title</strong>
              <p><span class="date">Bugün</span></p>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <div class="badge badge-image u-floatleft u-mr15">
                <img src="//d1vwk06lzcci1w.cloudfront.net/50x50/placeholders/issue.jpg" alt="" />
              </div>
              <div class="badge badge-status u-floatright u-mt10">
                <i class="ion ion-wrench u-mr5"></i>
                <strong>14</strong>
              </div>
              <strong>Issue title</strong>
              <p><span class="date">Bugün</span></p>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

@stop
