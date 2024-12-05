@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lista de Comandas</h2>

    <!-- Barra de busca -->
    <form action="{{ route('relatorios.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por cliente, criança ou ID" value="{{ request('search') }}">
            <input type="date" name="date" class="form-control" placeholder="Buscar por data" value="{{ request('date') }}">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>
    <a href="{{route('home')}}" class="btn btn-primary">Voltar</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Criança</th>
                <th>Valor Total</th>
                <th>Tempo Total</th>
                <th>Data</th> <!-- Coluna para exibir a data -->
            </tr>
        </thead>
        <tbody>
            @foreach($consumos as $consumo)
                <tr>
                    <td>{{ $consumo->id }}</td>
                    <td>{{ $consumo->cliente->name }}</td>
                    <td>{{ $consumo->crianca->name }}</td>
                    <td>R$ {{ number_format($consumo->servicos->sum('valor'), 2, ',', '.') }}</td>
                    <td>{{ $consumo->totalTempo() }} min</td>
                    <td>{{ $consumo->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
