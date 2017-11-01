<!DOCTYPE html>

<html lang="en">

    @include('partials.head')

    <body>

        @include('partials.loader-mask')

        <main>

            @include('partials.nav-report')
        
            <section>
                @include('partials.messages')
            </section>

            @yield('content')

        </main>

        @include('partials.footer')
    </body>

</html>
