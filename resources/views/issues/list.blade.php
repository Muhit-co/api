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
              <div class="badge u-floatleft">
                LS
              </div>
              <p class="u-floatright"><small>1 Apr</small></p>
              Item 1
              <p>secondary info</p>
            </a></li>
            <li><a href="/issue">
              <p class="u-floatright"><small>31 Mar</small></p>
              Item 2
              <p>secondary info</p>
            </a></li>
            <li><a href="/issue">
              <p class="u-floatright"><small>30 Mar</small></p>
              Item 3
              <p>secondary info</p>
            </a></li>
            <li><a href="/issue">
              <p class="u-floatright"><small>29 Mar</small></p>
              Item 4
              <p>secondary info</p>
            </a></li>
            <li><a href="/issue">
              <p class="u-floatright"><small>28 Mar</small></p>
              Item 5
              <p>secondary info</p>
            </a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

@stop
