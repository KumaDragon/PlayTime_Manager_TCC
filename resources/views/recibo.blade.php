<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo - Comanda</title>
    <style>
        body {
            font-family: "Courier New", Courier, monospace;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
            padding: 10px;
            text-align: left;
        }

        .header, .footer {
            text-align: center;
            font-weight: bold;
        }

        .divider {
            margin: 10px 0;
            border: none;
            border-top: 1px dashed #000;
        }

        .info, .total {
            margin-bottom: 5px;
        }

        .info span {
            display: inline-block;
            width: 100px;
        }

        .total {
            margin-top: 15px;
            font-size: 14px;
            font-weight: bold;
        }

        .servicos {
            margin-top: 10px;
        }

        .servico-item {
            display: flex;
            justify-content: space-between;
        }

        .footer {
            margin-top: 20px;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">================ RECIBO ================ </div>

        <br>

        <div class="info">
            <span>Cliente:</span> {{ optional($consumo->cliente)->name }}
        </div>
        <div class="info">
            <span>Criança:</span> {{ optional($consumo->crianca)->name }}
        </div>

        <div class="divider"></div>

        <div class="info">
            <span>Atendente:</span> {{ Auth::user()->name }}
        </div>

        <div class="divider"></div>

        @if($consumo->servicos->isNotEmpty())
            <div class="servicos">
                <span><strong>Serviços:</strong></span>
                @foreach ($consumo->servicos as $servico)
                    <div class="servico-item">
                        <span>{{ $servico->name }}</span> 
                        <span>R$ {{ number_format($servico->valor, 2, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <p>Não há serviços associados a esta comanda.</p>
        @endif

        <div class="divider"></div>

        <div class="info">
            <span>Hora Inicial:</span> {{ $consumo->created_at->format('d/m/Y H:i') }}
        </div>
        <div class="info">
            <span>Hora Final:</span> {{ $consumo->created_at->addMinutes($consumo->totalTempo())->format('d/m/Y H:i') }}
        </div>

        <div class="divider"></div>

        <div class="total">
            <span>Total:</span> R$ {{ number_format($consumo->valor_total, 2, ',', '.') }}
        </div>

        <div class="footer">

        <div class="divider"></div>

        <p style="margin-top: 10px; font-size: 10px; font-weight: bold; text-transform: uppercase; ">Este documento não é um cupom fiscal</p>

        <div class="divider"></div>
            Obrigado pela preferência!<br>
            PlayTime Manager v1.0<br>
            {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>
</body>
</html>
