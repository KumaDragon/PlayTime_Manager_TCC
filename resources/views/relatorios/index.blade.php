@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lista de Comandas</h2>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Criança</th>
                <th>Valor Total</th>
                <th>Tempo Total</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consumos as $consumo)
                <tr>
                    <td>{{ $consumo->id }}</td>
                    <td>{{ $consumo->cliente->nome }}</td>
                    <td>{{ $consumo->crianca->nome }}</td>
                    <td>R$ {{ number_format($consumo->servicos->sum('valor'), 2, ',', '.') }}</td>
                    <td>{{ $consumo->totalTempo() }} min</td>
                    <td>
                        <a href="{{ route('consumo.show', $consumo->id) }}" class="btn btn-primary">Ver Detalhes</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
