@extends('layouts.default')
@section('content')



<header class="u-relative header-list">

    <div class="row u-pb20">
        <div class="col-md-10 col-md-offset-1">
            <h2>{{ trans('issues.ideas_i_added') }}</h2>
        </div>
    </div>

    <div class="row"> <!-- u-pinned-bottom -->
        <div class="col-md-10 col-md-offset-1">
            <!-- Sorting tabs for issue list -->
            <ul class="tabs">
                <li>
                     <a href="/issues/created?sort=latest"  <?php echo (($order == 'latest') ? 'class="active"' : ''); ?>>
                        EN SON
                    </a>
                </li>
                <li>
                    <a href="/issues/created?sort=popular" <?php echo (($order == 'popular') ? 'class="active"' : ''); ?>>
                        POPÜLER
                    </a>
                </li>
            </ul>
        </div>
    </div>

</header>

<section class="tabsection" id="latest">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if (isset($_GET['sort']) && $_GET['sort'] == 'map')
                @include('partials.issues-map', ['issues' => $issues])
            @else
                @include('partials.issues-list', ['issues' => $issues])
            @endif
        </div>
    </div>
</section>

@stop
