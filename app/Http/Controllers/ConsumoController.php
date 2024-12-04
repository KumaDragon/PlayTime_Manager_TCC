<?php

namespace App\Http\Controllers;

use App\Models\Consumo;
use App\Models\Crianca;
use App\Models\Cliente;
use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsumoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Validação dos dados recebidos via requisição
        $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
        'crianca_id' => 'required|exists:criancas,id',
        'servico_id' => 'required|array|min:1',
        'servico_id.*' => 'exists:servicos,id',
        ]);

        $consumos = Consumo::with('servicos')->get();  // Carrega os consumos com seus serviços
        $clientes = Cliente::all();  // Pega todos os clientes do banco
        return view('home', compact('consumos', 'clientes'));  // Passa consumos e clientes para a view
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create($cliente_id)
    {
        $cliente = Cliente::with('criancas')->find($cliente_id);  // Obtém o cliente com suas crianças
        return view('consumo.create', compact('cliente'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $clienteId = $request->input('cliente_id');
        $criancaId = $request->input('crianca_id');

        // Verificar se a criança pertence ao cliente selecionado
        $crianca = Crianca::where('id', $criancaId)->where('cliente_id', $clienteId)->first();

        if (!$crianca) {
            return redirect()->back()->withErrors('A criança selecionada não pertence ao cliente escolhido.');
        }

        $consumo = new Consumo();
        $consumo->user_id = Auth::id();
        $consumo->crianca_id = $criancaId;
        $consumo->cliente_id = $clienteId;
        $consumo->status = 'pendente'; // Define o status inicial
        $consumo->save();

        $consumo->servicos()->attach($request->servico_id);

        $consumo->valor_total = $consumo->servicos->sum('valor');
        $consumo->tempo_total = $consumo->totalTempo();
        $consumo->save();

        return redirect(url('home'));
    }

    public function finalizar($id)
    {
        $consumo = Consumo::find($id);
    
        if ($consumo) {
            $consumo->status = 'finalizado';  // Atualiza o status
            $consumo->save();
    
            return redirect()->route('consumo.index')->with('success', 'Comanda finalizada com sucesso!');
            dd('Redirecionando para relatórios...');
        }
    
        return redirect()->route('home')->with('error', 'Comanda não encontrada.');
    }
    
    

    public function show(Consumo $consumo)
    {
        // Passar os dados para a view
        return view('home', [
            'consumo' => $consumo,
            'servicos' => $consumo->servicos,
            'valor_total' => $consumo->servicos->sum('valor'),
            'tempo_total' => $consumo->totalTempo(),
        ]);
    }

    public function edit(Consumo $consumo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Consumo $consumo)
    {

    } 

    public function destroy(Consumo $consumo)
    {

        if (!$consumo) {
            return redirect()->route('consumo.index')->withErrors('Consumo não encontrado.');
        }

        $consumo->servicos()->detach();
        // Excluir o serviço se não estiver sendo utilizado
        $consumo->delete();
        //dd($consumo);
    
        // Redirecionar com uma mensagem de sucesso
        return redirect()->route('home')->with('success', 'Comanda excluída com sucesso!');
    }


    public function servico(Request $request, Consumo $consumo)
    {
        // Recupera o serviço selecionado
        $servicoId = $request->input('servico_id');
        $servico = \App\Models\Servico::find($servicoId);
    
        // Verifica se o serviço é válido
        if (!$servico) {
            return redirect()->route('home')->withErrors('Serviço inválido.');
        }
    
        // Adiciona o serviço à comanda
        $consumo->servicos()->attach($servicoId);
        $consumo->tempo_total += $servico->tempo;
        $consumo->valor_total += $servico->valor;
        $consumo->save();
    
        // Retorna à página inicial com sucesso
        return redirect()->route('home')->with('consumo', $consumo)->with('success', 'Serviço adicionado com sucesso!');
    }
    
}