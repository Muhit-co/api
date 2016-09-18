<?php $state = (isset($state)) ? $state : ''; ?>

@if(App::getLocale() == 'en')
    <a href="/lang/tr">
        @if($state == 'expanded')
            <i class="ion ion-shuffle u-mr5"></i> İngilizce'ye çevir
        @else
            TR
        @endif
    </a>
@else
    <a href="/lang/en">
        @if($state == 'expanded')
            <i class="ion ion-shuffle u-mr5"></i> Switch to English
        @else
            EN
        @endif
    </a>
@endif
