<!DOCTYPE html>

<html lang="en">

    @include('partials.head')

    <body>

        @include('partials.nav-report')

        <a href="javascript:void(0)" id="loader_mask" class="mask u-aligncenter u-relative">
            <img src="/images/preloader.gif" alt="" class="u-valignmiddle" />
        </a>

        <main>
        
            <section>
                @include('partials.messages')
            </section>

            @yield('content')

        </main>

        @include('partials.footer')
    </body>

</html>
