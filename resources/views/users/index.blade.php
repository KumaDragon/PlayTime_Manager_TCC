@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Gerenciamento de Usuários</h1>
    <a href="{{ route('users.create') }}" class="btn btn-secondary mb-3">Novo Usuário</a>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

    <table class="table table-bordered">
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
        </tbody>
    </table>
</div>
@endsection
