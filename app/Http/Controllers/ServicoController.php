<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;

class ServicoController extends Controller
{

    public function index()
    {
        $servicos = Servico::all();
        return view('servico.index', compact('servicos'));
    }

    public function create()
    {
        return view('servico.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'tempo' => 'required|numeric|min:1',
            'valor' => 'required|numeric|min:0',
        ]);
        
        $servico = new Servico();
        $servico->name = $request->input('name');
        $servico->tempo = $request->input('tempo');
        $servico->valor = $request->input('valor');
        $servico->save();

        return redirect()->route('servicos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Servico $servico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Servico $servico)
    {
        return view("servico.edit", compact("servico"));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Servico $servico)
    {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'tempo' => 'required|numeric|min:1',
        'valor' => 'required|numeric|min:0',
    ]);


    $servico->update($validated);

    return redirect()->route('servicos.index')->with('success', 'Serviço atualizado com sucesso!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Buscar o serviço pelo ID
        $servico = Servico::findOrFail($id);
    
        // Verificar se o serviço está sendo utilizado em uma comanda (na tabela consumo_servico)
        $isUsed = $servico->consumos()->exists();  // Verifica se há registros relacionados
    
        if ($isUsed) {
            // Se o serviço está sendo utilizado, redireciona com uma mensagem de erro
            return redirect()->route('servicos.index')->with('error', 'Este serviço não pode ser excluído porque está sendo usado em uma comanda.');
        }
    
        // Excluir o serviço se não estiver sendo utilizado
        $servico->delete();
    
        // Redirecionar com uma mensagem de sucesso
        return redirect()->route('servicos.index')->with('success', 'Serviço excluído com sucesso!');
    }
    
    
}
