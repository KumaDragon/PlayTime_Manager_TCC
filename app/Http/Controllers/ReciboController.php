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
        // Busca os dados do consumo
        $consumo = Consumo::find($id);

        // Verifica se o consumo foi encontrado
        if (!$consumo) {
            return abort(404, 'Comanda não encontrada');
        }
        

        return view('recibo', compact('consumo'));
        // Gera o PDF usando a view
        //$pdf = $this->pdf->loadView('recibo', compact('consumo'));

        // Retorna o PDF para o download ou visualização
        //return $pdf->stream('recibo.pdf');
    }
}
