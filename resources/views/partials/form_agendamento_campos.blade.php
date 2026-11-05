{{-- Campos do agendamento (cadastro e edição). $agendamento só existe na edição. --}}

{{-- Pet --}}
<div class="mb-3">

    <label for="id_pet" class="form-label fw-semibold">
        Pet
    </label>

    <select
        name="id_pet"
        id="id_pet"
        class="form-select @error('id_pet') is-invalid @enderror"
        required
    >

        <option value="">
            Selecione o pet
        </option>

        @foreach ($pets as $petItem)

            <option value="{{ $petItem->id }}"
                {{ old('id_pet', $agendamento->id_pet ?? '') == $petItem->id ? 'selected' : '' }}>
                {{ $petItem->nome }} ({{ $petItem->dono->nome ?? 'Sem dono' }})
            </option>

        @endforeach

    </select>

    @error('id_pet')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror

</div>


{{-- Serviço --}}
<div class="mb-3">

    <label for="id_servico" class="form-label fw-semibold">
        Serviço
    </label>

    <select
        name="id_servico"
        id="id_servico"
        class="form-select @error('id_servico') is-invalid @enderror"
        required
    >

        <option value="">
            Selecione o serviço
        </option>

        @foreach ($servicos as $servicoItem)

            <option value="{{ $servicoItem->id }}"
                {{ old('id_servico', $agendamento->id_servico ?? '') == $servicoItem->id ? 'selected' : '' }}>
                {{ $servicoItem->nome }} - R$ {{ number_format($servicoItem->preco, 2, ',', '.') }}
            </option>

        @endforeach

    </select>

    @error('id_servico')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror

</div>


{{-- Data e hora --}}
<div class="mb-3">

    <label for="data_hora" class="form-label fw-semibold">
        Data e hora
    </label>

    <input
        type="datetime-local"
        name="data_hora"
        id="data_hora"
        class="form-control @error('data_hora') is-invalid @enderror"
        value="{{ old('data_hora', isset($agendamento) ? $agendamento->data_hora->format('Y-m-d\TH:i') : '') }}"
        required
    >

    @error('data_hora')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror

</div>


{{-- Status --}}
<div class="mb-3">

    <label for="status" class="form-label fw-semibold">
        Status
    </label>

    <select
        name="status"
        id="status"
        class="form-select @error('status') is-invalid @enderror"
        required
    >

        @foreach ($statusList as $statusItem)

            <option value="{{ $statusItem }}"
                {{ old('status', $agendamento->status ?? 'agendado') == $statusItem ? 'selected' : '' }}>
                {{ ucfirst($statusItem) }}
            </option>

        @endforeach

    </select>

    @error('status')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror

</div>


{{-- Observações --}}
<div class="mb-3">

    <label for="observacoes" class="form-label fw-semibold">
        Observações
    </label>

    <textarea
        name="observacoes"
        id="observacoes"
        rows="3"
        class="form-control @error('observacoes') is-invalid @enderror"
        placeholder="Ex.: pet agitado, alérgico a shampoo comum... (opcional)"
    >{{ old('observacoes', $agendamento->observacoes ?? '') }}</textarea>

    @error('observacoes')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror

</div>
