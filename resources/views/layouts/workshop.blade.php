<!DOCTYPE html>

<html lang="en">

    @include('partials.head')

    <body>

        <main id="panel">

            <div id="top" class="navplaceholder"></div>
            <nav class="u-pa15 u-aligncenter">@include('partials.logo_svg')</nav>

            <style type="text/css">
                html {
                    margin: 0;
                    height: 100%;
                    overflow: hidden;
                }
                iframe {
                    position: absolute;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    top: 70px;
                    border: 0;
                    height: calc(100% - 70px);
                }
            </style>
            <script type="text/javascript" src="https://embed.typeform.com/embed.js"></script>
            @yield('content')

        </main>

    </body>

</html>
