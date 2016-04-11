<!DOCTYPE html>

<html lang="en">

    @include('partials.head')

    <body>

        @include('partials.nav-report')

        @include('partials.loader-mask')

        <main>
        
            <section>
                @include('partials.messages')
            </section>

            @yield('content')

        </main>

        @include('partials.footer')
    </body>

</html>
