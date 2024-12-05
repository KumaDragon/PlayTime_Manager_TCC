@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Relatórios</span>
                    <a href="{{route('home')}}" class="btn btn-primary">Voltar</a>

                    </div>
<!-- Barra de busca -->
<form action="{{ route('relatorios.index') }}" method="GET" class="d-flex mb-4" style="width: 100%; align-items: center; justify-content: center; margin-top: 20px; padding: 0 20px;">
    <input type="text" name="search" class="form-control" placeholder="Buscar por cliente, criança ou ID" value="{{ request('search') }}" style="flex-grow: 1; max-width: 450px; margin: 0; border-radius: 25px 0 0 25px; height: 38px;">
    <input type="date" name="date" class="form-control" placeholder="Buscar por data" value="{{ request('date') }}" style="flex-grow: 1; width: 200px; margin: 0; border-radius: 0; height: 38px;">
    <button class="btn btn-primary" type="submit" style="margin: 0; border-radius: 0 0px 0px 0; flex-grow: 1; height: 38px; padding: 6px 12px;">Buscar</button>
    <a href="{{ route('relatorios.index') }}" class="btn btn-secondary" style="margin: 0; border-radius: 0 25px 25px 0; flex-grow: 1; height: 38px; padding: 6px 12px;">Limpar Filtro</a>
</form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Criança</th>
                <th>Valor Total</th>
                <th>Forma de Pagamento</th>
                <th>Tempo Total</th>
                <th>Data</th> <!-- Coluna para exibir a data -->
                <th>Recibo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consumos as $consumo)
                <tr>
                    <td>{{ $consumo->id }}</td>
                    <td>{{ $consumo->cliente->name }}</td>
                    <td>{{ $consumo->crianca->name }}</td>
                    <td>R$ {{ number_format($consumo->servicos->sum('valor'), 2, ',', '.') }}</td>
                    <td>{{ $consumo->metodo_pagamento_formatado}}</td>
                    <td>{{ $consumo->totalTempo() }} min</td>
                    <td>{{ $consumo->created_at->format('d/m/Y') }}</td>
                    <td><a href="{{ route('recibo.pdf', ['id' => $consumo->id]) }}" class="btn btn-primary" target="_blank">Imprimir</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
