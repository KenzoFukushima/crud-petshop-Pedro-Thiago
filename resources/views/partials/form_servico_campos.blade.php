{{-- Campos do serviço (usado no cadastro e na edição). $servico só existe na edição. --}}

{{-- Nome --}}
<div class="mb-3">

    <label for="nome" class="form-label fw-semibold">
        Nome do serviço
    </label>

    <input
        type="text"
        name="nome"
        id="nome"
        class="form-control @error('nome') is-invalid @enderror"
        value="{{ old('nome', $servico->nome ?? '') }}"
        placeholder="Ex.: Banho e Tosa"
        required
    >

    @error('nome')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror

</div>


{{-- Descrição --}}
<div class="mb-3">

    <label for="descricao" class="form-label fw-semibold">
        Descrição
    </label>

    <input
        type="text"
        name="descricao"
        id="descricao"
        class="form-control @error('descricao') is-invalid @enderror"
        value="{{ old('descricao', $servico->descricao ?? '') }}"
        placeholder="Descreva o serviço (opcional)"
    >

    @error('descricao')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror

</div>


{{-- Preço --}}
<div class="mb-3">

    <label for="preco" class="form-label fw-semibold">
        Preço (R$)
    </label>

    <input
        type="number"
        name="preco"
        id="preco"
        step="0.01"
        min="0"
        class="form-control @error('preco') is-invalid @enderror"
        value="{{ old('preco', $servico->preco ?? '') }}"
        placeholder="Ex.: 50.00"
        required
    >

    @error('preco')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror

</div>


{{-- Duração --}}
<div class="mb-3">

    <label for="duracao_minutos" class="form-label fw-semibold">
        Duração (minutos)
    </label>

    <input
        type="number"
        name="duracao_minutos"
        id="duracao_minutos"
        step="5"
        min="5"
        max="480"
        class="form-control @error('duracao_minutos') is-invalid @enderror"
        value="{{ old('duracao_minutos', $servico->duracao_minutos ?? '') }}"
        placeholder="Ex.: 45"
        required
    >

    @error('duracao_minutos')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror

</div>
