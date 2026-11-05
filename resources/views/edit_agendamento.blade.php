@extends('layout.edicao')

@section('page-title')
    Agendamentos
@endsection

@section('form-fields')

    {{-- ID do agendamento --}}
    <input
        type="hidden"
        name="agendamento_id"
        value="{{ request()->route('id') }}"
    >

    @include('partials.form_agendamento_campos')

@endsection
