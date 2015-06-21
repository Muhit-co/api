@extends('layouts.default')
@section('content')

@include('partials.header')

<section>
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="list list-expanded list_block u-mt20 u-mb40">
        <div class="list-header"></div>
          <ul>
            <li><a href="/issue">
              <div class="badge badge-image u-floatleft u-mr15">
                <!-- first image in issue -->
                <img src="/images/street_thumbnail.jpg" alt="" />
              </div>
              <!-- status/support badge -->
              <div class="badge badge-status u-floatright u-mt10">
                <i class="ion ion-wrench u-mr5"></i>
                <strong>54</strong>
              </div>
              <!-- issue title -->
              <strong>Sıraselviler’de araç işgali kontrol edilsin.</strong>
              <p>
                <!-- issue tags (max 3) -->
                <span class="tag u-mr10" style="background-color: #a7cc81;">AĞAÇLANDIRMA</span>
                <span class="tag u-mr10" style="background-color: #7dd3ac;">SÜRDÜRÜLEBİLİR</span>
                <span class="tag u-mr10" style="background-color: #c673c0;">ENERJİ</span>
                <!-- issue date -->
                <span class="date">Bugün</span>
              </p>
            </a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

@stop
