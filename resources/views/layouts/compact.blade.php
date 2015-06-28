<!DOCTYPE html>

<html lang="en">

    @include('partials.head')

    <body>

        @include('partials.nav-compact')

        <main>
            <section class="c-bgBlue">
                @include('partials.messages')
            </section>

            @yield('content')

        </main>

        @include('partials.footer')
    </body>

</html>
