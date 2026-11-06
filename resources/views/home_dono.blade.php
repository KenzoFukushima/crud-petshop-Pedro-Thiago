@extends('layout.layout_dono')

@section('title', 'PetShop - Início')

@section('content')
<div class="container py-5">

    {{-- Mensagens de retorno --}}
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


    <div class="mb-5">
        <h2 class="fw-bold">Olá, {{ session('user.username') }}!</h2>
        <p class="text-muted mb-0">
            Veja seus pets, conheça nossos serviços e agende um horário.
        </p>
    </div>


    {{-- MEUS PETS --}}
    <section id="meus-pets" class="mb-5">

        <h4 class="fw-bold mb-3">Meus pets</h4>

        <div class="row g-3">

            @forelse ($pets as $pet)

                <div class="col-sm-6 col-lg-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body d-flex align-items-center gap-3">

                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light border text-success fs-3 flex-shrink-0"
                                  style="width: 72px; height: 72px;">
                                <i class="fas fa-paw"></i>
                            </span>

                            <div>
                                <h5 class="mb-1">{{ $pet->nome }}</h5>

                                <div class="text-muted small">
                                    {{ $pet->especie }}
                                    @if ($pet->raça)
                                        · {{ $pet->raça }}
                                    @endif
                                </div>

                                <div class="text-muted small">
                                    @if ($pet->idade)
                                        Nascimento: {{ \Carbon\Carbon::parse($pet->idade)->format('d/m/Y') }}
                                    @endif
                                    @if ($pet->peso)
                                        · {{ number_format($pet->peso, 2, ',', '.') }} kg
                                    @endif
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12">
                    <div class="alert alert-light border mb-0">
                        Você ainda não tem pets cadastrados. Fale com a recepção do PetShop.
                    </div>
                </div>

            @endforelse

        </div>

    </section>


    {{-- SERVIÇOS --}}
    <section id="servicos" class="mb-5">

        <h4 class="fw-bold mb-3">Nossos serviços</h4>

        <div class="row g-3">

            @forelse ($servicos as $servico)

                <div class="col-sm-6 col-lg-4">

                    <div class="card border-0 shadow-sm h-100">

                        @if ($servico->imagem)
                            <img src="{{ asset('storage/' . $servico->imagem) }}"
                                 alt="Imagem de {{ $servico->nome }}"
                                 class="card-img-top"
                                 style="height: 160px; object-fit: cover;">
                        @endif

                        <div class="card-body">

                            <h5 class="mb-1">
                                <i class="fas fa-scissors text-primary me-2"></i>
                                {{ $servico->nome }}
                            </h5>

                            <p class="text-muted small mb-3">
                                {{ $servico->descricao ?: 'Sem descrição.' }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">
                                    R$ {{ number_format($servico->preco, 2, ',', '.') }}
                                </span>
                                <span class="text-muted small">
                                    <i class="far fa-clock me-1"></i>{{ $servico->duracao_minutos }} min
                                </span>
                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12">
                    <div class="alert alert-light border mb-0">
                        Nenhum serviço disponível no momento.
                    </div>
                </div>

            @endforelse

        </div>

    </section>


    {{-- AGENDAR --}}
    <section id="agendar" class="mb-5">

        <h4 class="fw-bold mb-3">Agendar um serviço</h4>

        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                @if ($pets->isEmpty())

                    <p class="text-muted mb-0">
                        Para agendar, é preciso ter ao menos um pet cadastrado.
                    </p>

                @else

                    <form action="{{ route('dono.agendar') }}" method="POST">
                        @csrf

                        <div class="row g-3">

                            {{-- Pet --}}
                            <div class="col-md-6">

                                <label for="id_pet" class="form-label fw-semibold">Pet</label>

                                <select name="id_pet" id="id_pet"
                                        class="form-select @error('id_pet') is-invalid @enderror" required>

                                    <option value="">Selecione o pet</option>

                                    @foreach ($pets as $pet)
                                        <option value="{{ $pet->id }}" {{ old('id_pet') == $pet->id ? 'selected' : '' }}>
                                            {{ $pet->nome }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('id_pet')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                            </div>

                            {{-- Serviço --}}
                            <div class="col-md-6">

                                <label for="id_servico" class="form-label fw-semibold">Serviço</label>

                                <select name="id_servico" id="id_servico"
                                        class="form-select @error('id_servico') is-invalid @enderror" required>

                                    <option value="">Selecione o serviço</option>

                                    @foreach ($servicos as $servico)
                                        <option value="{{ $servico->id }}" {{ old('id_servico') == $servico->id ? 'selected' : '' }}>
                                            {{ $servico->nome }} - R$ {{ number_format($servico->preco, 2, ',', '.') }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('id_servico')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                            </div>

                            {{-- Data e hora --}}
                            <div class="col-md-6">

                                <label for="data_hora" class="form-label fw-semibold">Data e hora</label>

                                <input type="datetime-local" name="data_hora" id="data_hora"
                                       class="form-control @error('data_hora') is-invalid @enderror"
                                       value="{{ old('data_hora') }}" required>

                                @error('data_hora')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                            </div>

                            {{-- Observações --}}
                            <div class="col-md-6">

                                <label for="observacoes" class="form-label fw-semibold">Observações</label>

                                <input type="text" name="observacoes" id="observacoes"
                                       class="form-control @error('observacoes') is-invalid @enderror"
                                       value="{{ old('observacoes') }}"
                                       placeholder="Opcional. Ex.: pet agitado">

                                @error('observacoes')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary mt-4">
                            <i class="far fa-calendar-check me-2"></i>
                            Agendar
                        </button>

                    </form>

                @endif

            </div>

        </div>

    </section>


    {{-- MEUS AGENDAMENTOS --}}
    <section id="meus-agendamentos" class="mb-5">

        <h4 class="fw-bold mb-3">Meus agendamentos</h4>

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>
                            <tr>
                                <th>Data e hora</th>
                                <th>Pet</th>
                                <th>Serviço</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($agendamentos as $agendamento)

                                <tr>

                                    <td>{{ $agendamento->data_hora->format('d/m/Y H:i') }}</td>

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

                                    <td class="text-end">

                                        @if ($agendamento->status === 'agendado')
                                            <form action="{{ route('dono.cancelar', ['id' => \App\Services\Operations::encryptId($agendamento->id)]) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Cancelar este agendamento?')">

                                                @csrf

                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    Cancelar
                                                </button>

                                            </form>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Você ainda não tem agendamentos.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </section>

</div>
@endsection