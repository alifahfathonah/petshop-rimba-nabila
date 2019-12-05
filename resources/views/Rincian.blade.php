@extends('layouts.dash')
<!-- @section('title','Data Transaksi | Rimba Petshop') -->

@section('content')
@if($errors)
   @foreach ($errors->all() as $error)
   <div class="alert alert-danger alert-dismissable">
    <a class="panel-close close" data-dismiss="alert">×</a>
    <i class="fa fa-exclamation-circle"></i>
      {{$error}}
  </div>
     
  @endforeach
@endif
  <div class="table-responsive table-resp-rincian">
      <table class="table table-hover scroll-table">
        <div class="clearfix ">
          <p class="float-left ">Kode Transaksi : <strong>{{$trans->kd_trans  }} </strong></p>

          <p class="float-right mr-5">Status : <strong>{{$trans->status  }} </strong></p>
        </div>
        <div class="clearfix">
          <p class="float-left mr-5 pr-5">Pemesan : <strong>{{$trans->user->email  }} </strong></p>
          <p class="float-left ml-5 pl-5">No.Telp Pemesan : <strong>{{$trans->user->no_hp  }} </strong></p>
            <p class="float-right w-25">Alamat : <strong>{{$trans->user->alamat  }} </strong></p>

        </div>
        @if (Session::has('dangerplus'))
    <div class="alert alert-danger alert-dismissable">
      <a class="panel-close close" data-dismiss="alert">×</a>
      <i class="fa fa-exclamation-circle"></i>
        {{ Session::get('dangerplus') }}
    </div>
  @endif


          <thead class="bg-foot text-light">
              <tr>
                  <th scope="col"> </th>
                  <th scope="col">Nama Barang</th>
                  <th scope="col">Jumlah</th>
                  <th scope="col">Harga</th>
                  <th scope="col" class="text-right">total </th>
                  <th> </th>
              </tr>
          </thead>
          <tbody>
            
              @foreach ($dt_rincian as $rinci)
              <tr>


                  <td ><img src="{!! asset('storage/'. $rinci->gambar) !!}" class="img-cart"/></td>

                <td>{{$rinci->nm_brg}}</td>

                  <td>{{$rinci->jml_brg}}</td>
                  <td>
                    {{$rinci->hrg_brg}}
                  </td>

                  <td class="text-right">{{$rinci->total}}</td>
                  <td class="text-right"></td>
              </tr>
              @endforeach
              <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>Total Biaya Barang</td>
                  <td class="text-right">Rp.{{$trans->total_beli  }} </td>

              </tr>
              <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>Biaya Pengiriman</td>
                  <td class="text-right">Rp.{{$trans->ongkir  }}  </td>
              </tr>

              <tr>
                  <td>Bukti Transfer</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>Total</td>
                  <td class="text-right">Rp.{{$trans->grand_biaya  }}
                  </td>
              </tr>
              <tr>
                <form action="/Rincian/Upload" method="POST" enctype="multipart/form-data" novalidate>
                  @csrf
                  @method('PUT')
                  @if (Auth::check() && Auth::user()->kd_level == "4")
                    <td><input type="file" name="bukti" class="form-control-file">
                      <input type="hidden" name="kd_trans" value="{{$trans->kd_trans}}"></td>
                    <td>   <button type="submit" class="btn btn-primary" name="AksiUpload" value="Upload">Unggah Bukti</button> </td>
                  @else
                    <td></td>
                    <td></td>
                  @endif


                  <td>  </td>
                  <td></td>
                  <td></td>
                  <td class="text-right">

                  </td>
                  </form>
              </tr>
              <tr>
                <div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
                   <div class="modal-dialog modal-lg" role="document">
                     <div class="modal-content">
                       <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                       </div>
                       <div class="modal-body">
                         <img src="" class="enlargeImageModalSource" style="width: 100%;">
                       </div>
                     </div>
                   </div>
               </div>
                  <td class=""><img src="{!! asset('storage/'. $trans->bukti) !!}" alt="Bukti Transfer" class="card img-cart border-cust img-besar"/></td>
                  <script type="text/javascript">
                  $(function() {
                      $('.img-besar').on('click', function() {
                      $('.enlargeImageModalSource').attr('src', $(this).attr('src'));
                      $('#enlargeImageModal').modal('show');
                    });
                  });
                  </script>
                  <td>  </td>
                  <td> </td>
                  <td></td>
                  <td></td>
                  <td class="text-right">

                  </td>
              </tr>
          </tbody>
      </table>
      @if (Auth::check() && Auth::user()->kd_level == "4" OR Auth::check() && strtoupper(Auth::user()->join('roles','roles.kd_level','=','users.kd_level')->find(Auth::id())->level) == strtoupper('PEMILIK'))
      @else
          <center>
            <button name="button" class="btn btn-success float-center mb-2" role="button" data-toggle="modal" data-target="#exampleModalCenter{{$trans->kd_trans}}">
              <i class="fa fa-gear"></i>Konfirmasi Pemesanan</button>
              <!-- Modal -->
              <div class="modal fade" id="exampleModalCenter{{$trans->kd_trans}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi Pemesanan</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form class="" action="/Transaksi/{{$trans->kd_trans}}" method="post">
                        @csrf
                        @method('put')
                        <select class="form-control" name="Konfirmasi">
                        <option class="form-control" value="Bukti Pembayaran Salah">Bukti Pembayaran Salah  </option>
                          <option class="form-control" value="Pesanan Sedang Diantar">Pesanan Sedang Diantar  </option>
                          <option class="form-control" value="Pesanan Dicancel ">Pesanan Dicancel  </option>
                          <option class="form-control" value="Barang Telah Diterima Pembeli">Barang Telah Diterima Pembeli </option>
                        </select>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                        <button type="submit"  class="btn btn-success btn-sm">Ubah Status Pemesanan</button>
                      </form>

                    </div>
                  </div>
                </div>
              </div>
              <!-- modal end -->
          </CENTER>


      @endif

  </div>

      @endsection
