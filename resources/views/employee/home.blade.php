@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3>Registro de Ponto</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('time-records.store') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary btn-lg mt-3">
            Registrar Ponto
        </button>
    </form>
</div>
@endsection
