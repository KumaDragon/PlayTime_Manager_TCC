<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumo - Comanda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
            padding: 10px;
            text-align: center;
        }

        .header {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .info {
            margin-bottom: 5px;
        }

        .info span {
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            font-size: 10px;
            color: #777;
        }

        .total {
            margin-top: 15px;
            font-size: 16px;
            font-weight: bold;
            color: #000;
        }

        .divider {
            margin: 10px 0;
            border-top: 1px solid #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Recibo - Comanda</div>

        <div class="info">
            <span>Cliente:</span> {{ optional($consumo->cliente)->name }}
        </div>
        <div class="info">
            <span>Criança:</span> {{ optional($consumo->crianca)->name }}
        </div>
        <div class="info">
            <span>Serviço:</span> {{ optional($consumo->servico)->name }}
        </div>
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
            <p>PlayTime Manager v1.0</p>
            <p>Obrigado pela preferência!</p>
            <p>{{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
