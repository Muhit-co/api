<!DOCTYPE html>

<html lang="en">

    @include('partials.head')

    <body>

        @include('partials.nav-compact')

        <main>
            <section class="c-bgBlue">
                <div class="row u-pv10">
                    <div class="col-md-10 col-md-offset-1">
                        @include('partials.messages')
                    </div>
                </div>
            </section>

            @yield('content')

        </main>

        @include('partials.footer')
    </body>

</html>
