@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <h1>PlayTime Manager</h1>
                    <p class="lead">Seja bem-vindo, {{ Auth::user()->name }} !</p>


                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg w-100">Página Inicial</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
