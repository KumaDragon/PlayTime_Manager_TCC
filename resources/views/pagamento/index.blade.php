@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Finalizar Pagamento</h2>

    <p><strong>Cliente:</strong> {{ $consumo->cliente->name }}</p>
    <p><strong>Criança:</strong> {{ $consumo->crianca->name }}</p>
    <p><strong>Valor Total:</strong> R$ {{ number_format($consumo->valor_total, 2, ',', '.') }}</p>
    <p><strong>Tempo Total:</strong> {{ $consumo->totalTempo() }} minutos</p>

    <a href="{{ route('home') }}" class="btn btn-primary">Voltar</a>

    <form action="{{ route('consumo.finalizar', $consumo->id) }}" method="POST" id="form-finalizar">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="metodo_pagamento">Método de Pagamento:</label>
            <select name="metodo_pagamento" id="metodo_pagamento" class="form-control" style="width: 350px;" required>
                <option value="">Selecione o método de pagamento</option>
                <option value="debito">Débito</option>
                <option value="credito">Crédito</option>
                <option value="pix">Pix</option>
                <option value="dinheiro">Dinheiro</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success" style="margin-top: 10px; margin-bottom: 10px;">Finalizar</button>
        <button type="button" id="btn-finalizar-imprimir" class="btn btn-secondary" style="margin-top: 10px; margin-bottom: 10px;">Finalizar e Imprimir</button>
    </form>

</div>
@endsection

@section('js')
<script>
    document.getElementById('btn-finalizar-imprimir').addEventListener('click', function () {
        // Abre o recibo numa nova guia
        window.open("{{ route('recibo.pdf', ['id' => $consumo->id]) }}", "_blank");

        // Submete o formulário para finalizar o pagamento
        document.getElementById('form-finalizar').submit();

        // Redireciona para a home após o submit do formulário
        setTimeout(function () {
            window.location.href = "{{ route('home') }}";
        }, 1000); // Atraso de 1 segundo para garantir que o formulário foi enviado
    });
</script>
@endsection
