@extends('layouts.dash')
@section('title','Data Kategori | Rimba Petshop')

@section('content')

@if (Session::has('horeUpdate'))
    <div class="alert alert-success alert-dismissable">
      <a class="panel-close close" data-dismiss="alert">×</a>
      <i class="fa fa-edit"></i>
        {{ Session::get('horeUpdate') }}
    </div>
  @endif
@if (Session::has('hore'))
    <div class="alert alert-success alert-dismissable">
      <a class="panel-close close" data-dismiss="alert">×</a>
      <i class="fa fa-tag"></i>
        {{ Session::get('hore') }}
    </div>
  @endif
@if (Session::has('dangerkat'))
    <div class="alert alert-danger alert-dismissable">
      <a class="panel-close close" data-dismiss="alert">×</a>
      <i class="fa fa-tag"></i>
        {{ Session::get('dangerkat') }}
    </div>
  @endif
  @if (Session::has('search'))
    <div class="alert alert-danger alert-dismissable">
      <a class="panel-close close" data-dismiss="alert">×</a>
      <i class="fa fa-tag"></i>
        {{ Session::get('search') }}
    </div>
  @endif
  <div class="clearfix">
      <h1 class="text-custom float-left">Data Kategori</h1>
    <form class="form-inline float-right" action="/SearchKategori" method="get">
      @csrf
          <input class="form-control2 w-50 form-control-lg rounded-0 float-right" type="text" name="KatSearch"  placeholder="Search ... ">
          <button class="btn btn-outline-custom btn-lg rounded-0" type="submit" name="search">
            <i class="fa fa-search" aria-hidden="true"></i>
          </button>

    </form>

  </div>

  <hr>

<div class="table-responsive">




  <table class="table table-hover" >
    <thead class="bg-foot text-light">
      <th>Kode Kategori</th>
      <th>Nama Kategori</th>
      <th> Aksi</th>
    </thead>
    @foreach ($kategoris as $kategori)


    <tbody>
      <td>{{$kategori->kd_kategori}}</td>
      <td>{{$kategori->nm_kategori}}</td>
      <td class=""><a href="/kategori/edit/{{$kategori->kd_kategori}}" class="btn btn-primary btn-sm" role="button"><i class="fa fa-edit"></i>  Ubah</a>
          <button  type="button" class="btn btn-danger btn-sm" role="button" data-toggle="modal" data-target="#exampleModalCenter{{$kategori->kd_kategori}}">
            <i class="fa fa-times-circle"></i>  Hapus</button>
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter{{$kategori->kd_kategori}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Hapus Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    Anda yakin ingin menghapus Kategori <strong>{{$kategori->kd_kategori}}</strong> <strong>{{$kategori->nm_kategori}}</strong> ?
                  </div>
                  <div class="modal-footer">
                    <form class="" action="/kategori/{{$kategori->kd_kategori}}" method="post">
                      @csrf
                      @method('delete')
                      <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                      <button type="submit" id="delete-btn" class="btn btn-danger btn-sm">Hapus Kategori</button>
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
    {{$kategoris->links()}}
</div>

<center><a href="/create/kategori" class="btn btn-success" role="button">  <i class="fa fa-plus"></i> Tambah Kategori</a></CENTER>
  </div>
@endsection
