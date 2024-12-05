<?php

namespace App\Http\Controllers;

use App\Models\Consumo;
use Barryvdh\DomPDF\PDF; // Importando diretamente a classe
use Illuminate\Http\Request;

class ReciboController extends Controller
{
    // Injetando a classe PDF no construtor
    protected $pdf;

    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;
    }

    public function gerarReciboPDF($id)
    {
        // Busca os dados do consumo junto com os serviços relacionados
        $consumo = Consumo::with('servicos')->find($id);

        // Verifica se o consumo foi encontrado
        if (!$consumo) {
            return abort(404, 'Comanda não encontrada');
        }

        // Renderiza a view com os dados do consumo
        return view('recibo', compact('consumo'));

        // Gera o PDF (se necessário futuramente)
        // $pdf = $this->pdf->loadView('recibo', compact('consumo'));
        // return $pdf->stream('recibo.pdf');
    }
}
