<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use App\Http\Requests\DonoRequest;
use App\Models\Dono;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DonoController extends Controller
{
    private const SENHA_INICIAL = '12345678';
    public function index(Request $request)
    {
        // Busca por nome, e-mail, telefone ou CPF
        $busca = trim((string) $request->query('busca', ''));

        $donos = Dono::query()
            ->when($busca !== '', function ($query) use ($busca) {
                $query->where(function ($q) use ($busca) {
                    $q->where('nome', 'like', "%{$busca}%")
                        ->orWhere('email', 'like', "%{$busca}%")
                        ->orWhere('telefone', 'like', "%{$busca}%")
                        ->orWhere('cpf', 'like', "%{$busca}%");
                });
            })
            ->orderBy('nome')
            ->paginate(10)
            ->withQueryString();

        return view('listaDono', [
            'donos' => $donos,
            'busca' => $busca,
        ]);
    }

    public function newDono()
    {
        return view('new_dono', [
            'titulo' => 'Cadastrar Dono',
            'descricao' => 'Cadastre um novo dono para o Pet Shop.',
            'action' => route('newDonoSubmit'),
            'botao' => 'Cadastrar Dono',
            'cancelUrl' => route('telaListaDono'),
        ]);
    }

    public function newDonoSubmit(DonoRequest $request)
    {
        DB::transaction(function () use ($request) {

            // 1. Criar o dono
            $dono = Dono::create($request->validated());

            // 2. Criar o usuário vinculado ao dono
            User::create([
                'email' => $dono->email,
                'username' => $dono->email,
                'password' => Hash::make(self::SENHA_INICIAL),
                'role' => 'dono',
                'id_dono' => $dono->id,
            ]);

        });

            return redirect()->route('telaListaDono')
            ->with('sucesso', 'Dono cadastrado com sucesso. Login: ' . $request->email . ' | senha inicial: ' . self::SENHA_INICIAL);
    }

    public function editDono($id)
    {
        try {
            $decrypted_id = Operations::decryptId($id);
        } catch (DecryptException $e) {
            return redirect()->route('telaListaDono')
                ->with('erro', 'Link inválido ou adulterado.');
        }

        $dono = Dono::find($decrypted_id);

        if (!$dono) {
            return redirect()->route('telaListaDono');
        }

        return view('edit_dono', [
            'dono' => $dono,
            'titulo' => 'Editar Dono',
            'descricao' => 'Altere os dados do dono abaixo.',
            'action' => route('edit.dono.submit'),
            'botao' => 'Salvar alterações',
            'cancelUrl' => route('telaListaDono'),
        ]);
    }

    public function editDonoSubmit(DonoRequest $request)
    {
        try {
            $id = Operations::decryptId($request->dono_id);
        } catch (DecryptException $e) {
            return redirect()->route('telaListaDono')
                ->with('erro', 'Link inválido ou adulterado.');
        }

        $dono = Dono::find($id);

        if (!$dono) {
            return redirect()->route('telaListaDono');
        }

        DB::transaction(function () use ($dono, $request) {

            // Atualizar os dados do dono
            $dono->update($request->safe()->except('dono_id'));

            // Mantém o login (users) igual ao e-mail do dono
            User::where('id_dono', $dono->id)->update([
                'email' => $dono->email,
                'username' => $dono->email,
            ]);

        });

        return redirect()->route('telaListaDono')
            ->with('sucesso', 'Dono atualizado com sucesso.');
    }

    public function deleteDono($id)
    {
        try {
            $decrypted_id = Operations::decryptId($id);
        } catch (DecryptException $e) {
            return redirect()->route('telaListaDono')
                ->with('erro', 'Link inválido ou adulterado.');
        }

        $dono = Dono::find($decrypted_id);

        if (!$dono) {
            return redirect()->route('telaListaDono');
        }

        DB::transaction(function () use ($dono) {

            User::where('id_dono', $dono->id)->delete();

            $dono->delete();

        });

        return redirect()->route('telaListaDono')
            ->with('sucesso', 'Dono excluído com sucesso.');
    }
}
