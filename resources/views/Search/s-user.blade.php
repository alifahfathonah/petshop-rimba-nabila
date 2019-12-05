@extends('layouts.dash')
@section('title','Data Pengguna | Rimba Petshop')
@section('side')
@endsection
@section('content')

    <div class="clearfix">
        <h1 class="text-custom float-left">Data Pengguna</h1>
      <form class="form-inline float-right" action="/SearchUser" method="get">
        @csrf
            <input class="form-control2 w-50 form-control-lg rounded-0 float-right" type="text" name="UseSearch"  placeholder="Search ... ">
            <button class="btn btn-outline-custom btn-lg rounded-0" type="submit" name="search">
              <i class="fa fa-search" aria-hidden="true"></i>
            </button>
      </form>
<div class="table-responsive">


  <table class="table table-hover" >
    <thead class="bg-foot text-light">
      <th>Nama Pengguna</th>
      <th>E-mail</th>
      <th>Posisi</th>
      <th>Alamat</th>
      <th> Aksi</th>
    </thead>
    @foreach ($dt_use as $user)


    <tbody>
      <td>{{$user->name}}</td>
      <td>{{$user->email}}</td>
      <td>{{$user->level}}</td>
      <td>{{$user->alamat}}</td>
      <td class="">

                         <!--  modal ganti Jabatan  -->
                         <button  type="button" class="btn btn-primary btn-sm" role="button" data-toggle="modal" data-target="#exampleModalCenter1{{$user->id}}">
              <i class="fa fa-edit"></i>  Ubah Jabatan</button>
              <!-- Modal -->
              <div class="modal fade" id="exampleModalCenter1{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter1Title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Ubah Jabatan</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form class="" action="/user/role/{{$user->id}}" method="post">
                        @csrf
                        @method('put')
                      Ubah Jabatan <strong>{{$user->email}}</strong> <i>{{$user->id}}</i> <strong>{{$user->name}}</strong> <br>
                      menjadi
                      <select id="jabatan" class="form-control1 w-auto my-2 {{ $errors->has('jabatan') ? ' is-invalid' : '' }}" name="jabatan" >
                        @foreach ($Roleee as $role )

                          <option value="{{$role->kd_level}}" selected >{{$role->level}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="modal-footer">


                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                        <button type="submit" id="update-btn" class="btn btn-primary btn-sm">  <i class="fa fa-edit"></i>Ubah Jabatan</button>
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
      {{$dt_use->appends(Request::only('UseSearch'))->links()}}
  </div>

  </div>
@endsection
