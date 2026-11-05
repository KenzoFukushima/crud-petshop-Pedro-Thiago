<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use App\Http\Requests\PetRequest;
use App\Models\Pet;
use App\Models\Dono;
use App\Services\Operations;

class PetController extends Controller
{
    public function index(Request $request)
    {
        // Busca por nome, espécie, raça ou nome do dono
        $busca = trim((string) $request->query('busca', ''));

        $pets = Pet::with('dono')
            ->when($busca !== '', function ($query) use ($busca) {
                $query->where(function ($q) use ($busca) {
                    $q->where('nome', 'like', "%{$busca}%")
                        ->orWhere('especie', 'like', "%{$busca}%")
                        ->orWhere('raça', 'like', "%{$busca}%")
                        ->orWhereHas('dono', function ($d) use ($busca) {
                            $d->where('nome', 'like', "%{$busca}%");
                        });
                });
            })
            ->orderBy('nome')
            ->paginate(10)
            ->withQueryString();

        return view('listaPet', [
            'pets' => $pets,
            'busca' => $busca,
        ]);
    }

    public function newPet()
    {
        $donos = Dono::orderBy('nome')->get();

        return view('new_pet', [
            'donos' => $donos,
            'titulo' => 'Cadastrar Pet',
            'descricao' => 'Cadastre um novo pet para o dono.',
            'action' => route('newPetSubmit'),
            'botao' => 'Cadastrar Pet',
            'cancelUrl' => route('telaListaPet'),
        ]);
    }

    public function newPetSubmit(PetRequest $request)
    {
        Pet::create($request->validated());

        return redirect()->route('telaListaPet')
            ->with('sucesso', 'Pet cadastrado com sucesso.');
    }

    public function editPet($id)
    {
        try {
            $decrypted_id = Operations::decryptId($id);
        } catch (DecryptException $e) {
            return redirect()->route('telaListaPet')->with('erro', 'Link inválido ou adulterado.');
        }

        $pet = Pet::find($decrypted_id);

        if (!$pet) {
            return redirect()->route('telaListaPet');
        }

        return view('edit_pet', [
            'pet' => $pet,
            'titulo' => 'Editar Pet',
            'descricao' => 'Altere os dados do pet abaixo.',
            'action' => route('edit.pet.submit'),
            'botao' => 'Salvar alterações',
            'cancelUrl' => route('telaListaPet'),
        ]);
    }

    public function editPetSubmit(PetRequest $request)
    {
        try {
            $id = Operations::decryptId($request->pet_id);
        } catch (DecryptException $e) {
            return redirect()->route('telaListaPet')->with('erro', 'Link inválido ou adulterado.');
        }

        $pet = Pet::find($id);

        if (!$pet) {
            return redirect()->route('telaListaPet');
        }

        $pet->update($request->safe()->except('pet_id'));

        return redirect()->route('telaListaPet')
            ->with('sucesso', 'Pet atualizado com sucesso.');
    }

    public function deletePet($id)
    {
        try {
            $decrypted_id = Operations::decryptId($id);
        } catch (DecryptException $e) {
            return redirect()->route('telaListaPet')->with('erro', 'Link inválido ou adulterado.');
        }

        $pet = Pet::find($decrypted_id);

        if (!$pet) {
            return redirect()->route('telaListaPet');
        }

        $pet->delete();

        return redirect()->route('telaListaPet')
            ->with('sucesso', 'Pet excluído com sucesso.');
    }
}
