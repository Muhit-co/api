@if (session('success'))
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="flash flash-success u-mv10">
                <a href="javascript:void(0)" id="flash_close">
                    <i class="ion ion-android-close ion-15x u-floatright u-ml10 u-mb10"></i>
                </a>
                <i class="ion ion-information-circled ion-15x u-floatleft u-mr10 u-mb10"></i>
                {{ session('success')  }}
            </div>
        </div>
    </div>
    <script>
        setTimeout(function() { $('.flash-success').animate({ opacity: 0, margin: 0 }, 'normal').slideUp() }, 6000);
    </script>
@endif
@if (session('warning'))
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="flash flash-warning u-mv10">
                <a href="javascript:void(0)" id="flash_close">
                    <i class="ion ion-android-close ion-15x u-floatright u-ml10 u-mb10"></i>
                </a>
                <i class="ion ion-information-circled ion-15x u-floatleft u-mr10 u-mb10"></i>
                {{ session('warning')  }}
            </div>
        </div>
    </div>
@endif
@if (session('error'))
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="flash flash-error u-mv10">
                <a href="javascript:void(0)" id="flash_close">
                    <i class="ion ion-android-close ion-15x u-floatright u-ml10 u-mb10"></i>
                </a>
                <i class="ion ion-information-circled ion-15x u-floatleft u-mr10 u-mb10"></i>
                {{ session('error')  }}
            </div>
        </div>
    </div>
@endif


