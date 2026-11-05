@extends('layout.main_layout')

@section('page-title')
    Pets
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3>Lista de Pets</h3>

        <p class="text-muted mb-0">
            Cadastros de pets do PetShop
        </p>
    </div>


    {{-- Novo Pet --}}
    <a href="{{ route('new.pet') }}" class="btn btn-primary">

        <i class="fas fa-plus me-2"></i>

        Novo Pet

    </a>

</div>


{{-- Busca --}}
@include('layout.busca', [
    'rota' => route('telaListaPet'),
    'busca' => $busca,
    'placeholder' => 'Buscar por nome, espécie, raça ou dono...',
])


<div class="card shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>
                        <th>Nome</th>
                        <th>Espécie</th>
                        <th>Raça</th>
                        <th>Dono</th>
                        <th>Data de Nascimento</th>
                        <th>Ações</th>
                    </tr>

                </thead>


                <tbody>

                    @forelse ($pets as $pet)

                    <tr>

                        <td>
                            <i class="fas fa-paw me-2 text-success"></i>
                            {{ $pet->nome }}
                        </td>


                        <td>
                            {{ $pet->especie }}
                        </td>


                        <td>
                            {{ $pet->raça ?? 'Não informado' }}
                        </td>


                        <td>
                            {{ $pet->dono->nome ?? 'Sem dono' }}
                        </td>


                        <td>
                            {{ $pet->idade
                                ? \Carbon\Carbon::parse($pet->idade)->format('d/m/Y')
                                : 'Não informado'
                            }}
                        </td>


                        <td>

                            {{-- Editar --}}
                            <a href="{{ route('edit.pet', [
                                'id' => \App\Services\Operations::encryptId($pet->id)
                            ]) }}"
                               class="btn btn-sm btn-warning">

                                <i class="fas fa-edit"></i>

                            </a>


                            {{-- Excluir --}}
                            <form action="{{ route('delete.pet', ['id' => \App\Services\Operations::encryptId($pet->id)]) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Excluir este pet?')">

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

            {{-- Quantidade de resultados à esquerda --}}
            <div>
                Mostrando {{ $pets->firstItem() ?? 0 }} a {{ $pets->lastItem() ?? 0 }}
                de {{ $pets->total() }} resultados
            </div>

            {{-- Paginação à direita --}}
            <div>
                {{ $pets->links() }}
            </div>

        </div>

    </div>

</div>

@endsection