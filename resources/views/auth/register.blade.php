@extends('layouts.app')
@section('title','Daftar | Rimba Petshop')
@section('content')
<div>
@if($errors)
   @foreach ($errors->all() as $error)
   <div class="alert alert-danger alert-dismissable">
    <a class="panel-close close" data-dismiss="alert">×</a>
    <i class="fa fa-cube"></i>
      {{$error}}
  </div>
     
  @endforeach
@endif


</div>
<div class="d-lg-flex w-100 mt-lg-5 pt-5">


            <div class="card mx-auto w-50 ">
                <div class="card-header bg-foot"><h4 class="text-light">Daftar</h4> </div>

                <div class="card-body mx-2">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <input type="hidden" name="level" value="1">

                                <input id="name" type="text" class="form-control1 w-auto my-2 {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Nama" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif

                                <input id="email" type="email" class="form-control1 w-auto my-2 {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="E-Mail" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                                <input id="password" type="password" class="form-control1 w-auto my-2 {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif


                            <input id="password-confirm" type="password" class="form-control1 w-auto my-2" name="password_confirmation" placeholder="Konfirmasi Password" required>

                        <div class="form-group row mb-0">

                                <button type="submit" class="btn btn-outline-custom w-100 my-3">
                                    Daftar
                                </button>

                        </div>
                    </form>
                </div>
          </div>

</div>
@endsection
