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

                    @foreach ($pets as $pet)

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
                            <a href="{{ route('delete.pet', [
                                'id' => \App\Services\Operations::encryptId($pet->id)
                            ]) }}"
                               class="btn btn-sm btn-danger">

                                <i class="fas fa-trash"></i>

                            </a>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">

            {{-- Quantidade de resultados à esquerda --}}
            <div>
                Mostrando {{ $pets->firstItem() }} a {{ $pets->lastItem() }}
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