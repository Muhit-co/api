<!DOCTYPE html>

<html lang="en">

    @include('partials.head')

    <body>

        @include('partials.nav')

        <a href="javascript:void(0)" id="dialog_mask"></a>

        @include('dialogs.newidea')


        <main>
            @include('partials.messages')

            @yield('content')

        </main>

        @include('partials.footer')
    </body>

</html>


