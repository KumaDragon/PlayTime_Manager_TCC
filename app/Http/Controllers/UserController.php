<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all(); // Obtém todos os usuários
        return view('users.index', compact('users')); // Envia para a view
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'cpf' => ['required', 'string', 'cpf'],  // Usando o validador cpf que você registrou no AppServiceProvider
            'telefone' => 'required|string|max:15', // Validação de telefone
            'password' => 'required|string|min:8|confirmed', // Confirmação de senha
        ]);
    
        // Criação do usuário
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
            'password' => Hash::make($request->password),
        ]);
    
        // Redireciona após a criação
        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id); // Recupera o usuário pelo ID
        return view('users.edit', compact('user')); // Retorna a view de edição
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id, // Garantir que o email não será duplicado
            'cpf' => 'required|cpf',
            'telefone' => 'required|string|max:15',
        ]);
    
        $user = User::findOrFail($id);  // Encontra o usuário
    
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
        ]);
    
        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Encontrar o usuário pelo ID
        $user = User::findOrFail($id);
    
        // Excluir o usuário
        $user->delete();
    
        // Redirecionar para a lista de usuários com uma mensagem de sucesso
        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }
    
}
