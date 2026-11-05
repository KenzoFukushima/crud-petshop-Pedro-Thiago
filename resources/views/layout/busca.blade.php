{{-- Barra de busca reutilizável: @include('layout.busca', ['rota' => ..., 'busca' => ..., 'placeholder' => ...]) --}}
<form action="{{ $rota }}" method="GET" class="row g-2 mb-3">

    <div class="col-md-6 col-lg-5">
        <div class="input-group">

            <span class="input-group-text">
                <i class="fas fa-search"></i>
            </span>

            <input
                type="text"
                name="busca"
                class="form-control"
                value="{{ $busca ?? '' }}"
                placeholder="{{ $placeholder ?? 'Buscar...' }}"
            >

        </div>
    </div>

    <div class="col-auto d-flex gap-2">

        <button type="submit" class="btn btn-primary">
            Buscar
        </button>

        @if (!empty($busca))
            <a href="{{ $rota }}" class="btn btn-secondary">
                Limpar
            </a>
        @endif

    </div>

</form>
