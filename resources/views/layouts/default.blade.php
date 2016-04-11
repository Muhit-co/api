<!DOCTYPE html>

<html lang="en">

    @include('partials.head')

    <body <?php echo (isset($role)) ? 'class="role-' . $role . '"' : ''; ?>>

        @include('dialogs.login')
        @yield('dialogs')

        <a href="javascript:void(0)" id="dialog_mask" class="mask"></a>

        @include('partials.loader-mask')

        @if(Auth::check())
        <div id="menu-drawer">
            <div class="u-pa5 u-opacity50">
                <a href="<?php echo (Request::is('/')) ? '#top' : '/' ?>"><img src="/images/logo.png" height="36px" alt="" /></a>
            </div>
            @include('partials.menu')
            <ul class="menu u-pinned-bottom">
                <li><a href="/logout" id="logout"><i class="ion ion-log-out ion-15x"></i> <span class="text">{{ trans('auth.log_out_cap') }}</span></a></li>
            </ul>
        </div>
        @endif

        <main id="panel">

            @include('partials.nav')

            <section class="flash-container">
            
                @include('partials.messages')

                @if(Auth::check() and Auth::user()->is_verified == 0)
                    @include('partials.message-confirmemail')
                @endif

            </section>

            @yield('content')

            @include('partials.footer')

            <a id="panel-mask"></a>

        </main>

    </body>

</html>


