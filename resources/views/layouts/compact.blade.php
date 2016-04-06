<!DOCTYPE html>

<html lang="en">

    @include('partials.head')

    <body>

        @include('partials.nav-compact')

        @include('partials.loader-mask')

        <main>
            <section class="bg-blue">
                @include('partials.messages')
            </section>

            @yield('content')

        </main>

        @include('partials.footer')
    </body>

</html>
