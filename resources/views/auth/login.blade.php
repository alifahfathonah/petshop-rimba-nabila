@extends('layouts.app')
@section('title','Login | Rimba Petshop')
@section('content')
<div>
@if (Session::has('updatedpass'))
          <div class="alert alert-success alert-dismissable w-100">
            <a class="panel-close close" data-dismiss="alert">×</a>
            <i class="fa fa-lock"></i>
              {{ Session::get('updatedpass') }}
          </div>
@endif
@if($errors)
   @foreach ($errors->all() as $error)
   <div class="alert alert-danger alert-dismissable">
    <a class="panel-close close" data-dismiss="alert">×</a>
    <i class="fa fa-exclamation-triangle"></i>
      {{$error}}
  </div>
     
  @endforeach
@endif

</div>
<div class="d-lg-flex w-100 mt-lg-5 pt-5">


            <div class="card mx-auto w-50 ">
                <div class="card-header bg-foot"><h4 class="text-light">Login</h4></div>

                <div class="card-body mx-2">
                    <form method="POST" action="{{ route('login') }}" class="form-control border-0">
                        @csrf
                        <div class="input-group my-2">
                          <div class="input-group-prepend prep-cust">
                            <span class="input-group-text " id="basic-addon1"><i class="fa fa-user-circle-o"></i></span>
                          </div>
                         

                          <input id="email" type="email" placeholder="E-mail" class="form-control1 pl-5  {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus aria-label="Username" aria-describedby="basic-addon1" >
                          @if ($errors->has('email'))
                              <span class="invalid-feedback">
                                  <strong>{{ $errors->first('email') }}</strong>
                              </span>
                          @endif
                        </div>




                                  <div class="input-group mt-4">
                                    <div class="input-group-prepend prep-cust ">
                                      <span class="input-group-text " id="basic-addon1"><i class="fa fa-lock"></i></span>
                                    </div>
                                    <input id="password" type="password" placeholder="Password" class="form-control1 pl-5{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                  </div>


                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif



                                <div class="checkbox my-3">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                    <br>
                                      <small class="">Belum Memiliki Akun ? Daftar <a href="{{ route('register') }}" class="text-info">disini</a></small>
                                </div>


                                <button type="submit" class="btn btn-outline-custom w-100">
                                    Login
                                </button>
                            </div>
                        </div>
                    </form>


        </div>
    </div>
</div>
@endsection
