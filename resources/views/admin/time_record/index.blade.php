@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Registros de Ponto</h3>

    {{-- Filtro por data --}}
    <form method="GET" class="row g-3 mb-3">
        <div class="col-auto">
            <input type="date" name="start_date" class="form-control"
                   value="{{ request('start_date') }}">
        </div>
        <div class="col-auto">
            <input type="date" name="end_date" class="form-control"
                   value="{{ request('end_date') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
        <div class="col-auto">
            <a href="{{ route('time-records.index') }}" class="btn btn-secondary">Limpar Filtros</a>
        </div>
    </form>

    {{-- Tabela --}}
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Funcionário</th>
                <th>Cargo</th>
                <th>Idade</th>
                <th>Gestor</th>
                <th>Data e Hora</th>
            </tr>
        </thead>
        <tbody>
            @forelse($timeRecords as $timeRecord)
                <tr>
                    <td>{{ $timeRecord->id }}</td>
                    <td>{{ $timeRecord->employee->person->name }}</td>
                    <td>{{ $timeRecord->employee->person->position ?? '-' }}</td>
                    <td>{{ $timeRecord->employee->person->birthdate ? \Carbon\Carbon::parse($timeRecord->employee->person->birthdate)->age : '-' }}</td>
                    <td>{{ $timeRecord->employee->administrator->person->name ?? '-' }}</td>
                    <td>{{ $timeRecord->time_recorded_at->format('d/m/Y H:i:s') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Nenhum registro encontrado</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginação --}}
    {{ $timeRecords->links() }}
</div>
@endsection
