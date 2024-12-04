@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Comanda: {{ $consumo->id }}</h2>
    <p><strong>Cliente:</strong> {{ $consumo->cliente->nome }}</p>
    <p><strong>Criança:</strong> {{ $consumo->crianca->nome }}</p>

    <h3>Serviços</h3>
    <ul>
        @foreach($servicos as $servico)
            <li>{{ $servico->name }} - R$ {{ number_format($servico->valor, 2, ',', '.') }} ({{ $servico->tempo }} min)</li>
        @endforeach
    </ul>

    <h4><strong>Valor Total:</strong> R$ {{ number_format($valor_total, 2, ',', '.') }}</h4>
    <h4><strong>Tempo Total:</strong> {{ $tempo_total }} minutos</h4>
</div>
@endsection
