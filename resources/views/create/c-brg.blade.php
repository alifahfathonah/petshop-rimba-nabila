@extends('layouts.dash')
@section('title','Tambah Barang | Rimba Petshop')

@section('content')

  <div class="d-lg-flex w-100">
      <div class="card mx-auto w-100 ">
          <div class="card-header bg-light"><h4 class="text-custom">Tambah Barang</h4> </div>
              <div class="card-body mx-2">



                      <form method="POST" action="/dt_brg" enctype="multipart/form-data" novalidate>
                          @csrf
                      
                             <input type="hidden" name="kd_brg" value="">

                              <input id="nm_brg" type="text" class="form-control1 w-auto my-2 {{ $errors->has('nm_brg') ? ' is-invalid' : '' }}" placeholder="Nama Barang" name="nm_brg"  >


                                  @if ($errors->has('nm_brg'))
                                      <div class="invalid-feedback discontent">
                                          <p>{{ $errors->first('nm_brg') }}</p>
                                      </div>
                                  @endif



                                  <input id="harga" type="text" class="form-control1 w-auto my-2 {{ $errors->has('harga') ? ' is-invalid' : '' }}" placeholder="Harga Barang" name="harga"  >

                                  @if ($errors->has('harga'))
                                      <span class="invalid-feedback discontent">
                                            <p>{{ $errors->first('harga') }}</p>
                                      </span>
                                  @endif

                                  <input id="stok" type="text" class="form-control1 w-auto my-2 {{ $errors->has('stok') ? ' is-invalid' : '' }}" name="stok" placeholder="Stok Barang" >

                                      <br>
                                  @if ($errors->has('stok'))
                                      <span class="invalid-feedback discontent">
                                          <strong>{{ $errors->first('stok') }}</strong>
                                      </span>
                                  @endif


                                  <input id="berat" type="text" class="form-control1 w-auto my-2 {{ $errors->has('berat') ? ' is-invalid' : '' }}" name="berat" placeholder="Berat Barang" >
                                      <small class="text-info discontent">Catatan : Masukan berat barang dengan satuan berat. contoh : 50gr, 1kg</small>
                                      <br>
                                  @if ($errors->has('berat'))
                                      <span class="invalid-feedback discontent">
                                          <strong>{{ $errors->first('berat') }}</strong>
                                      </span>
                                  @endif
                                  <select id="kd_kategori" class="form-control1 w-auto my-2 {{ $errors->has('kategori') ? ' is-invalid' : '' }}" name="kd_kategori" >
                                    @foreach ($kategori as $category )
                                      <option value="{{$category->kd_kategori}}" selected >{{$category->nm_kategori}}</option>
                                    @endforeach
                                  </select>

                                  @if ($errors->has('kategori'))
                                      <span class="invalid-feedback discontent">
                                          <strong>{{ $errors->first('kategori') }}</strong>
                                      </span>
                                  @endif



                              <input id="bahan" type="text" class="form-control1 w-auto my-2" name="bahan" placeholder="Bahan Barang" >

                              @if ($errors->has('bahan'))
                                  <span class="invalid-feedback discontent">
                                      <strong>{{ $errors->first('bahan') }}</strong>
                                  </span>
                              @endif

                              <select id="usia" class="form-control1 w-auto my-2 {{ $errors->has('usia') ? ' is-invalid' : '' }}" name="usia" >
                                <option value="Dewasa" selected >Dewasa</option>
                                <option value="Anak" selected >Anak-anak</option>
                              </select>
                              @if ($errors->has('usia'))
                                  <span class="invalid-feedback discontent">
                                      <strong>{{ $errors->first('usia') }}</strong>
                                  </span>
                              @endif
                              {{-- <input id="Merk" type="text" class="form-control1 w-auto my-2" name="Merk" placeholder="Merk Barang" >

                              @if ($errors->has('Merk'))
                                  <span class="invalid-feedback discontent">
                                      <strong>{{ $errors->first('Merk') }}</strong>
                                  </span>
                              @endif --}}
                              <input type="file" name="gambar" class="form-control-file">
                          <div class="form-group row mb-0">
                          <button type="submit" class="btn btn-outline-custom form-control1 mt-3 w-100" name="AksiBarangTambah" value="Simpan">
                                    <i class="fa fa-plus-circle"></i>   Tambah Barang
                                  </button>

                            <button class="btn btn-outline-secondary form-control1 mt-3 w-100" name="AksiBarangTambah" value="Cancel">
                                Cancel
                            </button>
                                 

                          </div>

                      </form>
                  </div>
            </div>

  </div>
@endsection
