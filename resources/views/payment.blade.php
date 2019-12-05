@extends('layouts.base-cart')
@section('title','Keranjang Belanja | Rimba Petshop')
@section('content')

  @if (Session::has('MetodePay'))
    <div class="alert alert-danger alert-dismissable">
      <a class="panel-close close" data-dismiss="alert">×</a>
      <i class="fa fa-user"></i>
        {{ Session::get('MetodePay') }}
    </div>
  @endif

  <div class="box-alamat">
    <div class="border-alamat"></div>
    <div class="box-alamat-text">
      <div class="alamat-title">
        <div class="alamat-text"><i class="fa fa-map-marker">  </i>
        Alamat Pengiriman
        </div>
      </div>
      <div class="payment-user">
        <div class="payment-user-alamat mb-5">
          <div class="payment-user-detail">
          <p class="pt-4">{{$Cart->pluck('no_hp')->first()}}<br>
           {{$Cart->pluck('name')->first()}}</p>
          </div>
          <div class="payment-user-alamat-detail  w-50">
        {{$Cart->pluck('alamat')->first()}}   {{$Cart->pluck('kota')->first()}}
          </div>
        </div>
      </div>
    </div>
    <div class="border-alamat"></div>
  </div>

  <div class="payment-method-wrapper">
    <div class="payment-method-view">
      <div class="payment-method-box payment-method-rule">
        <div class="payment-method-title">Pilih Metode Pembayaran : </div>



        <form class="" action="/transaksi/pembayaran/proses" method="POST">
          @csrf
          @method('PUT')
            <div class="switch-field">
              <div class="mb-4"></div>

              <input type="radio" id="switch_3_left" name="PayMethod" value="Transfer" />
              <label for="switch_3_left">Transfer Bank</label>
              @if ( $free->contains(strtoupper($kota_usr)) == true)
                <input type="radio" id="switch_3_center" name="PayMethod" value="COD" />
                <label for="switch_3_center">Cash-on-Delivery</label>
              @else
                <input type="radio" id="switch_3_center" name="PayMethod" value="COD" disabled/>
                <label for="switch_3_center">Cash-on-Delivery</label>
              @endif

            </div>


    </div>
    <div class="ml-5 m-4  desc" id="Transfer">
      <p>Pembayaran dilakukan dengan mentransfer total biaya ke :<br>
      <strong>Rekening BCA : (014) 01232312 A/N Rimba</strong></p>
    </div>
    <div class="ml-5 m-4 desc" id="COD">
      <p>Kurir akan menghubungi jika barang siap diantar.
      Pembayaran dilakukan ketika barang sudah sampai dirumah pembeli, dan pembeli harus memperlihatkan bukti transfer kepada kurir.</p>
    </div>

      <table class="table table-light mx-5">
        <tr>
          <td>Total Harga Barang</td>
          <td></td>
          <td></td>
          <td></td>
            <td></td>
              <td></td>
          <td></td>
          <td>{{$kalkulasi}}</td>
        </tr>

        <tr>
          <td>Baya Pengiriman</td>
          <td></td>
          <td></td>
          <td></td>
              <td></td>
            <td></td>
          <td></td>
          @if ($free->contains($kota_usr) == true)
            <td>Gratis <input type="hidden" name="ongkir" value="0"></td>
            @else
            <td>20000 <input type="hidden" name="ongkir" value="20000"></td>
          @endif

        </tr>
        <tr>
          <td>Total biaya</td>
          <td>  </td>
            <td> </td>
                <td></td>
          <td></td>
          <td></td>
          <td></td>
        @if ($free->contains($kota_usr) == true)
          <td>{{$kalkulasi }}</td>
          @else
          <td>{{$kalkulasi + 20000}}</td>
        @endif
        </tr>
      </table>

    <div class="clearfix">
              <button class="btn  btn-outline-secondary float-left w-50" name="PaymentAction" value="Cancel">Cancel</button>
              @if (Auth::user()->kota == null OR Auth::user()->alamat == null )
                <button class="btn  btn-success float-right w-50" name="PaymentAction" value="Beli" disabled>Bayar</button>
              @else
                <button class="btn  btn-success float-right w-50" name="PaymentAction" value="Beli">Bayar</button>
              @endif
    </div>
    </form>

  </div>
@endsection
