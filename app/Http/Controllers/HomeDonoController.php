<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Requests\AgendamentoDonoRequest;
use App\Models\Agendamento;
use App\Models\Pet;
use App\Models\Servico;
use App\Services\Operations;

class HomeDonoController extends Controller
{
    public function index()
    {
        // O administrador não tem página de dono
        if (session('user.role') === 'admin') {
            return redirect()->route('dashboard');
        }

        $idDono = session('user.id_dono');

        // Pets do dono logado
        $pets = Pet::where('id_dono', $idDono)
            ->orderBy('nome')
            ->get();

        // Catálogo de serviços
        $servicos = Servico::orderBy('nome')->get();

        // Agendamentos dos pets deste dono, do mais recente para o mais antigo
        $agendamentos = Agendamento::with(['pet', 'servico'])
            ->whereHas('pet', function ($query) use ($idDono) {
                $query->where('id_dono', $idDono);
            })
            ->orderBy('data_hora', 'desc')
            ->limit(20)
            ->get();

        return view('home_dono', [
            'pets' => $pets,
            'servicos' => $servicos,
            'agendamentos' => $agendamentos,
        ]);
    }

    public function agendar(AgendamentoDonoRequest $request)
    {
        $dados = $request->validated();
        $dataHora = Carbon::parse($dados['data_hora']);

        // Horário já ocupado por outro agendamento ativo
        $ocupado = Agendamento::where('status', 'agendado')
            ->where('data_hora', $dataHora->format('Y-m-d H:i:00'))
            ->exists();

        if ($ocupado) {
            return redirect(route('home.dono') . '#agendar')
                ->withInput()
                ->withErrors(['data_hora' => 'Este horário já está ocupado. Escolha outro.']);
        }

        Agendamento::create([
            'id_pet' => $dados['id_pet'],
            'id_servico' => $dados['id_servico'],
            'data_hora' => $dataHora->format('Y-m-d H:i:00'),
            'status' => 'agendado',
            'observacoes' => $dados['observacoes'] ?? null,
        ]);

        return redirect(route('home.dono') . '#meus-agendamentos')
            ->with('sucesso', 'Serviço agendado com sucesso.');
    }

    public function cancelar($id)
    {
        try {
            $idAgendamento = Operations::decryptId($id);
        } catch (DecryptException $e) {
            return redirect()->route('home.dono')->with('erro', 'Link inválido ou adulterado.');
        }

        $idDono = session('user.id_dono');

        // Só cancela agendamento de pet que é do dono logado
        $agendamento = Agendamento::where('id', $idAgendamento)
            ->where('status', 'agendado')
            ->whereHas('pet', function ($query) use ($idDono) {
                $query->where('id_dono', $idDono);
            })
            ->first();

        if (!$agendamento) {
            return redirect()->route('home.dono')->with('erro', 'Agendamento não encontrado.');
        }

        $agendamento->update(['status' => 'cancelado']);

        return redirect(route('home.dono') . '#meus-agendamentos')
            ->with('sucesso', 'Agendamento cancelado.');
    }
}