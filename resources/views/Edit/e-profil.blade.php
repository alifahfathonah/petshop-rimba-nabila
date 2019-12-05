@extends('layouts.dash')
@section('title','Ubah Profil User | Rimba Petshop')


@section('side')
@endsection
@section('content')
  <div class="container">
      <h1 class="text-custom">Ubah Profil</h1>
    	<hr>
  	<div class="row justify-content-lg-center">

        <!-- edit form column -->

        <div class="col-md-9 personal-info "id="style-1">





            <form class="form-horizontal" method="POST" action="/profile/eprof"  autocomplete="off">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label class="col-lg-3 control-label">Nama :</label>
                <div class="col-lg-8">
                  <input class="form-control" name="nama" type="text"  autocomplete="off" value="{{Auth::user()->name}}">

                      @if ($errors->has('nama'))
                          <div class="invalid-feedback discontent">
                              <p>{{ $errors->first('nama') }}</p>
                          </div>
                      @endif
                </div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 control-label">No. Handphone:</label>
                <div class="col-lg-8">
                  <input class="form-control" name="nope" type="text"  autocomplete="off" value="{{Auth::user()->no_hp}}">
                  @if ($errors->has('nope'))
                      <div class="invalid-feedback discontent">
                          <p>{{ $errors->first('nope') }}</p>
                      </div>
                  @endif
                </div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 control-label">Kota / Kabupaten:</label>
                <div class="col-lg-8">
                  <input class="form-control" name="kota" type="text"  autocomplete="off" value="{{Auth::user()->kota}}">
                  @if ($errors->has('kota'))
                      <div class="invalid-feedback discontent">
                          <p>{{ $errors->first('kota') }}</p>
                      </div>
                  @endif
                </div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 control-label">Alamat:</label>
                <div class="col-lg-8">
                  <textarea name="alamat" class="form-control" rows="8" cols="80" autocomplete="off">{{Auth::user()->alamat}} </textarea>
                  @if ($errors->has('alamat'))
                      <div class="invalid-feedback discontent">
                          <p>{{ $errors->first('alamat') }}</p>
                      </div>
                  @endif
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-8">
                  <button  class="btn btn-primary" name="AksiProfil" value="Simpan" >Simpan</button>

                  <span></span>
                  <button class="btn btn-default" name="AksiProfil" value="Cancel">Cancel</button>
                </div>

              </div>
            </form>

        </div>
    </div>
  </div>
  <hr>
@endsection
