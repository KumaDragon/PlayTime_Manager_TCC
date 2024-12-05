<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Servico;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function showCriancas()
    {
        // Obter todas as crianças e seus clientes associados
        $criancas = \App\Models\Crianca::with('cliente')->get();

        // Retornar a view com as crianças e seus clientes
        return view('clientes.show', compact('criancas'));
    }

    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Remover formatação do telefone para validação
        $telefone = preg_replace('/\D/', '', $request->input('telefone')); // Remove caracteres não numéricos

        // Validação dos campos
        $request->merge(['telefone' => $telefone]); // Substituir o telefone formatado pelo limpo para validação
        $request->validate([
            'name' => 'required|string|max:255', // Nome é obrigatório, string e até 255 caracteres
            'telefone' => 'required|string|size:11', // Telefone é obrigatório, string e exatamente 11 caracteres
        ]);

        $cliente = new Cliente();
        $cliente->name = $request->input('name');
        $cliente->telefone = $telefone; // Salva o telefone sem formatação
        $cliente->save();

        return redirect()->route('clientes.crianca', ['cliente' => $cliente]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view("clientes.edit", compact("cliente"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        // Remover formatação do telefone para validação
        $telefone = preg_replace('/\D/', '', $request->input('telefone')); // Remove caracteres não numéricos

        // Validação dos campos
        $request->merge(['telefone' => $telefone]); // Substituir o telefone formatado pelo limpo para validação
        $request->validate([
            'name' => 'required|string|max:255', // Nome é obrigatório, string e até 255 caracteres
            'telefone' => 'required|string|size:11', // Telefone é obrigatório, string e exatamente 11 caracteres
        ]);

        $cliente->update([
            'name' => $request->input('name'),
            'telefone' => $telefone,
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy($id)
    {
        // Buscar o serviço pelo ID
        $cliente = Cliente::findOrFail($id);

        // Verificar se o cliente está sendo utilizado em uma comanda (na tabela consumo_servico)
        $isUsed = $cliente->consumos()->exists(); // Verifica se há registros relacionados

        if ($isUsed) {
            // Se o cliente está sendo utilizado, redireciona com uma mensagem de erro
            return redirect()->route('clientes.index')->with('error', 'Este cliente não pode ser excluído porque está sendo usado em uma comanda.');
        }

        // Excluir o serviço se não estiver sendo utilizado
        $cliente->delete();

        // Redirecionar com uma mensagem de sucesso
        return redirect()->route('clientes.index')->with('success', 'Cliente excluído com sucesso!');
    }

    public function crianca(Cliente $cliente)
    {
        $servicos = Servico::all();
        return view('clientes.show', compact('cliente', 'servicos'));
    }

    public function getCriancas(Cliente $cliente)
    {
        // Carregar as crianças associadas ao cliente
        $criancas = $cliente->criancas;

        // Retornar os dados como JSON
        return response()->json($criancas);
    }
}
