@extends('layout.edicao')

@section('page-title')
    Serviços
@endsection

@section('form-fields')

    {{-- ID do serviço --}}
    <input
        type="hidden"
        name="servico_id"
        value="{{ request()->route('id') }}"
    >

    @include('partials.form_servico_campos')

@endsection
