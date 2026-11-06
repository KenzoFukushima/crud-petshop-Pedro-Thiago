<?php

namespace App\Http\Controllers;

use App\Models\Dono;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function index()
    {
        $user = User::find(session('user.id'));
        $dono = Dono::findOrFail($user->id_dono);

        return view('dono.perfil', ['dono' => $dono]);
    }

    public function update(Request $request)
    {
        $user = User::find(session('user.id'));
        $dono = Dono::findOrFail($user->id_dono);

        $request->validate([
            'nome' => 'required|min:2|max:100',
            'telefone' => 'required|max:20',
            'endereco' => 'nullable|max:255',
            'senha_atual' => 'nullable|required_with:nova_senha',
            'nova_senha' => 'nullable|min:8|confirmed',
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'nome.min' => 'O nome deve ter pelo menos :min caracteres.',
            'nome.max' => 'O nome deve ter no máximo :max caracteres.',
            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.max' => 'O telefone deve ter no máximo :max caracteres.',
            'endereco.max' => 'O endereço deve ter no máximo :max caracteres.',
            'senha_atual.required_with' => 'Informe a senha atual para trocar a senha.',
            'nova_senha.min' => 'A nova senha deve ter pelo menos :min caracteres.',
            'nova_senha.confirmed' => 'A confirmação não é igual à nova senha.',
        ]);

        if ($request->filled('nova_senha')) {

            if (!Hash::check($request->senha_atual, $user->password)) {
                return back()
                    ->withErrors(['senha_atual' => 'A senha atual está incorreta.'])
                    ->withInput();
            }

            $user->password = Hash::make($request->nova_senha);
            $user->save();
        }

        $dono->nome = $request->nome;
        $dono->telefone = $request->telefone;
        $dono->endereco = $request->endereco;
        $dono->save();

        return redirect()->route('perfil')->with('sucesso', 'Perfil atualizado com sucesso.');
    }
}