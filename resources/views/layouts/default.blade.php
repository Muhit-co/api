<!DOCTYPE html>

<html lang="en">

    @include('partials.head')

    <body <?php echo (isset($role)) ? 'class="role-' . $role . '"' : ''; ?>>

        @include('dialogs.login')
        @yield('dialogs')

        <a href="javascript:void(0)" id="dialog_mask" class="mask"></a>

        <a href="javascript:void(0)" id="loader_mask" class="mask u-aligncenter u-relative">
            <img src="/images/preloader.gif" alt="" class="u-valignmiddle" style="margin-left: -24px; margin-top: -24px;" />
        </a>

        @if(Auth::check())
        <div id="menu-drawer">
            <div class="u-pa5 u-opacity50">
                <a href="<?php echo (Request::is('/')) ? '#top' : '/' ?>"><img src="/images/logo.png" height="30px" alt="" /></a>
            </div>
            @include('partials.menu')
            <ul class="menu u-pinned-bottom">
                <li><a href="/logout" id="logout"><i class="ion ion-log-out ion-15x"></i> <span class="text">{{ trans('auth.log_out_cap') }}</span></a></li>
            </ul>
        </div>
        @endif

        <main id="panel">

            @include('partials.nav')

            @if(Auth::check())
                <div class="row u-pv10">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="flash flash-warning u-mb20">
                            <a href="javascript:void(0)" id="flash_close">
                                <i class="ion ion-android-close ion-15x u-floatright u-ml10 u-mb10"></i>
                            </a>
                            <i class="ion ion-information-circled ion-15x u-floatleft u-mr10 u-mb10"></i>
                            Hesabınızı onaylamnız gerekiyor. Eğer onay maili ulaşmadıysa <a href="/members/resend-confirmation"> buraya tıklayarak </a> yeniden onay maili alabilirsiniz.
                        </div>
                    </div>
                </div>
            @endif


            <section class="flash-container">
                @include('partials.messages')
            </section>

            @yield('content')

            @include('partials.footer')

        </main>

    </body>

</html>


