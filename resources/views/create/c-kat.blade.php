@extends('layouts.dash')

@section('side')
@endsection
@section('content')
  <div class="d-lg-flex w-100">
      <div class="card mx-auto w-100 ">
          <div class="card-header bg-light"><h4 class="text-custom">Tambah Barang</h4> </div>
              <div class="card-body mx-2">
                      <form method="POST" action="/dt_kategori/add" novalidate>
                          @csrf
                        
                              <input id="kd_kategori" type="text" class="form-control1 w-auto my-2 {{ $errors->has('kd_kategori') ? ' is-invalid' : '' }}"   name="kd_kategori" value="{{$kd_kat}}" readonly>
                                  @if ($errors->has('kd_kategori'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('kd_kategori') }}</strong>
                                      </span>
                                  @endif
                                  <input id="nm_kategori" type="text" class="form-control1 w-auto my-2 {{ $errors->has('nm_kategori') ? ' is-invalid' : '' }}" placeholder="Nama Barang" name="nm_kategori"  >


                                      @if ($errors->has('nm_kategori'))
                                          <div class="invalid-feedback discontent">
                                              <p>{{ $errors->first('nm_kategori') }}</p>
                                          </div>
                                      @endif

                          <div class="form-group row mb-0">
                          <button  class="btn btn-outline-custom form-control1 mt-3 w-100" name="AksiKategori" value="Simpan"autofocus>
                              <i class="fa fa-plus-circle"></i>   Tambah Kategori
                            </button>
                            <button  class="btn btn-outline-secondary form-control1 mt-3 w-100" name="AksiKategori" value="Cancel">
                               Cancel
                            </button>
                   

                          </div>
                      </form>
                  </div>
            </div>

  </div>
@endsection
