@extends('layouts.dash')
@section('title','Ubah Barang | Rimba Petshop')


@section('content')
@if($errors)
   @foreach ($errors->all() as $error)
   <div class="alert alert-danger alert-dismissable">
    <a class="panel-close close" data-dismiss="alert">×</a>
    <i class="fa fa-exclamation-triangle"></i>
      {{$error}}
  </div>
     
  @endforeach
@endif
  <div class="d-lg-flex w-100">
      <div class="card mx-auto w-100 ">
          <div class="card-header bg-light"><h4 class="text-custom">Ubah Kategori</h4> </div>
              <div class="card-body mx-2">
                      <form method="POST" action="/dt_kategori/prosesEdit" novalidate>
                          @csrf
                          @method('PATCH')
                          <input id="kd_kategori" type="text" class="form-control1 w-auto my-2 {{ $errors->has('kd_kategori') ? ' is-invalid' : '' }}"   name="kd_kategori" value="{{$ubahKat->kd_kategori}}" readonly>
                              @if ($errors->has('kd_kategori'))
                                  <span class="invalid-feedback">
                                      <strong>{{ $errors->first('kd_kategori') }}</strong>
                                  </span>
                              @endif

                          <input id="nm_kategori" type="text" class="form-control1 w-auto my-2 {{ $errors->has('nm_kategori') ? ' is-invalid' : '' }}" placeholder="Nama Kategori" name="nm_kategori" value="{{$ubahKat->nm_kategori}}" required>

                              @if ($errors->has('nm_kategori'))
                                  <span class="invalid-feedback">
                                      <strong>{{ $errors->first('nm_kategori') }}</strong>
                                  </span>
                              @endif
                              <button type="submit" class="btn btn-outline-custom form-control1 mt-3 w-100" name="AksiKatEdit" value="Simpan">
                                    <i class="fa fa-pencil"></i>   Ubah Barang
                                  </button>

                              <button type="submit" class="btn btn-outline-secondary form-control1 mt-3 w-100" name="AksiKatEdit" value="Cancel">
                                 Cancel
                              </button>
                                 

                          </div>

                      </form>
                  </div>
            </div>
  </div>
@endsection
