@extends('layouts.base-cart')
@section('title','Keranjang Belanja | Rimba Petshop')
@section('content')


  <section class="jumbotron text-center my-5">
      <div class="container">
          <h1 class="jumbotron-heading">Keranjang Belanja</h1>
       </div>
  </section>
  @if (Session::has('StokKurang'))
    <div class="alert alert-danger alert-dismissable">
      <a class="panel-close close" data-dismiss="alert">×</a>
      <i class="fa fa-exclamation-circle"></i>
        {{ Session::get('StokKurang') }}
    </div>
  @endif
  @if (Session::has('dangerplus'))
    <div class="alert alert-danger alert-dismissable">
      <a class="panel-close close" data-dismiss="alert">×</a>
      <i class="fa fa-exclamation-circle"></i>
        {{ Session::get('dangerplus') }}
    </div>
  @endif
  @if (Session::has('danger'))
    <div class="alert alert-danger alert-dismissable">
      <a class="panel-close close" data-dismiss="alert">×</a>
      <i class="fa fa-exclamation-circle"></i>
        {{ Session::get('danger') }}
    </div>
  @endif
  @if (Session::has('DangerKosong'))
    <div class="alert alert-danger alert-dismissable">
      <a class="panel-close close" data-dismiss="alert">×</a>
      <i class="fa fa-address-book"></i>
        {{ Session::get('DangerKosong') }}
    </div>
  @endif
  <div class="container mb-4">
      <div class="row">
          <div class="col-12">
              <div class="table-responsive">
                  <table class="table table-striped">
                      <thead>
                          <tr>
                              <th scope="col"> </th>
                              <th scope="col">Nama Barang</th>
                              <th scope="col">Stok Tersedia</th>
                              <th scope="col">Jumlah</th>
                              <th scope="col" class="text-right">Harga </th>
                              <th> </th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($uid->barangs as $tes)
                          <tr>
                            <form id="formQty" action="/cart/list/{{Auth::id() }}" method="POST">
                              @csrf
                              @method('PATCH')
                              <input type="hidden" id="kod_barang" name="kod_barang" value="{{ $tes->kd_brg}}">
                              <td id="anchor{{$tes->kd_brg}}"><img src="{!! asset('storage/'. $tes->gambar) !!}" class="img-cart" /> </td>
                              <td>{{  $tes->nm_brg}}</td>

                              <td>{{  $tes->stok}}</td>
                              <td>

                                    			<div class="input-group number-spinner text-cart">
                                    				<span class="input-group-btn ">

                                    					<button class="btn btn-default no-radius" type="submit" id="down" name="aksi" value="down" data-dir="dwn"><span class="fa fa-minus"></span></button>
                                    				</span>

                                    				      <input type="text" id="jumlah" name="jumlah" class="form-control Qty " value="{{  $tes->pivot->jumlah}}" readonly >


                                          	<span class="input-group-btn">

                                                <button class="btn btn-default no-radius" type="submit" id="up" name="aksi" value="up" data-dir="up"><span class="fa fa-plus"></span></button>
                                              </form>
                                    				</span>
                                    			</div>


                                  {{-- <script type="text/javascript">
                                  $('#up').click(function() {
                                    var jumlah =$('#jumlah').val();
                                    $.ajax({
                                        type: "PATCH",
                                        url: "{{url('/cart/list/',Auth::id())}}"
                                        dataType: 'json',
                                        data: {
                                            jumlah: $('#jumlah').val(),
                                            user_id: {{ Auth::id() }},
                                            _token: $('input[name="_token"]').val(),
                                        },
                                        success: function(data) {
                                            if (data.response == true) {
                                                $jumlah.val(data.jumlah);
                                                }

                                  </script>
 --}}







                              </td>

                              <td class="text-right">{{  $tes->pivot->jumlah * $tes->harga}}</td>
                              <td class="text-right">
                                <form class="" action="/cart/list/{{Auth::id() }}/{{$tes->kd_brg}}" method="post">
                                  @csrf
                                  <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> </button>
                                </form>

                              </td>
                          </tr>
                          @endforeach
                          <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td class="text-right">
                              </td>
                          </tr>

                          <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td>Total</td>
                              <td class="text-right">Rp.
                                {{
                                  $brg_total
                                }}
                              </td>
                          </tr>

                      </tbody>
                  </table>
              </div>
          </div>

          <div class="col mb-2">
              <form class="" action="/cart/Proc" method="post">
                @csrf
            <div class="clearfix">
                      <button class="btn  btn-outline-secondary float-left w-50" name="CartAction" value="back">Lanjutkan Belanja</button>
                      <button class="btn  btn-success float-right w-50" name="CartAction" value="Checkout">Pembayaran</button>
            </div>
            </form>
          </div>

      </div>
  </div>
@endsection
