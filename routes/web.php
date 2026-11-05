
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonoController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\HomeDonoController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;
use App\Http\Middleware\CheckIsAdmin;
use App\Http\Controllers\PerfilController;


// Rotas de login
Route::middleware([CheckIsNotLogged::class])->group(function () {

    Route::get('/login', [AuthController::class, 'login'])
        ->name('login');

    Route::post('/loginSubmit', [AuthController::class, 'loginSubmit'])
        ->name('loginSubmit');

});


// Rotas para qualquer usuário logado
Route::middleware([CheckIsLogged::class])->group(function () {

    Route::get('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    
    Route::get('/inicio', [HomeDonoController::class, 'index'])
        ->name('home.dono');
    
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
    Route::post('/perfil', [PerfilController::class, 'update'])->name('perfil.update');


    // Rotas exclusivas do administrador
    Route::middleware([CheckIsAdmin::class])->group(function () {

        Route::get('/', [AuthController::class, 'index'])
            ->name('dashboard');


        // Gerenciamento de Pets
        Route::get('/lista-pet', [PetController::class, 'index'])
            ->name('telaListaPet');

        Route::get('/new-pet', [PetController::class, 'newPet'])
            ->name('new.pet');

        Route::post('/new-pet-submit', [PetController::class, 'newPetSubmit'])
            ->name('newPetSubmit');

        Route::get('/edit-pet/{id}', [PetController::class, 'editPet'])
            ->name('edit.pet');

        Route::post('/edit-pet-submit', [PetController::class, 'editPetSubmit'])
            ->name('edit.pet.submit');

        Route::get('/delete-pet/{id}', [PetController::class, 'deletePet'])
            ->name('delete.pet');


        // Gerenciamento de Donos
        Route::get('/lista-dono', [DonoController::class, 'index'])
            ->name('telaListaDono');

        Route::get('/new-dono', [DonoController::class, 'newDono'])
            ->name('new.dono');

        Route::post('/new-dono-submit', [DonoController::class, 'newDonoSubmit'])
            ->name('newDonoSubmit');

        Route::get('/edit-dono/{id}', [DonoController::class, 'editDono'])
            ->name('edit.dono');

        Route::post('/edit-dono-submit', [DonoController::class, 'editDonoSubmit'])
            ->name('edit.dono.submit');

        Route::get('/delete-dono/{id}', [DonoController::class, 'deleteDono'])
            ->name('delete.dono');

    });

});
