@extends('layout.main_layout')

@section('page-title')
    <h3>{{ $titulo ?? 'Cadastrar' }}</h3>
@endsection

@section('content')

<div class="mb-4">
    <h2 class="fw-bold">
        {{ $titulo ?? 'Cadastrar' }}
    </h2>

    <p class="text-muted">
        {{ $descricao ?? 'Preencha os dados abaixo para realizar o cadastro.' }}
    </p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf

            @yield('form-fields')

            <div class="d-flex gap-2 mt-4">

                <button type="submit" class="btn btn-primary">
                    {{ $botao ?? 'Cadastrar' }}
                </button>

                <a href="{{ $cancelUrl ?? route('dashboard') }}"
                   class="btn btn-secondary">
                    Cancelar
                </a>

            </div>

        </form>

    </div>
</div>

@endsection