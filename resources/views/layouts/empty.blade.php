<!DOCTYPE html>

<html lang="en">

    @include('partials.head')

    <body class="bg-blue bg-city-banner">

        @include('partials.loader-mask')

        @include('partials.messages')

        @yield('content')

    </body>

</html>
