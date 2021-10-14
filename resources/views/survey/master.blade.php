<!doctype html>
<html lang="tr">
  <head>
    @include('layouts.partials.head')
<style>
  @media only screen and (max-width: 768px) {
      .a-br {
          margin-bottom: 20px;
        }
      }

      /* Chart Properties */
      #myChart {
        height: 400px !important;
      }

      }
</style>

    <title>@yield('title')</title>
  </head>
  <body>
    
    @include('layouts.partials.header')

<div class="container-fluid">
  <div class="row">
    @include('layouts.partials.navbar')

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">


      @yield('content')
    </main>
  </div>
</div>


    @include('layouts.partials.footer')
  </body>
</html>
