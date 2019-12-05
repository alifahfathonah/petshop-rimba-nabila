@extends('layouts.dash')
@section('side')
@endsection
@section('content')


  <div class="container">
      <h1 class="text-custom">Profil</h1>
      <hr>
    <div class="row justify-content-lg-center">

        <!-- edit form column -->
        @if (Session::has('nHP'))
          <div class="alert alert-danger alert-dismissable w-100">
            <a class="panel-close close" data-dismiss="alert">×</a>
            <i class="fa fa-phone"></i>
              {{ Session::get('nHP') }}
          </div>
        @endif
        @if (Session::has('nAlamat'))
          <div class="alert alert-danger alert-dismissable w-100">
            <a class="panel-close close" data-dismiss="alert">×</a>
            <i class="fa fa-map-marker"></i>
              {{ Session::get('nAlamat') }}
          </div>
        @endif
        @if (Session::has('updated'))
          <div class="alert alert-success alert-dismissable w-100">
            <a class="panel-close close" data-dismiss="alert">×</a>
            <i class="fa fa-user"></i>
              {{ Session::get('updated') }}
          </div>
        @endif
        <div class="col-md-9 personal-info "id="style-1">



          <h3 class="text-custom mb-1">Data Pribadi</h3>



              <div class="form-group">
                <label class="col-lg-3 control-label">Nama :</label>
                <label class="col-lg-3 control-label">{{Auth::user()->name}}</label>
              </div>

              <div class="form-group">
                <label class="col-lg-3 control-label">Masuk Sebagai :</label>
                <label class="col-lg-3 control-label">{{ $profil->level }}</label>
              </div>
              <div class="form-group">
                <label class="col-lg-3 control-label">No. Telepon :</label>
                <label class="col-lg-3 control-label">{{Auth::user()->no_hp}}</label>
              </div>
              <div class="form-group">
                <label class="col-lg-3 control-label">Kota / Kabupaten :</label>
                <label class="col-lg-3 control-label">{{Auth::user()->kota}}</label>
              </div>
              <div class="form-group iflex">
                <label class="col-md-3 control-label">Alamat :</label>
                <label class="col-xl-5 ml-5 pl-4 control-label">
                  {{Auth::user()->alamat}}
                </label>
              </div>
              <div class="form-group">
                <label class="col-lg-3 control-label">Password :</label>
                <a href="/profile/editpass/{{ Auth::id() }}" class="btn btn-primary btn-sm ml-2  w-auto" role="button">Ubah Password</a>
              </div>
              <div class="form-group mx-auto">
                <a href="/profile/edit/{{ Auth::id() }}" class="btn btn-primary   w-auto" role="button"><i class="fa fa-edit"></i>  Ubah Profil</a>

              </div>
        </div>
    </div>
  </div>
  <hr>
@endsection
