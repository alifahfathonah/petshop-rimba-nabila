@extends('layouts.idx-search')
@section('title','Home | Rimba Petshop')
@section('content')
  <!--form search start  -->
<div class="container-fluid w-100 mt-lg-3 pt-5">
<form class="form-inline " action="/SearchProduk" method="get">
  @csrf
      <input class="form-control2 form-control-lg rounded-0" type="text" name="ProSearch" value="" placeholder="Search">
      <button class="btn btn-outline-custom btn-lg rounded-0" type="submit" name="search">
        <i class="fa fa-search" aria-hidden="true"></i>
      </button>
</form>
</div>
  <!--form search end  -->

  @if (Session::has('success'))
      <div class="alert alert-success">
          <p>{{ Session::get('success') }}</p>
      </div>
  @endif
  @if (Session::has('danger'))
      <div class="alert alert-danger">
          <p>{{ Session::get('danger') }}</p>
      </div>
  @endif

  <div class="container-fluid w-100 mt-lg-5 pt-2">

<div class="row ml-5 pl-4">

@foreach ($dt_pro as $barang)

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
              Jenis Makanan : {{ $barang->nm_kategori }}<br>
              Merk : {{ $barang->merk }}<br>
              @guest
                <a href="/login" role="button" class="btn btn-outline-custom w-75 mx-4 my-3">Add to Cart</a>
              @else

              <button  type="button" class="btn btn-outline-custom w-75 mr-2 my-3" role="button" data-toggle="modal" data-target="#exampleModalCenter{{$barang->kd_brg}}">
              <i class="fa fa-cart" aria-hidden="true"></i>Add to Cart</button>
                  <!-- Button trigger modal -->
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
              <h5 class="modal-title" id="exampleModalLongTitle">Hapus Barang</h5>
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
</div>

@endsection
