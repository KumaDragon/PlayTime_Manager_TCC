<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Consumo;
use App\Models\Crianca;
use App\Models\Servico;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $clientes = Cliente::with('criancas')->get();
        $criancas = Crianca::all();
        $servicos = Servico::all();
        $consumos = Consumo::with('cliente', 'crianca')->get(); // Carregando cliente e crianca
        return view('home', compact('consumos', 'servicos', 'clientes', 'criancas'));
    }
}
