@extends('layouts.dash')
@section('title','Data Transaksi | Rimba Petshop')
@section('side')
@endsection
@section('content')
  <div class="clearfix">

      <h1 class="text-custom float-left">Data Transaksi </h1>
    <form class="form-inline float-right" action="/CariPesanan" method="get">
      @csrf
          <input class="form-control2 w-50 form-control-lg rounded-0 float-right" type="text" name="AdmHisSearch"  placeholder="Cari ... ">
          <button class="btn btn-outline-custom btn-lg rounded-0" type="submit" name="search">
            <i class="fa fa-search" aria-hidden="true"></i>
          </button>

    </form>

  </div>

  @if (Session::has('upload'))
    <div class="alert alert-success alert-dismissable">
      <a class="panel-close close" data-dismiss="alert">×</a>
      <i class="fa fa-file-text"></i>
        {{ Session::get('upload') }}
    </div>
  @endif
  
  @if (Session::has('Berhasil'))
    <div class="alert alert-success alert-dismissable">
      <a class="panel-close close" data-dismiss="alert">×</a>
      <i class="fa fa-edit"></i>
        {{ Session::get('Berhasil') }}
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




  <table class="table table-hover scroll-table" >
    <thead class="bg-foot text-light">
      <th>Kode Transaksi</th>
      <th>Pembeli</th>
      <th>Status</th>
      <th>Tanggal Pemesanan</th>
      <th></th>

    </thead>
    @if (Auth::check() && strtoupper(Auth::user()->join('roles','roles.kd_level','=','users.kd_level')->find(Auth::id())->level) == strtoupper('KURIR'))
    @foreach ($trans_kurir as $RiwayatShows)
    <tbody>
      <td><a href="/Rincian/{{$RiwayatShows->kd_trans}}" class="text-custom">{{$RiwayatShows->kd_trans}}</a></td>
      <td>{{$RiwayatShows->email}}</td>
      <td>{{$RiwayatShows->status}}</td>
      <td>{{date('d-m-Y', strtotime($RiwayatShows->created_at))}}</td>
      <td>
      </td>
    </tbody>
    @endforeach

  
    @else
    
    @foreach ($dt_transaksi as $RiwayatShow)


    <tbody>
      <td><a href="/Rincian/{{$RiwayatShow->kd_trans}}" class="text-custom">{{$RiwayatShow->kd_trans}}</a></td>
      <td>{{$RiwayatShow->email}}</td>
      <td>{{$RiwayatShow->status}}</td>
      <td>{{date('d-m-Y', strtotime($RiwayatShow->created_at))}}</td>
      <td>
  


      </td>

    </tbody>
    @endforeach

  @endif  

  </table>

  @if (Auth::check() && strtoupper(Auth::user()->join('roles','roles.kd_level','=','users.kd_level')->find(Auth::id())->level) == strtoupper('KURIR'))
      <div class="pagination-wrapper">
        {{$trans_kurir->links()}}
      </div>
      @else
      <div class="pagination-wrapper">
          {{$dt_transaksi->links()}}
      </div>
      @endif


  </div>

@endsection
