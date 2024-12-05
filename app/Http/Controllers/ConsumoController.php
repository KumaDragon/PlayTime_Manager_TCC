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
        // Cria uma query para buscar os consumos com status 'finalizado'
        $query = Consumo::with(['servicos', 'cliente', 'crianca'])
                        ->where('status', 'finalizado'); // Filtra por status 'finalizado'
    
        // Verifica se há um termo de busca
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($query) use ($search) {
                $query->whereHas('cliente', function($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('crianca', function($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->orWhere('id', 'like', "%{$search}%");
            });
        }
    
        // Verifica se há uma data
        if ($request->has('date') && $request->date) {
            $query->whereDate('created_at', $request->date);
        }

        // Recupera os consumos filtrados
        $consumos = $query->get();
    
        $clientes = Cliente::all(); // Mantém os clientes para a view
    
        // Retorna a view com os dados filtrados
        return view('relatorios.index', compact('consumos', 'clientes'));
    }
    
    public function relatorios(Request $request)
    {
        $query = Consumo::with(['cliente', 'crianca', 'servicos'])->where('status', 'finalizado');
    
        // Filtro por busca textual
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('cliente', function ($qCliente) use ($search) {
                    $qCliente->where('name', 'like', '%' . $search . '%');
                })->orWhereHas('crianca', function ($qCrianca) use ($search) {
                    $qCrianca->where('name', 'like', '%' . $search . '%');
                })->orWhere('id', 'like', '%' . $search . '%');
            });
        }
    
        // Filtro por data
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }
    
        // Paginação e ordenação
        $consumos = $query->orderBy('created_at', 'desc')->paginate(10);
    
        return view('relatorios.index', compact('consumos'));
    }
    
    
    


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

    public function finalizar($id, Request $request)
    {
        $consumo = Consumo::find($id);
    
        if ($consumo) {
            $metodoPagamento = $request->input('metodo_pagamento');
    
            // Validação do método de pagamento
            if (!in_array($metodoPagamento, ['debito', 'credito', 'pix', 'dinheiro'])) {
                return redirect()->back()->withErrors('Método de pagamento inválido.');
            }
    
            // Atualiza os dados no banco
            $consumo->status = 'finalizado';
            $consumo->metodo_pagamento = $metodoPagamento;
            $consumo->save();
    
            // Redireciona para a home por padrão
            return redirect()->route('home')->with('success', 'Comanda finalizada com sucesso!');
        }
    
        // Caso a comanda não exista
        return redirect()->route('home')->with('error', 'Comanda não encontrada.');
    }
    
    
    public function up()
{
    Schema::table('consumos', function (Blueprint $table) {
        $table->string('metodo_pagamento')->nullable();
    });
}


public function pagamento(Consumo $consumo)
{
    // Permite o acesso à tela de pagamento independentemente do status
    return view('pagamento.index', compact('consumo'));
}

    public function show(Consumo $consumo)
    {
        // Verifica se o consumo está finalizado
        if ($consumo->status !== 'finalizado') {
            return redirect()->route('home')->with('error', 'Comanda não finalizada.');
        }

        // Exibe a view de pagamento com os detalhes do consumo
        return view('pagamento.index', compact('consumo'));
    }

    // Confirma o pagamento e altera o status da comanda
    public function confirmarPagamento(Consumo $consumo)
    {
        // Verifica se o consumo está finalizado
        if ($consumo->status !== 'finalizado') {
            return redirect()->route('home')->with('error', 'Comanda não finalizada.');
        }
    
        // Atualiza o status da comanda para 'pago'
        $consumo->status = 'pago';
        $consumo->save();
    
        // Redireciona para os relatórios após o pagamento
        return redirect()->route('relatorios.index')->with('success', 'Pagamento confirmado!');
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