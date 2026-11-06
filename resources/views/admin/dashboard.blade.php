@extends('layout.main_layout')

@section('page-title')
    <h3>Dashboard</h3>
@endsection

@section('content')

    {{-- Cabeçalho --}}
    <div class="mb-4">

        <h2 class="fw-bold">
            Olá, {{ session('user')['username'] }}!
        </h2>

        <p class="text-muted">
            Bem-vindo ao sistema de gerenciamento do Pet Shop.
        </p>

    </div>


    {{-- CARDS --}}
    <div class="row g-4">


        {{-- Donos --}}
        <div class="col-md-6">

            <div class="card border-2 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Donos
                            </p>

                            <h2 class="fw-bold mb-0">
                                {{ $totalDonos }}
                            </h2>

                        </div>

                        <div class="fs-1 text-primary">

                            <i class="fas fa-users"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Pets --}}
        <div class="col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Pets
                            </p>

                            <h2 class="fw-bold mb-0">
                                {{ $totalPets }}
                            </h2>  

                        </div>

                        <div class="fs-1 text-success">

                            <i class="fas fa-paw"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ACESSO RÁPIDO --}}
    <div class="mt-5">

        <h4 class="fw-bold mb-3">
            Acesso rápido
        </h4>


        <div class="row g-4">


            {{-- Donos --}}
            <div class="col-md-6">

                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4">

                        <div class="d-flex align-items-center">

                            <div class="fs-1 text-primary me-4">

                                <i class="fas fa-users"></i>

                            </div>


                            <div>

                                <h5 class="fw-bold">
                                    Gerenciar Donos
                                </h5>

                                <p class="text-muted">
                                    Cadastre e gerencie os donos dos pets.
                                </p>

                                <a href="{{ route('telaListaDono') }}"
                                   class="btn btn-primary">

                                    Acessar Donos

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Pets --}}
            <div class="col-md-6">

                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4">

                        <div class="d-flex align-items-center">

                            <div class="fs-1 text-success me-4">

                                <i class="fas fa-paw"></i>

                            </div>


                            <div>

                                <h5 class="fw-bold">
                                    Gerenciar Pets
                                </h5>

                                <p class="text-muted">
                                    Cadastre e gerencie os animais.
                                </p>

                                <a href="{{ route('telaListaPet') }}"
                                   class="btn btn-success">

                                    Acessar Pets

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


        </div>

    </div>

@endsection