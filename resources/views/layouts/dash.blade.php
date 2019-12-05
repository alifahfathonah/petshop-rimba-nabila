<!DOCTYPE html>
<html>
  <head>

    @include('layouts.head')
  </head>
  <body >
<div class="container-fluid m-0 p-0 ">



      @include('layouts.side')

<div class="container mt-4">


      @yield('content')
</div>
    </div>


</div>
  @include('layouts.foot')
  </body>
</html>
