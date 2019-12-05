@extends('layouts.dash')
@section('title','Riwayat Pemesanan | Rimba Petshop')
@section('side')
@endsection
@section('content')
  <div class="clearfix">
      <h1 class="text-custom float-left">Riwayat Pemesanan</h1>
    <form class="form-inline float-right" action="/SearchRiwayat" method="get">
      @csrf
          <input class="form-control2 w-50 form-control-lg rounded-0 float-right" type="text" name="HisSearch"  placeholder="Cari ... ">
          <button class="btn btn-outline-custom btn-lg rounded-0" type="submit" name="search">
            <i class="fa fa-search" aria-hidden="true"></i>
          </button>

    </form>

  </div>
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




  <table class="table table-hover" >
    <thead class="bg-foot text-light">
      <th>Kode Transaksi</th>
      <th>Status</th>
      <th>Tanggal Pemesanan</th>
    </thead>
    @foreach ($dt_his as $RiwayatShow)


    <tbody>
      <td><a href="/Rincian/{{$RiwayatShow->kd_trans}}" class="text-custom">{{$RiwayatShow->kd_trans}}</a></td>
      <td>{{$RiwayatShow->status}}</td>
      <td>{{date('d-m-Y', strtotime($RiwayatShow->created_at))}}</td>
    </tbody>
    @endforeach
  </table>

  <div class="pagination-wrapper">
      {{$dt_his->appends(Request::only('HisSearch'))->links()}}
  </div>


  </div>
@endsection
