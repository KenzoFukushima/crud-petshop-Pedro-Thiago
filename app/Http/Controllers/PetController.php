<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\Dono;
use App\Services\Operations;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::with('dono')->orderBy('nome')->paginate(10);

        return view('listaPet', [
            'pets' => $pets
        ]);
    }

    public function newPet()
    {
        $donos = Dono::all();

        return view('new_pet', [
            'donos' => $donos,
            'titulo' => 'Cadastrar Pet',
            'descricao' => 'Cadastre um novo pet para o dono.',
            'action' => route('newPetSubmit'),
            'botao' => 'Cadastrar Pet',
            'cancelUrl' => route('telaListaPet'),
        ]);
    }

    public function newPetSubmit(Request $request)
    {
        $request->validate([
            'id_dono' => 'required|exists:donos,id',
            'nome' => 'required|min:2|max:100',
            'especie' => 'required|max:50',
            'raça' => 'nullable|max:100',
            'peso' => 'nullable|numeric',
            'idade' => 'nullable|date',
        ], [
            'id_dono.required' => 'O dono é obrigatório.',
            'id_dono.exists' => 'O dono selecionado não existe.',
            'nome.required' => 'O nome do pet é obrigatório.',
            'nome.min' => 'O nome deve ter pelo menos :min caracteres.',
            'nome.max' => 'O nome deve ter no máximo :max caracteres.',
            'especie.required' => 'A espécie é obrigatória.',
            'especie.max' => 'A espécie deve ter no máximo :max caracteres.',
            'raça.max' => 'A raça deve ter no máximo :max caracteres.',
            'peso.numeric' => 'O peso deve ser um número.',
            'idade.date' => 'A data deve ser válida.',
        ]);

        $pet = new Pet();
        $pet->id_dono = $request->id_dono;
        $pet->nome = $request->nome;
        $pet->especie = $request->especie;
        $pet->raça = $request->raça;
        $pet->peso = $request->peso;
        $pet->idade = $request->idade;
        $pet->save();

        return redirect()->route('telaListaPet');
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

    public function editPetSubmit(Request $request)
    {
        if ($request->pet_id === null) {
            return redirect()->route('telaListaPet');
        }

        $request->validate([
            'nome' => 'required|min:2|max:100',
            'especie' => 'required|max:50',
            'raça' => 'nullable|max:100',
            'peso' => 'nullable|numeric',
            'idade' => 'nullable|date',
        ], [
            'nome.required' => 'O nome do pet é obrigatório.',
            'nome.min' => 'O nome deve ter pelo menos :min caracteres.',
            'nome.max' => 'O nome deve ter no máximo :max caracteres.',
            'especie.required' => 'A espécie é obrigatória.',
            'especie.max' => 'A espécie deve ter no máximo :max caracteres.',
            'raça.max' => 'A raça deve ter no máximo :max caracteres.',
            'peso.numeric' => 'O peso deve ser um número.',
            'idade.date' => 'A data deve ser válida.',
        ]);

        try {
            $id = Operations::decryptId($request->pet_id);
        } catch (DecryptException $e) {
            return redirect()->route('telaListaPet')->with('erro', 'Link inválido ou adulterado.');
        }

        $pet = Pet::find($id);

        if (!$pet) {
            return redirect()->route('telaListaPet');
        }

        $pet->nome = $request->nome;
        $pet->especie = $request->especie;
        $pet->raça = $request->raça;
        $pet->peso = $request->peso;
        $pet->idade = $request->idade;
        $pet->save();

        return redirect()->route('telaListaPet');
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

        return redirect()->route('telaListaPet');
    }
}