@extends('layouts.dash')
@section('title','Ubah Password User | Rimba Petshop')


@section('side')
@endsection
@section('content')
  <div class="container">
      <h1 class="text-custom">Ubah Password</h1>
    	<hr>
  	<div class="row justify-content-lg-center">

        <!-- edit form column -->
        @if (Session::has('Beda'))
          <div class="alert alert-danger alert-dismissable w-100">
            <a class="panel-close close" data-dismiss="alert">×</a>
            <i class="fa fa-lock"></i>
              {{ Session::get('Beda') }}
          </div>
        @endif
        <div class="col-md-9 personal-info "id="style-1">


          <div class="wrapper">
            <form class="form-horizontal" novalidate autocomplete="off" method="post" action="/profile/epw">
              @csrf
              <div class="form-group">
                <label class="col-md-3 control-label">Password Lama:</label>
                <div class="col-md-8">
                  <input class="form-control" name="OldPass" type="password">
                  @if ($errors->has('OldPass'))
                      <div class="invalid-feedback discontent">
                          <p>{{ $errors->first('OldPass') }}</p>
                      </div>
                  @endif
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Password Baru:</label>
                <div class="col-md-8">
                  <input class="form-control" name="NewPass" type="password">
                  @if ($errors->has('NewPass'))
                      <div class="invalid-feedback discontent">
                          <p>{{ $errors->first('NewPass') }}</p>
                      </div>
                  @endif
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-8">
                  <button class="btn btn-primary" name="AksiPass" value="Simpan">Simpan</button>
                  <span></span>
                  <button  class="btn btn-default" name="AksiPass" value="Cancel">Cancel</button>
                </div>
              </div>
            </form>
          </div>
        </div>
    </div>
  </div>
  <hr>
@endsection
