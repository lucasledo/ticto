@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Registros de Ponto</h3>

    {{-- Filtro por data --}}
    <form method="GET" action="{{ route('time-records.index') }}" class="row g-3 mb-4">
        <div class="col-md-2">
            <label for="start_date" class="form-label">Data Início</label>
            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="form-control">
        </div>

        <div class="col-md-2">
            <label for="end_date" class="form-label">Data Fim</label>
            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="form-control">
        </div>

        <div class="col-md-3">
            <label for="employee_id" class="form-label">Funcionário</label>
            <select name="employee_id" id="employee_id" class="form-select">
                <option value="">Todos</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                        {{ $employee->person->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="administrator_id" class="form-label">Gestor</label>
            <select name="administrator_id" id="administrator_id" class="form-select">
                <option value="">Todos</option>
                @foreach($administrators as $administrator)
                    <option value="{{ $administrator->id }}" {{ request('administrator_id') == $administrator->id ? 'selected' : '' }}>
                        {{ $administrator->person->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 mt-4">
            <label>&nbsp;</label><br>
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('time-records.index') }}" class="btn btn-secondary">Limpar</a>
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
                    <td>{{ $timeRecord->employee->person->age }}</td>
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
