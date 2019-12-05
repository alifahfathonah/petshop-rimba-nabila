@extends('layouts.idx')
@section('title','Home | Rimba Petshop')
@section('content')
  <!--form search start  -->
<form class="form-inline " action="" method="post">
      <input class="form-control2 form-control-lg rounded-0" type="text" name="" value="" placeholder="Search">
      <button class="btn btn-outline-custom btn-lg rounded-0" type="submit" name="button">
        <i class="fa fa-search" aria-hidden="true"></i>
      </button>
</form>
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
              Jenis Makanan : {{ $barang->nm_kategori }}<br>
              Merk : {{ $barang->merk }}<br>
              @guest
                <a href="/login" role="button" class="btn btn-outline-custom w-75 mx-4 my-3">Add to Cart</a>
              @else
                <form class="card-text" action="/cart/add/{{$barang->kd_brg}}" method="post">
                  @csrf
              <button  type="submit" class="btn btn-outline-custom w-75 mr-2 my-3">
              <i class="fa fa-cart" aria-hidden="true"></i>Add to Cart</button>
              </form>
                  <!-- Button trigger modal -->
                  @endguest

          </p>
          </div>
        </div>
      </div>


</div>
@endforeach
</div>
@endsection
