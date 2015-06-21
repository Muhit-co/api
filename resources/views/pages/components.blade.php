@extends('layouts.default')
@section('content')

<section>
  <div class="row u-pv20">
    <div class="col-md-4">
      <div class="list list_block">
        <div class="list-header"></div>
        <ul>
          <li><a href="javascript:void(0)">
            <p class="u-floatright"><small>1 Apr</small></p>
            Item 1
            <p>secondary info</p>
          </a></li>
          <li><a href="javascript:void(0)">
            <p class="u-floatright"><small>31 Mar</small></p>
            Item 2
            <p>secondary info</p>
          </a></li>
          <li><a href="javascript:void(0)">
            <p class="u-floatright"><small>30 Mar</small></p>
            Item 3
            <p>secondary info</p>
          </a></li>
          <li><a href="javascript:void(0)">
            <p class="u-floatright"><small>29 Mar</small></p>
            Item 4
            <p>secondary info</p>
          </a></li>
          <li><a href="javascript:void(0)">
            <p class="u-floatright"><small>28 Mar</small></p>
            Item 5
            <p>secondary info</p>
          </a></li>
        </ul>
      </div>
    </div>
    <div class="col-md-8">

      <div class="flash flash-warning u-mb20">
        <a href="javascript:void(0)"><i class="ion ion-android-close ion-15x u-floatright u-ml10 u-mb10"></i></a>
        <i class="ion ion-information-circled ion-15x u-floatleft u-mr10 u-mb10"></i>
        This idea is currently being moderated; therefore it is not possible to support or change its status.
      </div>

      <h1>Heading 1</h1>
      <h2>Heading 2</h2>
      <h3>Heading 3</h3>
      <h4>Heading 4</h4>
      <h5>Heading 5</h5>

      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eleifend at tellus eget tristique. Nullam scelerisque euismod mi, vel suscipit risus efficitur id. Aenean sit amet nisi vel ipsum volutpat porttitor sed eget urna. Morbi dictum ac purus nec imperdiet. Etiam ac tempus nisl. Pellentesque arcu justo, <a href="http://www.muhit.co" target="_blank">Inline text link</a> auctor ac odio ornare, dapibus congue ante. Phasellus tristique orci a fermentum ultricies. Maecenas faucibus bibendum magna. Pellentesque quis ornare quam.</p>

      <a href="http://www.muhit.co" target="_blank">Muhit web</a><br /><br />

      <a href="javascript:void(0)" class="btn btn-primary u-mr10"><i class="ion ion-plus"></i> FİKİR EKLE</a>
      <a href="javascript:void(0)" class="btn btn-secondary u-mr10" data-dialog="dialog_newidea">FİKİR EKLE <i class="ion ion-android-open"></i></a>
      <div class="hasDropdown u-inlineblock">
        <a href="javascript:void(0)" class="btn u-mr10">HAREKETE GEÇ <i class="ion ion-chevron-down"></i></a>
        <div class="dropdown">
          <ul>
            <li><a href="#">Çayımı iç</a></li>
            <li><a href="#">Gelişmekte</a></li>
            <li><a href="#">Çözüldü</a></li>
            <li><a href="#">Yorum yaz</a></li>
          </ul>
        </div>
      </div>
      <a href="javascript:void(0)" class="btn btn-tertiary u-mr10">VAZGEÇ</a>

      <br /><br />

      <div class="form-group">
        <label>Adınız</label>
        <input type="text" class="form-input" value="" placeholder="Yazin..." />
      </div>

      <div class="form-group">
        <label>Adınız</label>
        <input type="text" class="form-input" value="" placeholder="Yazin..." />
      </div>

      <div class="form-group">
        <input type="checkbox" name="vehicle" value="agree" class="u-floatleft u-mr20">
        <label for="checkbox">I agree with the <a href="javascript:void(0)">Terms of service</a>.</label>
      </div>

    </div>
  </div>
</section>

@stop
