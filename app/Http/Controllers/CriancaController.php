<?php

namespace App\Http\Controllers;

use App\Models\Crianca;
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Crianca $crianca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Crianca $crianca)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Crianca $crianca)
    {
        //
    }
}
