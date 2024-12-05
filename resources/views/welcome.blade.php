@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <h1>PlayTime Manager</h1>
                    <p class="lead">Aqui você pode gerenciar clientes, serviços e relatórios de consumo de brinquedos infantis.</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-lg">Gerenciar Clientes</a>
                        <a href="{{ route('servicos.index') }}" class="btn btn-primary btn-lg">Gerenciar Serviços</a>
                        <a href="{{ route('relatorios.index') }}" class="btn btn-primary btn-lg">Relatórios</a>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="btn btn-warning btn-lg w-100">Página Inicial</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
