<div class="navbar-wrapper">


<nav class="navbar navbar-expand-md navbar-dark bg-transparent1  bg-foot">
  <a class="navbar-brand" href="/">Rimba Petshop</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
  </button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav mr-auto">
  <li class="nav-item"></li>
  <a class="nav-link" href="/about">Tentang Kami</a>
    <li class="nav-item"></li>

      <a class="nav-link" href="/kontak">Kontak</a>
  </ul>
    <ul class="navbar-nav  ml-lg-5 mr-lg-5">
      @guest
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">  Login</a></li>

        @elseif (Auth::check() && Auth::user()->level == "0")
            <div class="btn-group mx-lg-5">
              <div class="btn-group dropdown" role="group">
                <button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                </button>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <!-- Dropdown menu links -->
                         <a href="/profile" class="dropdown-item-custom"><i class="fa fa-user" aria-hidden="true" style="width:25px"></i> Profile</a>


                      <a class="dropdown-item-custom" href="{{ route('logout') }}"   onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            <i class="fa fa-power-off" aria-hidden="true" style="width:25px"></i>Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                  </div>
                  </div>
                  <a role="button" class="nav-link btn-light text-dark " href="/dashboard">
                    {{ Auth::user()->email }}
                  </a>
                </div>

        @else
          <div class="btn-group mx-lg-5">
            <div class="btn-group dropdown" role="group">
              <button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="caret"></span>
              </button>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <!-- Dropdown menu links -->
                       <a href="/profile" class="dropdown-item-custom"><i class="fa fa-user" aria-hidden="true" style="width:25px"></i> Profil</a>
                       <a href="/cart/list/{{ Auth::user()->id }}" class="dropdown-item-custom"><i class="fa fa-shopping-cart" aria-hidden="true" style="width:25px"></i> Keranjang Belanja</a>

                    <a class="dropdown-item-custom" href="{{ route('logout') }}"   onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                          <i class="fa fa-power-off" aria-hidden="true" style="width:25px"></i>Logout
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          @csrf
                      </form>
                </div>
                </div>
                <a role="button" class="nav-link btn-light text-dark " href="/dashboard">
                  {{ Auth::user()->email }}
                </a>
              </div>

          @endguest


  </div>
    </ul>
</div>

</nav>
