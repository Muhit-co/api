@extends('layouts.default')
@section('content')

@include('partials.header', array('type'=>'show'))

<section>
  <div class="row">

    <div class="col-md-10 col-md-offset-1">

      <div class="card">
        <div class="card-header clearfix">
          <div class="u-floatleft">
            <a href="/" class="u-ml10 u-mr20 closeCard"><i class="ion ion-android-arrow-back ion-2x"></i></a>
          </div>
          <div class="u-floatright">
            <a href="javascript:void(0)" class="btn btn-sm btn-secondary u-mr5"><i class="ion ion-android-share-alt"></i></a>
            <a href="javascript:void(0)" class="btn btn-sm btn-secondary"><i class="ion ion-thumbsup"></i> DESTEKLE</a>
          </div>
          <span class="title">{{$issue['location']}}</span>
        </div>
        <div class="card-content">

          <style>
            .badge.badge-large {
              width: 80px;
              height: 80px;
              padding: 18px 10px;
            }
            .badge.badge-support {
              background-color: #44a1e0;
              color: #fff;
            }
            .badge.badge-support label {
              font-size: 0.75em;
            }
            .badge.badge-support .value {
              font-size: 2em;
              font-weight: bold;
            }
          </style>

          <div class="badge badge-circle-large badge-support u-floatright u-pt15">
            <div class="value">54</div>
            <label>DESTEKÇİ</label>
          </div>

            <h3 class="u-mh5 u-mv10">
                {{$issue['title']}}
            </h3>

          <div class="media row row-nopadding u-mv20">
            <div class="media-image col-md-8">
              <img src="/images/street.jpg" alt="" />
            </div>
            <div class="media-map col-md-4">
              <img src="/images/map.jpg" alt="" />
            </div>
          </div>

          <div class="row row-nopadding u-mv20">
            <div class="col-md-10">
                @foreach($issue['tags'] as $tag)
                    <span class="tag u-mr10" style="background-color:#{{$tag['background']}}">{{$tag['name']}}</span>
                @endforeach
            </div>
            <div class="col-md-2 u-alignright">
              <label class="c-light"><i class="ion ion-android-calendar u-mr5"></i> 24 May</label>
            </div>
          </div>

          <div class="description">
            <p>{{$issue['desc']}}</p>
          </div>

        </div>

        <div class="card-footer clearfix">
          <div class="u-floatright">
            <a href="javascript:void(0)" class="btn btn-sm btn-tertiary u-mr5"><i class="ion ion-alert-circled"></i></a>
            <a href="javascript:void(0)" class="btn btn-sm btn-tertiary u-mr5"><i class="ion ion-edit u-mr5"></i> DÜZENLE</a>
            <a href="javascript:void(0)" class="btn btn-sm btn-tertiary"><i class="ion ion-trash-b u-mr5"></i> SİL</a>
          </div>
          <span class="title">A019 8589910</span>
        </div>

      </div>

    </div>

  </div>
</section>

@stop
