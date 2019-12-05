@extends('layouts.dash')
@section('title','Tambah Stok Barang | Rimba Petshop')



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
          <div class="card-header bg-light"><h4 class="text-custom">Tambah Stok Barang</h4> </div>
              <div class="card-body mx-2">
                      <form method="POST" action="/dt_brg" novalidate>
                          @csrf
                          @method('PUT')
                          <input id="kd_kategori" type="text" class="form-control1 w-auto my-2 {{ $errors->has('kd_brg') ? ' is-invalid' : '' }}"   name="kd_brg" value="{{$ubahStok->kd_brg}}" readonly>
                              @if ($errors->has('kd_brg'))
                                  <span class="invalid-feedback">
                                      <strong>{{ $errors->first('kd_brg') }}</strong>
                                  </span>
                              @endif

                          <input id="nm_brg" type="text" class="form-control1 w-auto my-2 {{ $errors->has('nm_brg') ? ' is-invalid' : '' }}" placeholder="Nama Barang" name="nm_brg" value="{{$ubahStok->nm_brg}}" readonly>

                              @if ($errors->has('nm_brg'))
                                  <span class="invalid-feedback">
                                      <strong>{{ $errors->first('nm_brg') }}</strong>
                                  </span>
                              @endif

                              <input id="stok" type="text" class="form-control1 w-auto my-2 {{ $errors->has('stok') ? ' is-invalid' : '' }}" placeholder="Jumlah Stok" name="stok" value="" required>

                                  @if ($errors->has('stok'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('stok') }}</strong>
                                      </span>
                                  @endif

                                  <button type="submit" name="AksiStok" value="Update" class="btn btn-outline-custom form-control1 mt-3 w-100">
                                    <i class="fa fa-pencil"></i>   Tambahkan Stok
                                  </button>
                                  <button type="submit" name="AksiStok" value="Cancel" class="btn btn-outline-secondary mt-3 w-100"> Cancel</button>
                                 

                          </div>

                      </form>
                  </div>
            </div>
  </div>
@endsection
