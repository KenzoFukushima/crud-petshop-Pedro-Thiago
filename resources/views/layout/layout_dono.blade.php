
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'PetShop')</title>

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
</head>

<body>

    {{-- Barra de navegação --}}
    <nav class="navbar navbar-expand-lg bg-body py-3">
        <div class="container">

            <a class="navbar-brand fw-bold fs-4 d-inline-flex align-items-center gap-2"
            href="{{ route('home.dono') }}">

                <i class="fas fa-paw fs-3 text-primary"></i>

                PetShop

            </a>


            <div class="collapse navbar-collapse" id="menuDono">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home.dono') }}">
                            Início
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-dark" href="#servicos">
                            Serviços
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('home.dono') }}#meus-pets">
                            Meus Pets
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-primary rounded-pill px-4"
                            href="{{ route('logout') }}">
                            Sair
                        </a>
                    </li>

                </ul>
            </div>

        </div>
    </nav>

    {{-- Conteúdo das páginas --}}
    @yield('content')

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
