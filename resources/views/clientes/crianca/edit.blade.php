@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Editar Criança
                </div>

                <div class="card-body">
                    <form action="{{ route('criancas.update', ['cliente' => $cliente->id, 'crianca' => $crianca->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Campo Nome -->
                        <div class="form-group mt-3">
                            <label for="name">Nome</label>
                            <input type="text" name="name" class="form-control" value="{{ $crianca->name }}" required>
                        </div>

                        <!-- Campo Data de Nascimento -->
                        <div class="form-group mt-3">
                            <label for="nascimento">Data de Nascimento</label>
                            <input type="date" name="nascimento" class="form-control" value="{{ $crianca->nascimento->format('Y-m-d') }}" required>
                        </div>

                        <!-- Botão para Salvar -->
                        <button type="submit" class="btn btn-success w-100 mt-3">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
