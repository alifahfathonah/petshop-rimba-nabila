@extends('layouts.dash')
@section('title','Data Transaksi | Rimba Petshop')
@section('side')
@endsection
@section('content')
  <div class="clearfix">

      <h1 class="text-custom float-left">Laporan Transaksi</h1>

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



          <form method="post" action="/ReportTrans/Search" enctype="multipart/form-data" novalidate>
              @csrf

              <h3 class="text-custom">Pencarian</h3>
                
                  <input id="nm_brg" type="date" class="form-control1" placeholder="Tanggal Awal" name="tgl_awal"  >

                      <input id="harga" type="date" class="form-control1 w-auto my-2" placeholder="Tanggal Akhir" name="tgl_akhir"  >
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
      <th>Kode Transaksi</th>

      <th>Status</th>
      <th>Tanggal Pemesanan</th>
      <th>Total Pembelian</th>

      <th></th>

    </thead>
    @foreach ($RepTrans as $RT)
      <tbody>
        <td>{{$RT->kd_trans}}</td>
        <td>{{$RT->status}}</td>
        <td>{{date('d-m-Y', strtotime($RT->created_at))}}</td>
            <td>Rp. {{$RT->grand_biaya}}</td>
      </tbody>
    @endforeach
  </table>



  </div>

@endsection
