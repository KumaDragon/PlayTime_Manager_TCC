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
        
        // Alterando a query para buscar apenas consumos com status 'pendente'
        $consumos = Consumo::with('cliente', 'crianca')
                            ->where('status', 'pendente') // Filtra os consumos pendentes
                            ->get();
    
        return view('home', compact('consumos', 'servicos', 'clientes', 'criancas'));
    }
    
}
