@if (session('success'))
    <div class="flash flash-success u-mb20">
        <a href="javascript:void(0)">
            <i class="ion ion-android-close ion-15x u-floatright u-ml10 u-mb10"></i>
        </a>
        <i class="ion ion-information-circled ion-15x u-floatleft u-mr10 u-mb10"></i>
        {{ session('success')  }}
    </div>
@endif
@if (session('warning'))
    <div class="flash flash-warning u-mb20">
        <a href="javascript:void(0)">
            <i class="ion ion-android-close ion-15x u-floatright u-ml10 u-mb10"></i>
        </a>
        <i class="ion ion-information-circled ion-15x u-floatleft u-mr10 u-mb10"></i>
        {{ session('warning')  }}
    </div>
@endif
@if (session('error'))
    <div class="flash flash-error u-mb20">
        <a href="javascript:void(0)">
            <i class="ion ion-android-close ion-15x u-floatright u-ml10 u-mb10"></i>
        </a>
        <i class="ion ion-information-circled ion-15x u-floatleft u-mr10 u-mb10"></i>
        {{ session('error')  }}
    </div>
@endif
