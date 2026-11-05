<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use App\Http\Requests\AgendamentoRequest;
use App\Models\Agendamento;
use App\Models\Pet;
use App\Models\Servico;
use App\Services\Operations;

class AgendamentoController extends Controller
{
    public function index(Request $request)
    {
        // Filtros: nome do pet/dono, status e data
        $busca = trim((string) $request->query('busca', ''));
        $status = (string) $request->query('status', '');
        $data = (string) $request->query('data', '');

        $agendamentos = Agendamento::with(['pet.dono', 'servico'])
            ->when($busca !== '', function ($query) use ($busca) {
                $query->whereHas('pet', function ($p) use ($busca) {
                    $p->where('nome', 'like', "%{$busca}%")
                        ->orWhereHas('dono', function ($d) use ($busca) {
                            $d->where('nome', 'like', "%{$busca}%");
                        });
                });
            })
            ->when(in_array($status, Agendamento::STATUS, true), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($data !== '' && Carbon::hasFormat($data, 'Y-m-d'), function ($query) use ($data) {
                $query->whereDate('data_hora', $data);
            })
            ->orderBy('data_hora', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('listaAgendamento', [
            'agendamentos' => $agendamentos,
            'busca' => $busca,
            'status' => $status,
            'data' => $data,
            'statusList' => Agendamento::STATUS,
        ]);
    }

    public function newAgendamento()
    {
        return view('new_agendamento', [
            'pets' => Pet::with('dono')->orderBy('nome')->get(),
            'servicos' => Servico::orderBy('nome')->get(),
            'statusList' => Agendamento::STATUS,
            'titulo' => 'Novo Agendamento',
            'descricao' => 'Agende um serviço para um pet.',
            'action' => route('newAgendamentoSubmit'),
            'botao' => 'Agendar',
            'cancelUrl' => route('telaListaAgendamento'),
        ]);
    }

    public function newAgendamentoSubmit(AgendamentoRequest $request)
    {
        Agendamento::create($request->validated());

        return redirect()->route('telaListaAgendamento')
            ->with('sucesso', 'Agendamento realizado com sucesso.');
    }

    public function editAgendamento($id)
    {
        try {
            $decrypted_id = Operations::decryptId($id);
        } catch (DecryptException $e) {
            return redirect()->route('telaListaAgendamento')
                ->with('erro', 'Link inválido ou adulterado.');
        }

        $agendamento = Agendamento::find($decrypted_id);

        if (!$agendamento) {
            return redirect()->route('telaListaAgendamento');
        }

        return view('edit_agendamento', [
            'agendamento' => $agendamento,
            'pets' => Pet::with('dono')->orderBy('nome')->get(),
            'servicos' => Servico::orderBy('nome')->get(),
            'statusList' => Agendamento::STATUS,
            'titulo' => 'Editar Agendamento',
            'descricao' => 'Altere os dados do agendamento abaixo.',
            'action' => route('edit.agendamento.submit'),
            'botao' => 'Salvar alterações',
            'cancelUrl' => route('telaListaAgendamento'),
        ]);
    }

    public function editAgendamentoSubmit(AgendamentoRequest $request)
    {
        try {
            $id = Operations::decryptId($request->agendamento_id);
        } catch (DecryptException $e) {
            return redirect()->route('telaListaAgendamento')
                ->with('erro', 'Link inválido ou adulterado.');
        }

        $agendamento = Agendamento::find($id);

        if (!$agendamento) {
            return redirect()->route('telaListaAgendamento');
        }

        $agendamento->update($request->safe()->except('agendamento_id'));

        return redirect()->route('telaListaAgendamento')
            ->with('sucesso', 'Agendamento atualizado com sucesso.');
    }

    public function deleteAgendamento($id)
    {
        try {
            $decrypted_id = Operations::decryptId($id);
        } catch (DecryptException $e) {
            return redirect()->route('telaListaAgendamento')
                ->with('erro', 'Link inválido ou adulterado.');
        }

        $agendamento = Agendamento::find($decrypted_id);

        if (!$agendamento) {
            return redirect()->route('telaListaAgendamento');
        }

        $agendamento->delete();

        return redirect()->route('telaListaAgendamento')
            ->with('sucesso', 'Agendamento excluído com sucesso.');
    }
}
