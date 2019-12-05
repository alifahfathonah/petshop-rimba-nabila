@extends('layouts.dash')
@section('title','Data Barang | Rimba Petshop')


@section('content')


  <div class="clearfix">
      <h1 class="text-custom float-left">Data Barang</h1>
    <form class="form-inline float-right" action="/SearchBarang" method="get">
      @csrf
          <input class="form-control2 w-50 form-control-lg rounded-0 float-right" type="text" name="BarSearch"  placeholder="Search ... ">
          <button class="btn btn-outline-custom btn-lg rounded-0" type="submit" name="search">
            <i class="fa fa-search" aria-hidden="true"></i>
          </button>
    </form>

</div>
@if (Session::has('SUCCESS'))
  <div class="alert alert-success alert-dismissable">
    <a class="panel-close close" data-dismiss="alert">×</a>
    <i class="fa fa-cube"></i>
      {{ Session::get('SUCCESS') }}
  </div>
@endif
@if (Session::has('hore'))
  <div class="alert alert-success alert-dismissable">
    <a class="panel-close close" data-dismiss="alert">×</a>
    <i class="fa fa-cube"></i>
      {{ Session::get('hore') }}
  </div>
@endif
@if (Session::has('search'))
  <div class="alert alert-danger alert-dismissable">
    <a class="panel-close close" data-dismiss="alert">×</a>
    <i class="fa fa-cube"></i>
      {{ Session::get('search') }}
  </div>
@endif
@if (Session::has('danger'))
  <div class="alert alert-danger alert-dismissable">
    <a class="panel-close close" data-dismiss="alert">×</a>
    <i class="fa fa-cube"></i>
      {{ Session::get('danger') }}
  </div>
@endif

    <hr>

<div class="table-responsive table-resp">




  <table class="table table-hover scroll-table " >
    <thead class="bg-foot text-light">
      <th>Kode Barang</th>
      <th>Nama Barang</th>
      <th>Stok</th>
      <th>Kategori</th>
      <th>Berat</th>
      <th>Harga</th>
      <th>Bahan</th>
      <th>Usia</th>
      <th>Gambar Produk</th>
      <th ><center>Aksi</center></th>

    </thead>

    @foreach ($items as $item)


    <tbody>
      <td>{{$item->kd_brg}}</td>
      <td>{{$item->nm_brg}}</td>
      <td>{{$item->stok}}</td>
      <td>{{$item->nm_kategori}}</td>
      <td>{{$item->berat}}</td>
      <td>{{$item->harga}}</td>
      <td>{{$item->bahan}}</td>
      <td>{{$item->usia}}</td>
      <td class="">
        <div class="card-inline-table">
          <div class="thumbnail-table">
            <img class="card-img-top " src="{!! asset('storage/'. $item->gambar) !!}" alt="Null" >
          </div>

        </div>

      </td>
      <td class="">
        <a href="/barang/{{$item->kd_brg}}/edit" class="btn btn-primary btn-sm w-75" role="button"><i class="fa fa-edit"></i>  Ubah</a> <br>
        <a href="/stok/{{$item->kd_brg}}/edit" class="btn btn-success btn-sm w-75 my-1" role="button"><i class="fa fa-plus-circle"></i>  Stok</a> <br>
        <button  type="button" class="btn btn-danger btn-sm  w-100" role="button" data-toggle="modal" data-target="#exampleModalCenter{{$item->kd_brg}}">
        <i class="fa fa-times-circle"></i> Hapus</button>



            <!-- Button trigger modal -->

                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter{{$item->kd_brg}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Hapus Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Anda yakin ingin menghapus Barang <strong>{{$item->kd_brg}}</strong> <strong>{{$item->nm_brg}}</strong> ?
                      </div>
                      <div class="modal-footer">
                        <form class="" action="/barang/{{$item->kd_brg}}" method="post">
                          @csrf
                          @method('delete')
                          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                          <button type="submit" id="delete-btn" class="btn btn-danger btn-sm">Hapus Barang</button>
                        </form>

                      </div>
                    </div>
                  </div>
                </div>
                <!-- modal end -->



      </td>
    </tbody>
    @endforeach

  </table>
<div class="pagination-wrapper">
    {{$items->links()}}
</div>



<center><a href="/create/barang" class="btn btn-success" role="button">  <i class="fa fa-plus-circle"></i> Tambah Barang</a></CENTER>
  </div>


@endsection
