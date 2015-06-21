<!DOCTYPE html>

<html lang="en">

    @include('partials.head')

    <body>

        @include('partials.nav-compact')

        <main>
            @include('partials.messages')

            @yield('content')

        </main>

        @include('partials.footer')
    </body>

</html>
