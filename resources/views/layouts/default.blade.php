<!DOCTYPE html>

<html lang="en">

    @include('partials.head')

    <body <?php echo (isset($role)) ? 'class="role-' . $role . '"' : ''; ?>>
  
        @include('partials.nav')

        @include('dialogs.report')
        @include('dialogs.login')
        <a href="javascript:void(0)" id="dialog_mask" class="mask"></a>

        <a href="javascript:void(0)" id="loader_mask" class="mask u-aligncenter u-relative">
            <img src="/images/preloader.gif" alt="" class="u-valignmiddle" />
        </a>

        <main>
            <section class="flash-container">
                @include('partials.messages')
            </section>

            @yield('content')

        </main>

        @include('partials.footer')
        
    </body>

</html>


