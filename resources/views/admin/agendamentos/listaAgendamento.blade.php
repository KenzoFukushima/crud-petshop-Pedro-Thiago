@extends('layout.main_layout')

@section('page-title')
    Agendamentos
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3>Lista de Agendamentos</h3>

        <p class="text-muted mb-0">
            Serviços agendados para os pets do PetShop
        </p>
    </div>


    {{-- Novo Agendamento --}}
    <a href="{{ route('new.agendamento') }}" class="btn btn-primary">

        <i class="fas fa-plus me-2"></i>

        Novo Agendamento

    </a>

</div>


{{-- Busca e filtros --}}
<form action="{{ route('telaListaAgendamento') }}" method="GET" class="row g-2 mb-3">

    <div class="col-md-4">
        <div class="input-group">

            <span class="input-group-text">
                <i class="fas fa-search"></i>
            </span>

            <input
                type="text"
                name="busca"
                class="form-control"
                value="{{ $busca }}"
                placeholder="Buscar por pet ou dono..."
            >

        </div>
    </div>

    <div class="col-md-3">
        <select name="status" class="form-select">

            <option value="">Todos os status</option>

            @foreach ($statusList as $statusItem)
                <option value="{{ $statusItem }}" {{ $status === $statusItem ? 'selected' : '' }}>
                    {{ ucfirst($statusItem) }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="col-md-3">
        <input type="date" name="data" class="form-control" value="{{ $data }}">
    </div>

    <div class="col-auto d-flex gap-2">

        <button type="submit" class="btn btn-primary">
            Filtrar
        </button>

        @if ($busca !== '' || $status !== '' || $data !== '')
            <a href="{{ route('telaListaAgendamento') }}" class="btn btn-secondary">
                Limpar
            </a>
        @endif

    </div>

</form>


<div class="card shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>
                        <th>Data e hora</th>
                        <th>Pet</th>
                        <th>Dono</th>
                        <th>Serviço</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>

                </thead>


                <tbody>

                    @forelse ($agendamentos as $agendamento)

                    <tr>

                        <td>
                            <i class="fas fa-calendar-check me-2 text-primary"></i>
                            {{ $agendamento->data_hora->format('d/m/Y H:i') }}
                        </td>


                        <td>
                            {{ $agendamento->pet->nome ?? 'Pet removido' }}
                        </td>


                        <td>
                            {{ $agendamento->pet->dono->nome ?? 'Sem dono' }}
                        </td>


                        <td>
                            {{ $agendamento->servico->nome ?? 'Serviço removido' }}
                        </td>


                        <td>
                            @php
                                $cor = match ($agendamento->status) {
                                    'concluido' => 'success',
                                    'cancelado' => 'secondary',
                                    default => 'primary',
                                };
                            @endphp

                            <span class="badge bg-{{ $cor }}">
                                {{ ucfirst($agendamento->status) }}
                            </span>
                        </td>


                        <td>

                            {{-- Editar --}}
                            <a href="{{ route('edit.agendamento', ['id' => \App\Services\Operations::encryptId($agendamento->id)]) }}"
                               class="btn btn-sm btn-warning">

                                <i class="fas fa-edit"></i>

                            </a>


                            {{-- Excluir --}}
                            <form action="{{ route('delete.agendamento', ['id' => \App\Services\Operations::encryptId($agendamento->id)]) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Excluir este agendamento?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Nenhum registro encontrado.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">

            <div>
                Mostrando {{ $agendamentos->firstItem() ?? 0 }} a {{ $agendamentos->lastItem() ?? 0 }}
                de {{ $agendamentos->total() }} resultados
            </div>

            <div>
                {{ $agendamentos->links() }}
            </div>

        </div>

    </div>

</div>

@endsection
