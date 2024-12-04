<?php

namespace App\Http\Controllers;

use App\Models\Consumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsumoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consumos = Consumo::all();  // Pega todos os consumos do banco
        return view('consumo.index', compact('consumos'));  // Passa os consumos para a view
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $consumo = new Consumo();
        $consumo->user_id = Auth::id();
        $consumo->crianca_id = $request->input('crianca_id');
        $consumo->cliente_id = $request->input('cliente_id');
        $consumo->save();

        $consumo->servicos()->attach($request->servico_id);

        $consumo->valor_total = $consumo->servicos->sum('valor');
        $consumo->tempo_total = $consumo->totalTempo();
        $consumo->save();

        return redirect(url('home'));
    }

    public function show(Consumo $consumo)
    {
        // Passar os dados para a view
        return view('consumos.show', [
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
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'tempo' => 'required|numeric|min:1',
        'valor' => 'required|numeric|min:0',
    ]);
    } 

    public function destroy(Consumo $consumo)
    {
        $consumo->servicos()->detach();
        // Excluir o serviço se não estiver sendo utilizado
        $consumo->delete();
        //dd($consumo);
    
        // Redirecionar com uma mensagem de sucesso
        return redirect()->route('home')->with('success', 'Comanda excluída com sucesso!');
    }


    public function servico(Request $request, Consumo $consumo, $servico)
    {
        // Validação do serviço para garantir que ele seja válido
        if (!$servico || !is_numeric($servico) || !\App\Models\Servico::where('id', $servico)->exists()) {
            return redirect(url('home'))->withErrors('Serviço inválido.');
        }
    
        // Adicionar o serviço à comanda
        $consumo->servicos()->attach($servico);
    
        // Recalcular e salvar os totais
        $consumo->valor_total = $consumo->servicos->sum('valor');
        $consumo->tempo_total = $consumo->totalTempo();
        $consumo->save();
    
        return redirect(url('home'))->with('success', 'Serviço adicionado com sucesso!');
    }
    
    

}