<?php

namespace App\Http\Controllers;

use App\Models\Crianca;
use App\Models\Cliente;
use Illuminate\Http\Request;

class CriancaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nascimento' => 'required|date|before_or_equal:today', // Validação para data válida e não no futuro
            'cliente_id' => 'required|exists:clientes,id',
        ]);
        
        $crianca = new Crianca();
        $crianca->name = $request->input('name');
        $crianca->cliente_id= $request->input('cliente_id');
        $crianca->nascimento= $request->input('nascimento');
        $crianca->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Crianca $crianca)
    {
        //
    }
    public function edit($clienteId, $criancaId)
    {
        // Buscar o cliente e a criança
        $cliente = Cliente::findOrFail($clienteId);
        $crianca = $cliente->criancas()->findOrFail($criancaId);
    
        // Retornar a view de edição com os dados da criança
        return view('clientes.crianca.edit', compact('cliente', 'crianca'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $clienteId, $criancaId)
    {
        // Validar os dados
        $request->validate([
            'name' => 'required|string|max:255',
            'nascimento' => 'required|date',
        ]);
    
        // Encontrar o cliente e a criança
        $cliente = Cliente::findOrFail($clienteId);
        $crianca = $cliente->criancas()->findOrFail($criancaId);
    
        // Atualizar a criança
        $crianca->update($request->only('name', 'nascimento'));
    
        // Redirecionar para a página de índice de clientes
        return redirect()->route('clientes.index')->with('success', 'Criança atualizada com sucesso!');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Crianca $crianca)
    {
        $crianca->delete();
    
        return redirect()->route('clientes.index')->with('success', 'Criança excluída com sucesso!');
    }
    
}
