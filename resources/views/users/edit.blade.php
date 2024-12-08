@extends('layouts.app')

@section('content')

<!-- Tabela -->
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Editar Usuário</span>

                <a href="{{route('users.index')}}" class="btn btn-primary">Voltar</a>
            </div>

            <div class="card-body">
                <form id="userForm" action="{{route('users.update', $user)}}" method="post">
                    @csrf
                    @method("PUT")
                    <input type="hidden" id="userId" name="id"> 

                    <div class="form-group mt-3">
                        <label for="name">Nome</label>
                        <input type="text" id="name" name="name" value="{{$user->name}}" class="form-control" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{$user->email}}" class="form-control" required>
                    </div>

                    <div class="form-group mt-3">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="cpf" value="{{ old('cpf', $user->cpf) }}" class="form-control" required>
                    @error('cpf')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="telefone">Telefone</label>
                        <input type="text" id="telefone" name="telefone" value="{{$user->telefone}}" class="form-control" required>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-success w-100">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
