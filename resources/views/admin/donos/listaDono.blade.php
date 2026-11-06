@extends('layout.main_layout')

@section('page-title')
    Donos
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3>Lista de Donos</h3>

        <p class="text-muted mb-0">
            Cadastros de clientes do PetShop
        </p>
    </div>


    {{-- Novo Dono --}}
    <a href="{{ route('new.dono') }}" class="btn btn-primary">

        <i class="fas fa-plus me-2"></i>

        Novo Dono

    </a>

</div>


{{-- Busca --}}
@include('layout.busca', [
    'rota' => route('telaListaDono'),
    'busca' => $busca,
    'placeholder' => 'Buscar por nome, e-mail, telefone ou CPF...',
])


<div class="card shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>CPF</th>
                        <th>Ações</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($donos as $dono)

                    <tr>

                        <td>

                            <i class="fas fa-user me-2 text-primary"></i>

                            {{ $dono->nome }}

                        </td>


                        <td>
                            {{ $dono->email }}
                        </td>


                        <td>
                            {{ $dono->telefone }}
                        </td>


                        <td>
                            {{ $dono->cpf ?? 'Não informado' }}
                        </td>


                        <td>

                            {{-- Editar --}}
                            <a href="{{ route('edit.dono', ['id' => \App\Services\Operations::encryptId($dono->id)]) }}"
                               class="btn btn-sm btn-warning">

                                <i class="fas fa-edit"></i>

                            </a>


                            {{-- Excluir --}}
                            <form action="{{ route('delete.dono', ['id' => \App\Services\Operations::encryptId($dono->id)]) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Excluir este dono? O login dele também será removido.')">

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
                Mostrando {{ $donos->firstItem() ?? 0 }} a {{ $donos->lastItem() ?? 0 }}
                de {{ $donos->total() }} resultados
            </div>

            <div>
                {{ $donos->links() }}
            </div>

        </div>

    </div>

</div>

@endsection