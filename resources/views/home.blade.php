@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
            <div class="col-lg-10 col-md-10 col-sm-8">
            <div class="card mb-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Comandas</span>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#myModal">Nova Comanda</button>
                        <a href="{{ route('home') }}" class="btn btn-primary">Voltar</a>
                    </div>
                    </div>

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
        <button type="button" class="btn btn-success w-30" data-bs-toggle="modal" data-bs-target="#abrirComanda">SIM</button>
    </div>
    <div class="col-auto">
        <a href="{{ route('clientes.create') }}" class="btn btn-danger w-30">NÃO</a>
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
                            <label for="buscar_cliente">Buscar Cliente</label>
                            <input type="text" id="buscar_cliente" class="form-control" placeholder="Digite o nome do cliente" autocomplete="off">
                            <input type="hidden" name="cliente_id" id="cliente_id">
                            <div id="resultado_busca_cliente" class="list-group mt-2"></div>
                        </div>

                        <div class="form-group mb-3" id="criancas_container" style="display: none;">
                            <label>Crianças</label>
                            <div id="botoes_criancas"></div>
                            <input type="hidden" name="crianca_id" id="crianca_id">
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


                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th style="width: 15%;">Cliente</th>
                            <th style="width: 20%;">Criança</th>
                            <th style="width: 15%;">Hora Final</th>
                            <th style="width: 5%;">Contador</th>
                            <th style="width: 15%;">Total</th>
                            <th style="width: 20%;">Ações</th>
                            <th style="width: 10%;">Comanda</th>
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
                    <select name="servico_id" id="servico_id" class="form-control" onchange="atualizarValores()">
                        <option value="">Serviço</option>
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
            Detalhes
        </button>
     
        <form action="{{ route('consumo.pagamento', $consumo->id) }}" method="GET">
            <button class="btn btn-success" style="margin-top: 10px; margin-bottom: 10px;">Pagamento</button>
        </form>
        <form action="{{ route('consumo.destroy', $consumo->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta comanda?')">Excluir</button>
    </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center">Nenhuma comanda encontrada.</td>
    </tr>
@endforelse
@if(session('success'))
    <div id="successMessage" class="alert alert-success position-fixed top-0 end-0 m-3" style="z-index: 1050; animation: fadeOut 5s forwards;">
        {{ session('success') }}
    </div>
    {{ session()->forget('success') }}
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
});

    function updateCountdown(endTime, elementId, clienteName, criancaName) {
        const interval = setInterval(() => {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance <= 0) {
            document.getElementById(elementId).textContent = "00:00:00";
            clearInterval(interval); // Para o contador
            return; // Não faça mais nada
        }

        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Atualizar o contador na tela
        document.getElementById(elementId).textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

        // Verificar se o contador chegou a 30 segundos e mostrar a notificação
        if (seconds === 30 && !notified) {
            showNotification(`O tempo de ${clienteName} para a criança ${criancaName} está finalizando em 30 segundos!`);
            notified = true; // Garantir que a notificação seja exibida apenas uma vez
        }
    }, 1000);
}

function showNotification(message) {
    const notification = document.getElementById("notification");
    notification.textContent = message;
    notification.style.display = "block"; // Exibe a notificação

    setTimeout(() => {
        notification.style.display = "none"; // Esconde a notificação após 5 segundos
    }, 5000);
}


$(document).ready(function () {
    // Autocomplete de clientes
    $('#buscar_cliente').on('input', function () {
        const query = $(this).val();
        if (query.length > 2) {
            $.ajax({
                url: `/clientes/buscar`,
                type: 'GET',
                data: { q: query },
                success: function (data) {
                    const $resultado = $('#resultado_busca_cliente').empty();
                    data.forEach(cliente => {
                        $resultado.append(`
                        <a href="#" 
                            class="list-group-item list-group-item-action list-group-item-secondary" 
                            data-id="${cliente.id}" 
                            data-name="${cliente.name}">
                                ${cliente.name}
                            </a>
                        `);
                    });
                },
                error: function () {
                    alert('Erro ao buscar clientes!');
                }
            });
        } else {
            $('#resultado_busca_cliente').empty();
        }
    });

    // Selecionar cliente e buscar crianças
    $('#resultado_busca_cliente').on('click', '.list-group-item', function (e) {
        e.preventDefault();
        const clienteId = $(this).data('id');
        const clienteName = $(this).data('name');

        $('#buscar_cliente').val(clienteName);
        $('#cliente_id').val(clienteId);
        $('#resultado_busca_cliente').empty();

        // Buscar crianças
        $.ajax({
            url: `/clientes/${clienteId}/criancas`,
            success: function (data) {
    console.log(data);
    const $botoesCriancas = $('#botoes_criancas').empty();
    if (data.length > 0) {
        data.forEach(crianca => {
            $botoesCriancas.append(`
                    <div class="btn btn-primary me-2 crianca-botao" 
                         data-id="${crianca.id}">
                        ${crianca.name}
                    </div>
            `);
        });
        $('#criancas_container').show();
    } else {
        $('#criancas_container').hide();
        alert('Nenhuma criança cadastrada para este cliente.');
    }
},

            error: function () {
                alert('Erro ao carregar as crianças!');
            }
        });
    });

    // Selecionar criança
    $('#botoes_criancas').on('click', '.crianca-botao', function () {
        const criancaId = $(this).data('id');
        $('#crianca_id').val(criancaId);
        $('.crianca-botao').removeClass('btn-primary').addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary').addClass('btn-primary');
    });
});
</script>
@endsection
