@extends('layout.layout_dono')

@section('content')
<div class="container py-5" style="max-width: 600px;">

    <h3 class="mb-1">Meu Perfil</h3>
    <p class="text-muted mb-4">Seus dados cadastrados no PetShop</p>

    @if (session('sucesso'))
        <div class="alert alert-success">
            {{ session('sucesso') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('perfil.update') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nome" class="form-label fw-semibold">Nome</label>
                    <input type="text" name="nome" id="nome"
                           class="form-control @error('nome') is-invalid @enderror"
                           value="{{ old('nome', $dono->nome) }}" required>
                    @error('nome')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="text" class="form-control" value="{{ $dono->email }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">CPF</label>
                    <input type="text" class="form-control" value="{{ $dono->cpf ?? 'Não informado' }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="telefone" class="form-label fw-semibold">Telefone</label>
                    <input type="text" name="telefone" id="telefone"
                           class="form-control @error('telefone') is-invalid @enderror"
                           value="{{ old('telefone', $dono->telefone) }}" required>
                    @error('telefone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="endereco" class="form-label fw-semibold">Endereço</label>
                    <input type="text" name="endereco" id="endereco"
                           class="form-control @error('endereco') is-invalid @enderror"
                           value="{{ old('endereco', $dono->endereco) }}">
                    @error('endereco')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-4">

                <h6 class="mb-3">Alterar senha <small class="text-muted">(deixe em branco para manter a atual)</small></h6>

                <div class="mb-3">
                    <label for="senha_atual" class="form-label fw-semibold">Senha atual</label>
                    <input type="password" name="senha_atual" id="senha_atual"
                        class="form-control @error('senha_atual') is-invalid @enderror">
                    @error('senha_atual')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nova_senha" class="form-label fw-semibold">Nova senha</label>
                    <input type="password" name="nova_senha" id="nova_senha"
                        class="form-control @error('nova_senha') is-invalid @enderror">
                    @error('nova_senha')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nova_senha_confirmation" class="form-label fw-semibold">Confirmar nova senha</label>
                    <input type="password" name="nova_senha_confirmation" id="nova_senha_confirmation"
                        class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">
                    Salvar alterações
                </button>

            </form>

        </div>
    </div>

</div>
@endsection