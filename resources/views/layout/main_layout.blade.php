<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PetShop</title>

    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">

</head>

<body class="bg-light">

    <div class="d-flex">

        @include('layout.menu_lateral')


        {{-- ÁREA PRINCIPAL --}}
        <div style="margin-left: 240px; width: calc(100% - 240px);">


            {{-- TOPO --}}
            <nav class="navbar bg-white shadow-sm px-4">

                <div>

                    <h5 class="mb-0">
                        @yield('page-title')
                    </h5>

                </div>


                <div>

                    <span class="text-muted">
                        <i class="fas fa-user me-1"></i>
                        {{ session('user')['username'] }}
                    </span>

                </div>

            </nav>


            {{-- CONTEÚDO --}}
            <main class="p-4">

                {{-- Mensagens de retorno (sucesso / erro) --}}
                @if (session('sucesso'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('sucesso') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                @endif

                @if (session('erro'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('erro') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                @endif

                @yield('content')

            </main>


        </div>

    </div>


    <script src="{{ asset('assets/bootstrap/bootstrap.bundle.min.js') }}">
    </script>

</body>

</html>