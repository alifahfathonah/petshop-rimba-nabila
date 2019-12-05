<!DOCTYPE html>
<html>
  <head>
    @include('layouts.head')
  </head>
  <body class="">
    @include('layouts.nav')
    @include('layouts.carousel')
<div class="d-lg-flex">


<div class="container p-4">

      @yield('content')
</div>
    </div>
    @include('layouts.foot')
  </body>
</html>
