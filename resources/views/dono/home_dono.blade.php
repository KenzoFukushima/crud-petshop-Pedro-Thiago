
@extends('layout.layout_dono')

@section('title', 'PetShop - Início')

@section('content')

<div class="container py-4">

    {{-- MENSAGENS --}}
    @if (session('sucesso'))
        <div class="alert alert-success">
            {{ session('sucesso') }}
        </div>
    @endif

    @if (session('erro'))
        <div class="alert alert-danger">
            {{ session('erro') }}
        </div>
    @endif

    {{-- INÍCIO --}}
    <div class="mb-4">
        <h3>Olá, {{ session('user.username') }}!</h3>
        <p class="text-muted">
            Confira seus pets, nossos serviços e seus agendamentos.
        </p>
    </div>

    <hr>

    {{-- MEUS PETS --}}
    <section id="meus-pets" class="mb-5">

        <h5 class="mb-3">Meus pets</h5>

        <div class="row">

            @forelse ($pets as $pet)

                <div class="col-md-4 mb-3">

                    <div class="border rounded p-3">

                        <h6>{{ $pet->nome }}</h6>

                        <p class="text-muted mb-1">
                            {{ $pet->especie }}
                            @if ($pet->raça)
                                - {{ $pet->raça }}
                            @endif
                        </p>

                        @if ($pet->idade)
                            <small>
                                Nascimento:
                                {{ \Carbon\Carbon::parse($pet->idade)->format('d/m/Y') }}
                            </small>
                            <br>
                        @endif

                        @if ($pet->peso)
                            <small>
                                Peso: {{ number_format($pet->peso, 2, ',', '.') }} kg
                            </small>
                        @endif

                    </div>

                </div>

            @empty

                <div class="col-12">
                    <p class="text-muted">
                        Você ainda não possui pets cadastrados.
                    </p>
                </div>

            @endforelse

        </div>

    </section>

    {{-- SERVIÇOS --}}
    <section id="servicos" class="mb-5">

        <h5 class="mb-3">Nossos serviços</h5>

        <div class="row">

            @forelse ($servicos as $servico)

                <div class="col-md-4 mb-3">

                    <div class="border rounded h-100">

                        @if ($servico->imagem)
                            <img
                                src="{{ asset('storage/' . $servico->imagem) }}"
                                alt="{{ $servico->nome }}"
                                class="w-100"
                                style="height: 150px; object-fit: cover;"
                            >
                        @endif

                        <div class="p-3">

                            <h6>{{ $servico->nome }}</h6>

                            <p class="text-muted small">
                                {{ $servico->descricao ?: 'Sem descrição.' }}
                            </p>

                            <p class="mb-0">
                                <strong>
                                    R$ {{ number_format($servico->preco, 2, ',', '.') }}
                                </strong>
                                <span class="text-muted small">
                                    - {{ $servico->duracao_minutos }} min
                                </span>
                            </p>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12">
                    <p class="text-muted">
                        Nenhum serviço disponível no momento.
                    </p>
                </div>

            @endforelse

        </div>

    </section>

    {{-- AGENDAMENTO --}}
    <section id="agendar" class="mb-5">

        <h5 class="mb-3">Agendar um serviço</h5>

        <div class="border rounded p-3">

            @if ($pets->isEmpty())

                <p class="text-muted mb-0">
                    É necessário ter pelo menos um pet cadastrado para realizar um agendamento.
                </p>

            @else

                <form action="{{ route('dono.agendar') }}" method="POST">

                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label for="id_pet" class="form-label">Pet</label>

                            <select name="id_pet" id="id_pet"
                                class="form-select @error('id_pet') is-invalid @enderror" required>

                                <option value="">Selecione um pet</option>

                                @foreach ($pets as $pet)
                                    <option value="{{ $pet->id }}"
                                        {{ old('id_pet') == $pet->id ? 'selected' : '' }}>
                                        {{ $pet->nome }}
                                    </option>
                                @endforeach

                            </select>

                            @error('id_pet')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="id_servico" class="form-label">Serviço</label>

                            <select name="id_servico" id="id_servico"
                                class="form-select @error('id_servico') is-invalid @enderror" required>

                                <option value="">Selecione um serviço</option>

                                @foreach ($servicos as $servico)
                                    <option value="{{ $servico->id }}"
                                        {{ old('id_servico') == $servico->id ? 'selected' : '' }}>
                                        {{ $servico->nome }} -
                                        R$ {{ number_format($servico->preco, 2, ',', '.') }}
                                    </option>
                                @endforeach

                            </select>

                            @error('id_servico')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="data_hora" class="form-label">Data e horário</label>

                            <input type="datetime-local" name="data_hora" id="data_hora"
                                class="form-control @error('data_hora') is-invalid @enderror"
                                value="{{ old('data_hora') }}" required>

                            @error('data_hora')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="observacoes" class="form-label">Observações (opcional)</label>

                            <input type="text" name="observacoes" id="observacoes"
                                class="form-control @error('observacoes') is-invalid @enderror"
                                value="{{ old('observacoes') }}"
                                placeholder="Informações adicionais">

                            @error('observacoes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">
                        Agendar
                    </button>

                </form>

            @endif

        </div>

    </section>

    {{-- MEUS AGENDAMENTOS --}}
    <section id="meus-agendamentos" class="mb-5">

        <h5 class="mb-3">Meus agendamentos</h5>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>Data e horário</th>
                        <th>Pet</th>
                        <th>Serviço</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($agendamentos as $agendamento)

                        <tr>

                            <td>
                                {{ $agendamento->data_hora->format('d/m/Y H:i') }}
                            </td>

                            <td>{{ $agendamento->pet->nome ?? '-' }}</td>

                            <td>{{ $agendamento->servico->nome ?? '-' }}</td>

                            <td>
                                @php
                                    $cor = [
                                        'agendado' => 'primary',
                                        'concluido' => 'success',
                                        'cancelado' => 'secondary',
                                    ][$agendamento->status] ?? 'secondary';
                                @endphp

                                <span class="badge bg-{{ $cor }}">
                                    {{ ucfirst($agendamento->status) }}
                                </span>
                            </td>

                            <td>

                                @if ($agendamento->status === 'agendado')

                                    <form
                                        action="{{ route('dono.cancelar', ['id' => \App\Services\Operations::encryptId($agendamento->id)]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Cancelar este agendamento?')">

                                        @csrf

                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Cancelar
                                        </button>

                                    </form>

                                @else
                                    -
                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Você ainda não possui agendamentos.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </section>

</div>

@endsection
