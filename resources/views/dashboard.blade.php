@extends('layouts.dash')


@section('side')
@endsection
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>Selamat Datang, {{ Auth::user()->name }}</p>
                </div>
            </div>
        </div>
    </div>

      @endsection
