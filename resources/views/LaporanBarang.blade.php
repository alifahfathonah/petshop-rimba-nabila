@extends('layouts.dash')
@section('title','Data Transaksi | Rimba Petshop')
@section('side')
@endsection
@section('content')
  <div class="clearfix">

      <h1 class="text-custom float-left">Laporan Barang</h1>

  </div>

  @if (Session::has('upload'))
    <div class="alert alert-success alert-dismissable">
      <a class="panel-close close" data-dismiss="alert">×</a>
      <i class="fa fa-file-text"></i>
        {{ Session::get('upload') }}
    </div>
  @endif
  @if (Session::has('NoFile'))
    <div class="alert alert-danger alert-dismissable">
      <a class="panel-close close" data-dismiss="alert">×</a>
      <i class="fa fa-file-text"></i>
        {{ Session::get('NoFile') }}
    </div>
  @endif
  @if (Session::has('danger'))
    <div class="alert alert-danger alert-dismissable">
      <a class="panel-close close" data-dismiss="alert">×</a>
      <i class="fa fa-tag"></i>
        {{ Session::get('danger') }}
    </div>
  @endif
  @if (Session::has('search'))
    <div class="alert alert-danger alert-dismissable">
      <a class="panel-close close" data-dismiss="alert">×</a>
      <i class="fa fa-tag"></i>
        {{ Session::get('search') }}
    </div>
  @endif
  <hr>

<div class="table-responsive">
  <div class="card-body mx-2">



          <form method="post" action="/ReportBarang/Search" enctype="multipart/form-data" novalidate>
              @csrf
              Pencarian
                 <input type="hidden" name="kd_brg" value="">
                  <input id="tgl_awal" type="date" class="form-control1" name="tgl_awal"  >

                      <input id="tgl_akhir" type="date" class="form-control1 w-auto my-2" name="tgl_akhir"  >
              <div class="form-group row mb-0">
                <button class="btn btn-outline-secondary form-control1 mt-3 w-100" name="AksiFilter" value="Filter">
                  Filter
                </button>
              </div>

          </form>
      </div>
</div>




  <table class="table table-hover scroll-table" >
    <thead class="bg-foot text-light">
      <th>Kode Barang</th>
      <th>Stok</th>
      <th>Harga Barang</th>
      <th>Berat</th>
      <th>Tanggal Update</th>
      
     

    </thead>
    @foreach ($RepBarang as $RB)
      <tbody>
        <td>{{$RB->kd_brg}}</td>
        <td>{{$RB->stok}}</td>
        <td>{{$RB->harga}}</td>
        <td>{{$RB->berat}}</td>
        <td>{{date('d-m-Y', strtotime($RB->updated_at))}}</td>
            
      </tbody>
    @endforeach
  </table>



  </div>

@endsection
