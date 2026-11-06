@extends('layout.cadastro')

@section('page-title')
    Pets
@endsection

@section('form-fields')

    {{-- Dono --}}
    <div class="mb-3">

        <label for="id_dono" class="form-label fw-semibold">
            Dono
        </label>

        <select
            name="id_dono"
            id="id_dono"
            class="form-select @error('id_dono') is-invalid @enderror"
            required
        >

            <option value="">
                Selecione o dono
            </option>

            @foreach ($donos as $donoItem)

                <option value="{{ $donoItem->id }}" {{ old('id_dono') == $donoItem->id ? 'selected' : '' }}>
                    {{ $donoItem->nome }}
                </option>

            @endforeach

        </select>

        @error('id_dono')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

    </div>

    {{-- Nome --}}
    <div class="mb-3">

        <label for="nome" class="form-label fw-semibold">
            Nome do pet
        </label>

        <input
            type="text"
            name="nome"
            id="nome"
            class="form-control @error('nome') is-invalid @enderror"
            value="{{ old('nome') }}"
            placeholder="Digite o nome do pet"
            required
        >

        @error('nome')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Espécie --}}
    <div class="mb-3">

        <label for="especie" class="form-label fw-semibold">
            Espécie
        </label>

        <select
            name="especie"
            id="especie"
            class="form-select @error('especie') is-invalid @enderror"
            required
        >

            <option value="">
                Selecione a espécie
            </option>

            <option value="Cachorro" {{ old('especie') == 'Cachorro' ? 'selected' : '' }}>
                Cachorro
            </option>

            <option value="Gato" {{ old('especie') == 'Gato' ? 'selected' : '' }}>
                Gato
            </option>

            <option value="Ave" {{ old('especie') == 'Ave' ? 'selected' : '' }}>
                Ave
            </option>

            <option value="Coelho" {{ old('especie') == 'Coelho' ? 'selected' : '' }}>
                Coelho
            </option>

        </select>

        @error('especie')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Raça --}}
    <div class="mb-3">

        <label for="raça" class="form-label fw-semibold">
            Raça
        </label>

        <input
            type="text"
            name="raça"
            id="raça"
            class="form-control @error('raça') is-invalid @enderror"
            value="{{ old('raça') }}"
            placeholder="Digite a raça"
        >

        @error('raça')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Peso --}}
    <div class="mb-3">

        <label for="peso" class="form-label fw-semibold">
            Peso (kg)
        </label>

        <input
            type="number"
            name="peso"
            id="peso"
            step="0.01"
            min="0"
            class="form-control @error('peso') is-invalid @enderror"
            value="{{ old('peso') }}"
            placeholder="Ex.: 12.50"
        >

        @error('peso')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Data de nascimento --}}
    <div class="mb-3">

        <label for="idade" class="form-label fw-semibold">
            Data de nascimento
        </label>

        <input
            type="date"
            name="idade"
            id="idade"
            class="form-control @error('idade') is-invalid @enderror"
            value="{{ old('idade') }}"
        >

        @error('idade')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

    </div>

@endsection