@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Finalizar Pagamento</h2>

    <p><strong>Cliente:</strong> {{ $consumo->cliente->name }}</p>
    <p><strong>Criança:</strong> {{ $consumo->crianca->name }}</p>
    <p><strong>Valor Total:</strong> R$ {{ number_format($consumo->valor_total, 2, ',', '.') }}</p>
    <p><strong>Tempo Total:</strong> {{ $consumo->totalTempo() }} minutos</p>

    <a href="{{ route('home') }}" class="btn btn-primary">Voltar</a>

    <!-- Aqui você pode adicionar um formulário de pagamento ou um botão para confirmar -->
    <form action="{{ route('pagamento.confirmar', $consumo->id) }}" method="POST">
    @csrf
    <button class="btn btn-success">Confirmar Pagamento</button>
    </form>



</div>
@endsection
