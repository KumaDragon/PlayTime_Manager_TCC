<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Servico;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $telefone = preg_replace('/\D/', '', $request->input('telefone'));
        $request->merge(['telefone' => $telefone]);

        $request->validate([
            'name' => 'required|string|max:255',
            'telefone' => 'required|string|size:11',
        ]);

        $cliente = Cliente::create([
            'name' => $request->input('name'),
            'telefone' => $telefone,
        ]);

        return redirect()->route('clientes.crianca', ['cliente' => $cliente]);
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $telefone = preg_replace('/\D/', '', $request->input('telefone'));
        $request->merge(['telefone' => $telefone]);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'telefone' => 'required|string|size:11',
        ]);
    
        $cliente->update($request->only('name', 'telefone'));
    
        // Redireciona para a página de detalhes do cliente após atualização
        return redirect()->route('clientes.crianca', $cliente->id)->with('success', 'Cliente atualizado com sucesso!');
    }
    
    

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);

        if ($cliente->consumos()->exists()) {
            return redirect()->route('clientes.index')->with('error', 'Este cliente não pode ser excluído porque está sendo usado em uma comanda.');
        }

        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente excluído com sucesso!');
    }

    public function showCriancas()
    {
        $criancas = \App\Models\Crianca::with('cliente')->get();
        return view('clientes.show', compact('criancas'));
    }

    public function crianca(Cliente $cliente)
    {
        $servicos = Servico::all();
        return view('clientes.show', compact('cliente', 'servicos'));
    }

    public function buscar(Request $request)
    {
        $query = $request->input('q');
        return Cliente::where('name', 'like', "%$query%")->get(['id', 'name']);
    }

    public function getCriancas($id)
    {
        try {
            $criancas = Cliente::findOrFail($id)->criancas; // Supondo relação hasMany
            return response()->json($criancas);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar crianças'], 500);
        }
    }
    

    public function buscarCriancas($clienteId)
    {
        $criancas = Crianca::where('cliente_id', $clienteId)->get();
        return response()->json($criancas);
    }

}
