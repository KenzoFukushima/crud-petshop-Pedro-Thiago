@extends('layout.main_layout')

@section('page-title')
    Serviços
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3>Lista de Serviços</h3>

        <p class="text-muted mb-0">
            Serviços oferecidos pelo PetShop
        </p>
    </div>


    {{-- Novo Serviço --}}
    <a href="{{ route('new.servico') }}" class="btn btn-primary">

        <i class="fas fa-plus me-2"></i>

        Novo Serviço

    </a>

</div>


{{-- Busca --}}
@include('layout.busca', [
    'rota' => route('telaListaServico'),
    'busca' => $busca,
    'placeholder' => 'Buscar por nome ou descrição...',
])


<div class="card shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Duração</th>
                        <th>Ações</th>
                    </tr>

                </thead>


                <tbody>

                    @forelse ($servicos as $servico)

                    <tr>

                        <td>
                            <i class="fas fa-scissors me-2 text-success"></i>
                            {{ $servico->nome }}
                        </td>


                        <td>
                            {{ $servico->descricao ?? 'Não informado' }}
                        </td>


                        <td>
                            R$ {{ number_format($servico->preco, 2, ',', '.') }}
                        </td>


                        <td>
                            {{ $servico->duracao_minutos }} min
                        </td>


                        <td>

                            {{-- Editar --}}
                            <a href="{{ route('edit.servico', ['id' => \App\Services\Operations::encryptId($servico->id)]) }}"
                               class="btn btn-sm btn-warning">

                                <i class="fas fa-edit"></i>

                            </a>


                            {{-- Excluir --}}
                            <form action="{{ route('delete.servico', ['id' => \App\Services\Operations::encryptId($servico->id)]) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Excluir este serviço?')">

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
                        <td colspan="5" class="text-center text-muted py-4">
                            Nenhum registro encontrado.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">

            <div>
                Mostrando {{ $servicos->firstItem() ?? 0 }} a {{ $servicos->lastItem() ?? 0 }}
                de {{ $servicos->total() }} resultados
            </div>

            <div>
                {{ $servicos->links() }}
            </div>

        </div>

    </div>

</div>

@endsection
