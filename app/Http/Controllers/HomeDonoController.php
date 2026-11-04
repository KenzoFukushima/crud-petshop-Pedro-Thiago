<?php

namespace App\Http\Controllers;

use App\Models\Pet;

class HomeDonoController extends Controller
{
    public function index()
    {

        $idDono = session('user.id_dono');


        $pets = Pet::where('id_dono', $idDono)->get();

        return view('home_dono', [
            'pets' => $pets
        ]);
    }
}
