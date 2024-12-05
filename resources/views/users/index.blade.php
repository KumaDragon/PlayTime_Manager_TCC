@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Gerenciamento de Usuários</span>
                <a href="{{ route('users.create') }}" class="btn btn-secondary mb-0">Novo Usuário</a> <!-- Remover div extra -->
            </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" 
                        onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                        Excluir
                        </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Nenhum usuário encontrado.</td>
                </tr>
            @endforelse

            @if(session('success'))
    <div id="successMessage" class="alert alert-success position-fixed top-0 end-0 m-3" style="z-index: 1050; animation: fadeOut 5s forwards;">
        {{ session('success') }}
    </div>
    {{ session()->forget('success') }}
@endif

        </tbody>
    </table>
</div>
@endsection
