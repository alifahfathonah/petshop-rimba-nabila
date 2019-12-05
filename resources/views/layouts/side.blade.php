<div class="d-flex">
    <div class="sidebar ">

      <div class="row user-detail">

          <div class="col-lg-14 col-lg-12">
            <div class="navbar-brand text-light">
              <p class="text-light logo-text text-center"><a href="/">Rimba Petshop</a></p>
              <hr>
            </div>
              <h5 class="text-light">Selamat Datang, </h6>
              <h5 class="text-light px-5 mb-4">{{Auth::user()->name}}</h5>
          </div>
        </div>
        <div class="row">
          <div class="scrolling" id="style-7">


{{-- Auth::check() && Auth::user()->kd_level == "1" --}}


        <ul class="list-unstyled ">

          @if (Auth::check() && strtoupper(Auth::user()->join('roles','roles.kd_level','=','users.kd_level')->find(Auth::id())->level) == strtoupper('PEMILIK') )
            <li class="text-light"><a href="/profile"><i class="fa fa-fw fa-user"></i> Profil </a></li>
            <li class="text-light"><a href="/dt_user"><i class="fa fa-fw fa-users"></i> Data Pengguna</a></li>
            <li class="text-light"><a href="/dt_transaksi"><i class="fa fa-fw fa-money"></i> Data Transaksi</a></li>
            <li class="text-light">
              <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">Data Laporan    <i class="fa fa-chevron-down" aria-hidden="true"></i></a></li>
                           <ul class="collapse list-unstyled" id="homeSubmenu">
                               <li class="text-light"><a href="/ReportTrans"><i class="fa fa-file-o"></i> Laporan Transaksi</a></li>
                               <li class="text-light"><a href="/ReportBarang"><i class="fa fa-file-o"></i> Laporan Barang</a></li>
                           </ul>

            <li class="text-light"><a href="{{ route('logout') }}"   onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                  <i class="fa fa-power-off" aria-hidden="true" style="width:25px"></i>Logout
              </a></li>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            @elseif (Auth::check() && strtoupper(Auth::user()->join('roles','roles.kd_level','=','users.kd_level')->find(Auth::id())->level) == strtoupper('ADMIN'))
              <li class="text-light"><a href="/profile"><i class="fa fa-fw fa-user"></i> Profil </a></li>
              <li class="text-light"><a href="/dt_brg"><i class="fa fa-fw fa-cube"></i> Data Barang</a></li>
              <li class="text-light"><a href="/dt_transaksi"><i class="fa fa-fw fa-money"></i> Data Transaksi</a></li>
              <li class="text-light"><a href="/dt_kategori"><i class="fa fa-fw fa-tags"></i> Data Kategori</a></li>
              <li class="text-light"><a href="{{ route('logout') }}"   onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                              <i class="fa fa-power-off" aria-hidden="true" style="width:25px"></i>Logout
                          </a></li>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
              @elseif (Auth::check() && strtoupper(Auth::user()->join('roles','roles.kd_level','=','users.kd_level')->find(Auth::id())->level) == strtoupper('KURIR'))
                <li class="text-light"><a href="/profile"><i class="fa fa-fw fa-user"></i> Profil </a></li>
                <li class="text-light"><a href="/dt_transaksi"><i class="fa fa-fw fa-money"></i> Data Transaksi</a></li>

                <li class="text-light"><a href="{{ route('logout') }}"   onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                <i class="fa fa-power-off" aria-hidden="true" style="width:25px"></i>Logout
                            </a></li>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
            @else
              <li class="text-light"><a href="/"><i class="fa fa-fw fa-user"></i> Halaman Utama </a></li>
              <li class="text-light"><a href="/profile"><i class="fa fa-fw fa-user"></i> Profil </a></li>
              <li class="text-light"><a href="/History"><i class="fa fa-fw fa-history"></i> Riwayat Pemesanan </a></li>
              <li class="text-light"><a class="dropdown-item-custom" href="{{ route('logout') }}"   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    <i class="fa fa-power-off" aria-hidden="true" style="width:25px"></i>Logout
                </a></li>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endif
            </div>
        </ul>
      </div>
    </div>
