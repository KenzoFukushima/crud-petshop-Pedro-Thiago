<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - PetShop</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">

</head>

<body class="bg-light">

    <div class="container py-5" style="max-width: 520px;">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <div class="text-center mb-4">

                    <div class="fs-1 text-primary">
                        <i class="fas fa-paw"></i>
                    </div>

                    <h4 class="fw-bold mb-0">PETSHOP</h4>

                    <p class="text-muted mt-2 mb-0">
                        Crie sua conta de cliente
                    </p>

                </div>


                <form action="{{ route('registerSubmit') }}" method="POST">

                    @csrf

                    <div class="mb-3">
                        <label for="nome" class="form-label fw-semibold">Nome</label>
                        <input type="text" name="nome" id="nome"
                               class="form-control @error('nome') is-invalid @enderror"
                               value="{{ old('nome') }}" placeholder="Seu nome completo" required>
                        @error('nome')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">E-mail</label>
                        <input type="email" name="email" id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="Será o seu login" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="telefone" class="form-label fw-semibold">Telefone</label>
                        <input type="text" name="telefone" id="telefone"
                               class="form-control @error('telefone') is-invalid @enderror"
                               value="{{ old('telefone') }}" placeholder="(00) 00000-0000" required>
                        @error('telefone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cpf" class="form-label fw-semibold">CPF <small class="text-muted">(opcional)</small></label>
                        <input type="text" name="cpf" id="cpf"
                               class="form-control @error('cpf') is-invalid @enderror"
                               value="{{ old('cpf') }}" placeholder="000.000.000-00">
                        @error('cpf')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="endereco" class="form-label fw-semibold">Endereço <small class="text-muted">(opcional)</small></label>
                        <input type="text" name="endereco" id="endereco"
                               class="form-control @error('endereco') is-invalid @enderror"
                               value="{{ old('endereco') }}">
                        @error('endereco')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Senha</label>
                        <input type="password" name="password" id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Mínimo de 8 caracteres" required>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold">Confirmar senha</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Cadastrar
                    </button>

                </form>

                <p class="text-center text-muted mt-3 mb-0">
                    Já tem conta?
                    <a href="{{ route('login') }}">Entrar</a>
                </p>

            </div>

        </div>

    </div>

</body>

</html>