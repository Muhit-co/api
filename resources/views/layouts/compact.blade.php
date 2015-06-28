<!DOCTYPE html>

<html lang="en">

    @include('partials.head')

    <body>

        @include('partials.nav-compact')

        <a href="javascript:void(0)" id="loader_mask" class="mask u-aligncenter u-relative">
            <img src="/images/preloader.gif" alt="" class="u-valignmiddle" />
        </a>

        <main>
            <section class="c-bgBlue">
                @include('partials.messages')
            </section>

            @yield('content')

        </main>

        @include('partials.footer')
    </body>

</html>
