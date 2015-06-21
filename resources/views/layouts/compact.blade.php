<!DOCTYPE html>

<html lang="en">

  @include('partials.head')

  <body>

    @include('partials.nav-compact')

    <main>

      @yield('content')
      
    </main>

    @include('partials.footer')
  </body>

</html>


