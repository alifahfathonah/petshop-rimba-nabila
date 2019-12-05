@extends('layouts.dash')
@section('title','Data Transaksi | Rimba Petshop')
@section('side')
@endsection
@section('content')
  <div class="clearfix">

      <h1 class="text-custom float-left">Laporan Transaksi </h1>


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
Filter
                 <input type="hidden" name="kd_brg" value="">
                  <input id="nm_brg" type="date" class="form-control1" value="{{ $tgawal  }}" name="tgl_awal"  >

                      <input id="harga" type="date" class="form-control1 w-auto my-2" value="{{ $tgakhir }}" name="tgl_akhir"  >
              <div class="form-group row mb-0">
                <button class="btn btn-outline-secondary form-control1 mt-3 w-100" name="AksiFilter" value="Filter">
                  Filter
                </button>
              </div>

          </form>
      </div>
</div>


<form action="/ReportTrans/Download/Transaksi" method="post">
  @csrf
  <input type="hidden" name="filawal" value="{{ $tgawal  }}">
    <input type="hidden" name="filakhir" value="{{ $tgakhir  }}">
    @if($tgawal > $tgakhir)
    <button class="btn btn-primary" type="submit" disabled>Unduh PDF</button>
    @else
    <button class="btn btn-primary" type="submit" formtarget="_blank">Unduh PDF</button>
    @endif
</form>

  <table class="table table-hover scroll-table" >
    <thead class="bg-foot text-light">
      <th>Kode Transaksi</th>
      <th>Status</th>
      <th>Tanggal Pemesanan</th>
      <th>Total Pembelian</th>

      <th></th>

    </thead>
  @foreach ($FilTrans as $report)
    <tbody>

        <td>{{$report->kd_trans}}</td>
        <td>{{ $report->status}}</td>
        <td>{{date('d-m-Y', strtotime($report->created_at))}}</td>
        <td>Rp. {{ $report->grand_biaya}}</td>

    </tbody>
  @endforeach
  <tfoot>
    <td></td>
    <td>Jumlah</td>
    <td></td>
    <td>Rp. {{ $FilTrans->sum('grand_biaya') }}</td>
  </tfoot>
  </table>



  </div>

@endsection
