<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  @include('layouts.head')
</head>
<body>
    @include('layouts.nav')

 
    @yield('content')
 

</body>
</html>
