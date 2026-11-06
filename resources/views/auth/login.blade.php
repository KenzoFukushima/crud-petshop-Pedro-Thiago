<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PetShop</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">

</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="card border-0" style="width: 380px;">

        <div class="card-body p-4">

            {{-- Logo --}}
            <div class="text-center mb-4">

                <div class="fs-1 text-primary">
                    <i class="fas fa-paw"></i>
                </div>

                <h4 class="fw-bold mb-0">
                    PETSHOP
                </h4>

                <small class="text-muted">
                    SYSTEM
                </small>

                <p class="text-muted mt-2 mb-0">
                    Faça login para acessar o sistema
                </p>

            </div>


            {{-- Formulário --}}
            <form action="{{ route('loginSubmit') }}" method="POST">

                @csrf

                @if (session('login_error'))
                    <div class="alert alert-danger">
                        {{ session('login_error') }}
                    </div>
                @endif

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="emailUser" class="form-control" id="email" placeholder="Digite seu e-mail" value="{{ old('emailUser') }}">
                    @error('emailUser')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" name="passwordUser" class="form-control" id="senha" placeholder="Digite sua senha">
                    @error('passwordUser')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Entrar
                </button>

            </form>

            <p class="text-center text-muted mt-3 mb-0">
                Ainda não tem conta?
                <a href="{{ route('register') }}">Cadastre-se</a>
            </p>

        </div>

    </div>

</body>

</html>