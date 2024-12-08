@extends('layouts.app')

@section('content')

<div class="container">
    <!-- Modais -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cadastrar criança</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('criancas.store')}}" method="post">
                        @csrf
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="form-group mt-3">
                            <label for="">Nome</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group mt-3">
                            <label for="">Data de Nascimento</label>
                            <input type="date" name="nascimento" class="form-control">
                        </div>
                        <input type="hidden" name="cliente_id" value="{{$cliente->id}}">
                        <div class="form-group mt-3">
                            <button class="btn btn-success w-100">Cadastrar</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="novaComanda">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Abrir Comanda</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('consumo.store')}}" method="post">
                        @csrf
                        <div class="form-group mt-3">
                            <label for="">Criança</label>
                            <select name="crianca_id" class="form-control">
                                @forelse($cliente->criancas as $crianca)
                                <option value="{{$crianca->id}}">{{$crianca->name}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label for="">Tempo</label>
                            <select name="servico_id" class="form-control">
                                @forelse($servicos as $servico)
                                <option value="{{$servico->id}}">{{$servico->name}} -- R${{$servico->valor}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <input type="hidden" name="cliente_id" value="{{$cliente->id}}">
                        <div class="form-group mt-3">
                            <button class="btn btn-success w-100">Cadastrar</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Crianças de {{ getFirstAndSecondName($cliente->name) }}</span>
            </div>
                <div class="border-bottom pb-1">
                <div class="d-flex justify-content-end gap-2 my-2 me-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">+ Novo</button>
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#novaComanda">Abrir comanda</button>
                </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped m-0">
                        <thead>
                            <tr>
                                <th>Criança</th>
                                <th>Nascimento</th>
                                <th>Idade</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cliente->criancas as $crianca)
                            <tr>
                                <td>{{ $crianca->name }}</td>
                                <td>{{ $crianca->nascimento->format('d-m-Y') }}</td>
                                <td>{{ $crianca->nascimento->diffInYears() }} anos</td>
                                <td>
                                    <a href="{{ route('criancas.edit', ['cliente' => $cliente->id, 'crianca' => $crianca->id]) }}" class="btn btn-primary">Editar</a>
                                    <form action="{{ route('criancas.destroy', ['crianca' => $crianca->id]) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta criança?')">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">Este cliente não tem crianças cadastradas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'alert alert-success position-fixed top-0 end-0 m-3';
    notification.style.zIndex = 1050;
    notification.style.animation = 'fadeOut 5s forwards';
    notification.textContent = message;

    document.body.appendChild(notification);

    // Remove a notificação do DOM após 5 segundos
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

// Exemplo de uso
document.addEventListener('DOMContentLoaded', function () {
    const successMessage = "{{ session('success') }}";
    if (successMessage) {
        showNotification(successMessage);
    }
});
    </script>
@endsection
@php
    function getFirstAndSecondName($name) {
        $parts = explode(' ', $name);
        return isset($parts[1]) ? $parts[0] . ' ' . $parts[1] : $parts[0];
    }
@endphp