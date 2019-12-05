@extends('layouts.idx')
@section('title','Home | Rimba Petshop')
@section('content')
  <!--form search start  -->
<form class="form-inline " action="/SearchProduk" method="get">
  @csrf
      <input class="form-control2 form-control-lg rounded-0" type="text" name="ProSearch" value="" placeholder="Search">
      <button class="btn btn-outline-custom btn-lg rounded-0" type="submit" name="search">
        <i class="fa fa-search" aria-hidden="true"></i>
      </button>
</form>
  <!--form search end  -->

  @if (Session::has('success'))
      <div class="alert alert-success">
          <p>{{ Session::get('success') }}</p>
      </div>
  @endif
  @if (Session::has('Sold'))
      <div class="alert alert-danger">
          <p>{{ Session::get('Sold') }}</p>
      </div>
  @endif
  @if (Session::has('dangerplus'))
      <div class="alert alert-danger">
          <p>{{ Session::get('dangerplus') }}</p>
      </div>
  @endif
  @if (Session::has('danger'))
      <div class="alert alert-danger">
          <p>{{ Session::get('danger') }}</p>
      </div>
  @endif
  @if (Session::has('CartKosong'))
      <div class="alert alert-danger">
          <p>{{ Session::get('CartKosong') }}</p>
      </div>
  @endif
<div class="row ml-5 pl-4">

@foreach ($barangs as $barang)

    <div class="mr-2 mt-3 mb-2">
      <div class="column">
        <div class="card-inline ">

          <div class="thumbnail">
            <img class="card-img-top fit" src="{!! asset('storage/'. $barang->gambar) !!}" alt="Card image cap">
          </div>
          <div class="card-body p-0 ">
            <div class="card-header ">
              <h5>{{ $barang->nm_brg }}</h5>
            </div>
            <p class="card-text text-sm-left mt-2 px-3 " id="style-1">
              Harga : {{ $barang->harga }} <br>
              Berat : {{ $barang->berat }}<br>
              Bahan : {{ $barang->bahan }}<br>
              Stok : {{  $barang->stok }}<br>
              Jenis Makanan : {{ $barang->nm_kategori }}<br>
              Usia : {{ $barang->usia }}<br>
            
              @guest
              @if ($barang->stok <= 0)
                  <button  type="button" class="btn btn-danger w-75 mr-2 my-3" disabled>Stok Habis !</button>
                @else
                <a href="/login" role="button" class="btn btn-outline-custom w-75 mx-4 my-3">Tambahkan Ke Keranjang</a>
                @endif
              @else
              @if ($barang->stok <= 0)
                  <button  type="button" class="btn btn-danger w-75 mr-2 my-3" disabled>Stok Habis !</button>
                  @else
              
              <button  type="button" class="btn btn-outline-custom w-75 mr-2 my-3" role="button" data-toggle="modal" data-target="#exampleModalCenter{{$barang->kd_brg}}">
   
              <i class="fa fa-cart" aria-hidden="true"></i>Tambahkan Ke Keranjang</button>
                  <!-- Button trigger modal -->
                  @endif
              @endguest    
          </p>
          </div>
        </div>
      </div>



      <!-- Modal -->
      <div class="modal fade" id="exampleModalCenter{{$barang->kd_brg}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Masukkan Ke Keranjang</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="" action="/cart/add/{{$barang->kd_brg}}" method="post">
              @csrf
            <div class="modal-body">

              <input type="hidden" name="CartBarang" value="{{$barang->kd_brg}}">

              Tambahkan <strong>{{ $barang->nm_brg }}</strong> ke keranjang ? <br>
              <div class="input-group input-group-sm">
                <small>Harga Satuan : {{$barang->harga}}</small> <br>
              </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                <button  class="btn btn-success btn-sm">Tambahkan ke Keranjang</button>
              </form>

            </div>
          </div>
        </div>
      </div>

      <!-- modal end -->

</div>

@endforeach
</div>
<div class="pagination-wrapper">
    {{$barangs->links()}}
</div>
@endsection
