<!DOCTYPE html>

<html lang="en">

    @include('partials.head')

    <body <?php echo (isset($role)) ? 'class="role-' . $role . '"' : ''; ?>>

        @include('dialogs.report')
        @include('dialogs.login')
        <a href="javascript:void(0)" id="dialog_mask" class="mask"></a>

        <a href="javascript:void(0)" id="loader_mask" class="mask u-aligncenter u-relative">
            <img src="/images/preloader.gif" alt="" class="u-valignmiddle" style="margin-left: -24px; margin-top: -24px;" />
        </a>

        @if(Auth::check())
        <div id="menu-drawer">
            @include('partials.menu')
        </div>
        @endif

        <main id="panel">

            @include('partials.nav')

            <section class="flash-container">
                @include('partials.messages')
            </section>

            @yield('content')
            
            @include('partials.footer')

        </main>
        
    </body>

</html>


