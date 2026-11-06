<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use App\Http\Requests\ServicoRequest;
use App\Models\Servico;
use App\Services\Operations;
use Illuminate\Support\Facades\Storage;

class ServicoController extends Controller
{
    public function index(Request $request)
    {
        // Busca por nome ou descrição
        $busca = trim((string) $request->query('busca', ''));

        $servicos = Servico::query()
            ->when($busca !== '', function ($query) use ($busca) {
                $query->where(function ($q) use ($busca) {
                    $q->where('nome', 'like', "%{$busca}%")
                        ->orWhere('descricao', 'like', "%{$busca}%");
                });
            })
            ->orderBy('nome')
            ->paginate(10)
            ->withQueryString();

        return view('listaServico', [
            'servicos' => $servicos,
            'busca' => $busca,
        ]);
    }

    public function newServico()
    {
        return view('new_servico', [
            'titulo' => 'Cadastrar Serviço',
            'descricao' => 'Cadastre um novo serviço oferecido pelo Pet Shop.',
            'action' => route('newServicoSubmit'),
            'botao' => 'Cadastrar Serviço',
            'cancelUrl' => route('telaListaServico'),
        ]);
    }

    public function newServicoSubmit(ServicoRequest $request)
    {
        $dados = $request->safe()->except('imagem');

        if ($request->hasFile('imagem')) {
            $dados['imagem'] = $request->file('imagem')->store('servicos', 'public');
        }

        Servico::create($dados);

        return redirect()->route('telaListaServico')
            ->with('sucesso', 'Serviço cadastrado com sucesso.');
    }

    public function editServico($id)
    {
        try {
            $decrypted_id = Operations::decryptId($id);
        } catch (DecryptException $e) {
            return redirect()->route('telaListaServico')
                ->with('erro', 'Link inválido ou adulterado.');
        }

        $servico = Servico::find($decrypted_id);

        if (!$servico) {
            return redirect()->route('telaListaServico');
        }

        return view('edit_servico', [
            'servico' => $servico,
            'titulo' => 'Editar Serviço',
            'descricao' => 'Altere os dados do serviço abaixo.',
            'action' => route('edit.servico.submit'),
            'botao' => 'Salvar alterações',
            'cancelUrl' => route('telaListaServico'),
        ]);
    }

    public function editServicoSubmit(ServicoRequest $request)
    {
        try {
            $id = Operations::decryptId($request->servico_id);
        } catch (DecryptException $e) {
            return redirect()->route('telaListaServico')
                ->with('erro', 'Link inválido ou adulterado.');
        }

        $servico = Servico::find($id);

        if (!$servico) {
            return redirect()->route('telaListaServico');
        }

        $dados = $request->safe()->except(['servico_id', 'imagem']);

        // Imagem nova: apaga a antiga do disco e guarda a nova
        if ($request->hasFile('imagem')) {

            if ($servico->imagem) {
                Storage::disk('public')->delete($servico->imagem);
            }

            $dados['imagem'] = $request->file('imagem')->store('servicos', 'public');
        }

        $servico->update($dados);

        return redirect()->route('telaListaServico')
            ->with('sucesso', 'Serviço atualizado com sucesso.');
    }

    public function deleteServico($id)
    {
        try {
            $decrypted_id = Operations::decryptId($id);
        } catch (DecryptException $e) {
            return redirect()->route('telaListaServico')
                ->with('erro', 'Link inválido ou adulterado.');
        }

        $servico = Servico::find($decrypted_id);

        if (!$servico) {
            return redirect()->route('telaListaServico');
        }

        $servico->delete();

        return redirect()->route('telaListaServico')
            ->with('sucesso', 'Serviço excluído com sucesso.');
    }
}
