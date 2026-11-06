@extends('layout.edicao')

@section('page-title')
    Donos
@endsection

@section('form-fields')

    <input
        type="hidden"
        name="dono_id"
        value="{{ request()->route('id') }}"
    >


    {{-- Nome --}}
    <div class="mb-3">

        <label for="nome" class="form-label fw-semibold">
            Nome
        </label>

        <input
            type="text"
            name="nome"
            id="nome"
            class="form-control @error('nome') is-invalid @enderror"
            value="{{ old('nome', $dono->nome) }}"
            placeholder="Digite o nome do dono"
        >

        @error('nome')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Email --}}
    <div class="mb-3">

        <label for="email" class="form-label fw-semibold">
            E-mail
        </label>

        <input
            type="email"
            name="email"
            id="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $dono->email) }}"
            placeholder="Digite o e-mail"
        >

        @error('email')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Telefone --}}
    <div class="mb-3">

        <label for="telefone" class="form-label fw-semibold">
            Telefone
        </label>

        <input
            type="text"
            name="telefone"
            id="telefone"
            class="form-control @error('telefone') is-invalid @enderror"
            value="{{ old('telefone', $dono->telefone) }}"
            placeholder="Digite o telefone"
        >

        @error('telefone')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- CPF --}}
    <div class="mb-3">

        <label for="cpf" class="form-label fw-semibold">
            CPF
        </label>

        <input
            type="text"
            name="cpf"
            id="cpf"
            class="form-control @error('cpf') is-invalid @enderror"
            value="{{ old('cpf', $dono->cpf) }}"
            placeholder="Digite o CPF"
        >

        @error('cpf')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Endereço --}}
    <div class="mb-3">

        <label for="endereco" class="form-label fw-semibold">
            Endereço
        </label>

        <input
            type="text"
            name="endereco"
            id="endereco"
            class="form-control @error('endereco') is-invalid @enderror"
            value="{{ old('endereco', $dono->endereco) }}"
            placeholder="Digite o endereço"
        >

        @error('endereco')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

    </div>

@endsection