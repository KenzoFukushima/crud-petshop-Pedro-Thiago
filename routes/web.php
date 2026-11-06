<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonoController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\AgendamentoController;
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

    Route::get('/cadastro', [AuthController::class, 'register'])
        ->name('register');

    Route::post('/cadastroSubmit', [AuthController::class, 'registerSubmit'])
        ->name('registerSubmit');

});


// Rotas para qualquer usuário logado
Route::middleware([CheckIsLogged::class])->group(function () {

    Route::get('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    
    Route::get('/inicio', [HomeDonoController::class, 'index'])
        ->name('home.dono');
    
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
    Route::post('/perfil', [PerfilController::class, 'update'])->name('perfil.update');

        // Área do dono: agendar e cancelar os próprios agendamentos
    Route::post('/inicio/agendar', [HomeDonoController::class, 'agendar'])
        ->name('dono.agendar');

    Route::post('/inicio/agendamento/{id}/cancelar', [HomeDonoController::class, 'cancelar'])
        ->name('dono.cancelar');


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

        Route::delete('/delete-pet/{id}', [PetController::class, 'deletePet'])
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

        Route::delete('/delete-dono/{id}', [DonoController::class, 'deleteDono'])
            ->name('delete.dono');


        // Gerenciamento de Serviços
        Route::get('/lista-servico', [ServicoController::class, 'index'])
            ->name('telaListaServico');

        Route::get('/new-servico', [ServicoController::class, 'newServico'])
            ->name('new.servico');

        Route::post('/new-servico-submit', [ServicoController::class, 'newServicoSubmit'])
            ->name('newServicoSubmit');

        Route::get('/edit-servico/{id}', [ServicoController::class, 'editServico'])
            ->name('edit.servico');

        Route::post('/edit-servico-submit', [ServicoController::class, 'editServicoSubmit'])
            ->name('edit.servico.submit');

        Route::delete('/delete-servico/{id}', [ServicoController::class, 'deleteServico'])
            ->name('delete.servico');


        // Gerenciamento de Agendamentos
        Route::get('/lista-agendamento', [AgendamentoController::class, 'index'])
            ->name('telaListaAgendamento');

        Route::get('/new-agendamento', [AgendamentoController::class, 'newAgendamento'])
            ->name('new.agendamento');

        Route::post('/new-agendamento-submit', [AgendamentoController::class, 'newAgendamentoSubmit'])
            ->name('newAgendamentoSubmit');

        Route::get('/edit-agendamento/{id}', [AgendamentoController::class, 'editAgendamento'])
            ->name('edit.agendamento');

        Route::post('/edit-agendamento-submit', [AgendamentoController::class, 'editAgendamentoSubmit'])
            ->name('edit.agendamento.submit');

        Route::delete('/delete-agendamento/{id}', [AgendamentoController::class, 'deleteAgendamento'])
            ->name('delete.agendamento');

    });

});
