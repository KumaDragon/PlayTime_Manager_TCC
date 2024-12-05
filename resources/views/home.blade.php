@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Modal de Confirmação -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Cliente possui cadastro?</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="row justify-content-center">
    <div class="col-auto">
        <button type="button" class="btn btn-success w-15" data-bs-toggle="modal" data-bs-target="#abrirComanda">SIM</button>
    </div>
    <div class="col-auto">
        <a href="{{ route('clientes.create') }}" class="btn btn-danger w-15">NÃO</a>
    </div>
</div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Abrir Comanda -->
    <div class="modal fade" id="abrirComanda" tabindex="-1" aria-labelledby="abrirComandaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="abrirComandaLabel">Abrir Comandas</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('consumo.store') }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="cliente_id">Cliente</label>
                            <select name="cliente_id" id="cliente_id" class="form-control">
                                <option value="">Selecione um cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="crianca_id">Criança</label>
                            <select name="crianca_id" id="crianca_id" class="form-control">
                                <option value="">Selecione uma criança</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="servico_id">Serviço</label>
                            <select name="servico_id" id="servico_id" class="form-control">
                                @forelse($servicos as $servico)
                                    <option value="{{ $servico->id }}">{{ $servico->name }}</option>
                                @empty
                                    <option value="" disabled>Nenhum serviço disponível</option>
                                @endforelse
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success w-100">Gerar</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de Consumos -->
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body d-flex justify-content-start gap-2">
                    <a href="{{ route('servicos.index') }}" class="btn btn-primary">Serviços</a>
                    <a href="{{ route('clientes.index') }}" class="btn btn-primary">Clientes</a>
                    <a href="{{ route('relatorios.index') }}" class="btn btn-primary">Relatórios</a>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">+ Novo</button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Criança</th>
                                <th>Hora Final</th>
                                <th>Contador</th>
                                <th>Total</th>
                                <th>Ações</th>
                                <th>Comanda</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($consumos as $consumo)
    <tr>
        <td>{{ optional($consumo->cliente)->name }}</td>
        <td>{{ optional($consumo->crianca)->name }}</td>
        <td>{{ $consumo->created_at->addMinutes($consumo->totalTempo())->format('H:i:s') }}</td>
        <td><span id="countdown_{{ $consumo->id }}">Calculando...</span></td>
        <!-- Alteração feita aqui: exibindo o valor total da comanda -->
        <td>R$ {{ number_format($consumo->valor_total, 2, ',', '.') }}</td>
        <td>
            <form action="{{ route('consumo.servico', ['consumo' => $consumo->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <select name="servico_id" id="servico_id" class="form-control w-50" onchange="atualizarValores()">
                        <option value="">Escolha um serviço</option>
                        @foreach($servicos as $servico)
                            <option value="{{ $servico->id }}" data-tempo="{{ $servico->tempo }}" data-valor="{{ $servico->valor }}">
                                {{ $servico->name }} - {{ $servico->tempo }} min - R$ {{ number_format($servico->valor, 2, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    <form action="{{ route('consumo.store') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success"style="margin-top: 10px; margin-bottom: 10px;">Adicionar</button>
                    </form>
                </div>
        </td>
        <td>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#servicosModal{{ $consumo->id }}">
            Serviços
        </button>
        <form action="{{ route('consumo.finalizar', $consumo->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button class="btn btn-success"style="margin-top: 10px; margin-bottom: 10px;">Finalizar</button>
        </form>
        <form action="{{ route('consumo.destroy', $consumo->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta comanda?')">Excluir</button>
        <a href="{{ route('recibo.pdf', ['id' => $consumo->id]) }}" class="btn btn-primary" target="_blank">Resumo</a>  
    </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center">Nenhuma comanda encontrada.</td>
    </tr>
@endforelse
@if(session('success'))
    <div id="successMessage" class="alert alert-success position-fixed top-0 end-0 m-3" style="z-index: 1050;">
        {{ session('success') }}
    </div>
@endif
@foreach($consumos as $consumo)


        <!-- Modal -->
        <div class="modal fade" id="servicosModal{{ $consumo->id }}" tabindex="-1" aria-labelledby="servicosModalLabel{{ $consumo->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="servicosModalLabel{{ $consumo->id }}">Serviços do Consumo #{{ $consumo->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul>
                            @foreach($consumo->servicos as $servico)
                                <li><strong>{{ $servico->name }}</strong> - R$ {{ number_format($servico->valor, 2, ',', '.') }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Inicializar contadores
    @foreach($consumos as $consumo)
        updateCountdown(
            new Date("{{ $consumo->created_at->addMinutes($consumo->totalTempo())->toDateTimeString() }}"),
            "countdown_{{ $consumo->id }}",
            "{{ optional($consumo->cliente)->name }}",
            "{{ optional($consumo->crianca)->name }}"
        );
    @endforeach

    // Ocultar mensagem de sucesso após 5 segundos
    const successMessage = document.getElementById('successMessage');
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.display = 'none'; // Esconde a mensagem
        }, 5000);
    }
});



    function updateCountdown(endTime, elementId, clienteName, criancaName) {
        const interval = setInterval(() => {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance <= 0) {
                document.getElementById(elementId).textContent = "00:00:00";
                clearInterval(interval);
                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById(elementId).textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }, 1000);
    }

    $('#cliente_id').on('change', function () {
        const clienteId = $(this).val();
        if (clienteId) {
            $.ajax({
                url: `/clientes/${clienteId}/criancas`,
                type: 'GET',
                success: function (data) {
                    const $crianca = $('#crianca_id').empty().append('<option value="">Selecione uma criança</option>');
                    data.forEach(crianca => $crianca.append(`<option value="${crianca.id}">${crianca.name}</option>`));
                },
                error: function () {
                    alert('Erro ao carregar as crianças!');
                }
            });
        } else {
            $('#crianca_id').empty().append('<option value="">Selecione um cliente primeiro</option>');
        }
    });
</script>
@endsection
