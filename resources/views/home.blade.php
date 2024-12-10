@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-10 col-md-10 col-sm-8">
        <div class="card border-gray">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Comandas</span>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#myModal">Nova Comanda</button>
                </div>
            </div>
        </div>
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
                    <div class="modal-footer"></div>
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
        <div class="card-body-service">
            <table class="table table-striped border-gray">
                <thead>
                    <tr>
                        <th style="width: 20%;">Cliente</th>
                        <th style="width: 20%;">Criança</th>
                        <th style="width: 10%;">Hora Final</th>
                        <th style="width: 10%;">Contador</th>
                        <th style="width: 10%;">Total</th>
                        <th style="width: 15%;">Ações</th>
                        <th style="width: 15%;">Comanda</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consumos as $consumo)
                        <tr>
                            <td>{{ optional($consumo->cliente)->name }}</td>
                            <td>{{ optional($consumo->crianca)->name }}</td>
                            <td>{{ $consumo->created_at->addMinutes($consumo->totalTempo())->format('H:i:s') }}</td>
                            <td><span id="countdown_{{ $consumo->id }}">Calculando...</span></td>
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
                                        <button type="submit" class="btn btn-success w-100 mt-3">Adicionar</button>
                                    </div>
                                </form>
                            </td>
                            <td>
                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#servicosModal{{ $consumo->id }}">
    Detalhes
</button>

                                <form action="{{ route('consumo.pagamento', $consumo->id) }}" method="GET" class="d-grid gap-2 mt-2">
                                    <button class="btn btn-success w-100">Pagamento</button>
                                </form>

                                <form action="{{ route('consumo.destroy', $consumo->id) }}" method="POST" class="d-grid gap-2 mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Tem certeza que deseja excluir esta comanda?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Nenhuma comanda encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@foreach($consumos as $consumo)
    <!-- Modal de Serviços -->
    <div class="modal fade" id="servicosModal{{ $consumo->id }}" tabindex="-1" aria-labelledby="servicosModalLabel{{ $consumo->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="servicosModalLabel{{ $consumo->id }}">Serviços da Comanda #{{ $consumo->id }}</h5>
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
@endforeach
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
            "{{ optional($consumo->crianca)->name }}",
            {{ $consumo->id }}
        );
    @endforeach

    // Adicionar event listeners para os botões de "Detalhes"
    const buttons = document.querySelectorAll('[data-bs-toggle="modal"]');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const consumoId = this.getAttribute('data-bs-target').replace('#servicosModal', '');
            console.log('Abrindo modal para o consumo', consumoId);
            // Você pode adicionar código aqui para customizar o comportamento do modal, se necessário.
        });
    });
});


function updateCountdown(endTime, elementId, clienteName, criancaName, consumoId) {
    let notified1Min = false;  // Variável para notificação de 1 minuto
    let notifiedEnd = false;   // Variável para notificação de fim de tempo

    const interval = setInterval(() => {
        const now = new Date().getTime();
        const distance = endTime - now;

        if (distance <= 0) {
            document.getElementById(elementId).textContent = "00:00:00";
            clearInterval(interval); // Para o contador

            if (!notifiedEnd) {
                sendNotification(consumoId, `ATENÇÃO: O tempo da comanda de ${clienteName} e ${criancaName} acabou!`, 'danger');
                notifiedEnd = true; // Evita múltiplas notificações de fim
            }

            return; // Não faça mais nada
        }

        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Atualizar o contador na tela
        document.getElementById(elementId).textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }); // Atualiza a cada segundo
}

function sendNotification(consumoId, message, type) {
    // Cria a notificação
    const notification = document.createElement('div');
    notification.id = 'notification';
    
    // Adiciona a classe de estilo de acordo com o tipo
    notification.classList.add(type); // 'danger', 'warning', etc.
    
    // Cria o botão de fechar
    const closeButton = document.createElement('button');
    closeButton.textContent = '×';
    closeButton.onclick = function() {
        notification.style.display = 'none'; // Fecha a notificação
    };
    
    // Adiciona a mensagem e o botão de fechar
    notification.innerHTML = `${message}`;
    notification.appendChild(closeButton);
    
    // Adiciona a notificação ao corpo da página
    document.body.appendChild(notification);
    
    // Exibe a notificação
    notification.style.display = 'flex'; // Mostra a notificação
}


//function sendNotification(consumoId, message, type) {
    // Função para enviar a notificação, pode ser adaptada para seu backend ou frontend
   // alert(`${message}`); // Exemplo usando alert
    // Você pode substituir a função alert por algo mais sofisticado, como um sistema de notificação no frontend.
//}

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
    const primeiroNome = crianca.name.split(' ')[0]; // Pega apenas o primeiro nome
    $botoesCriancas.append(`
        <div class="btn btn-primary me-2 crianca-botao" 
             data-id="${crianca.id}">
            ${primeiroNome}
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
        $('.crianca-botao')
        .removeClass('btn-secondary') // Remove a classe de destaque dos outros botões
        .addClass('btn-primary'); // Restaura a classe padrão
    
    $(this)
        .removeClass('btn-primary')
        .addClass('btn-secondary');
});
});
</script>
@endsection

