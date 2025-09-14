@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Relatórios</h3>

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
            <a href="{{ route('reports.index') }}" class="btn btn-secondary">Limpar Filtros</a>
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
            @forelse($records['data'] ?? [] as $timeRecord)
                <tr>
                    <td>{{ $timeRecord->id }}</td>
                    <td>{{ $timeRecord->employee_name}}</td>
                    <td>{{ $timeRecord->position }}</td>
                    <td>{{ $timeRecord->age }}</td>
                    <td>{{ $timeRecord->administrator_name }}</td>
                    <td>{{ $timeRecord->time_recorded_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Nenhum registro encontrado</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginação --}}
    @if ($records['last_page'] > 1)
    <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">

        <div class="text-center text-muted small">
            Showing <strong>{{ $records['from'] }}</strong>
            to <strong>{{ $records['to'] }}</strong>
            of <strong>{{ $records['total'] }}</strong> results
        </div>

        <nav>
            <ul class="pagination justify-content-center">

                {{-- Botão Anterior --}}
                <li class="page-item {{ $records['prev_page_url'] ? '' : 'disabled' }}">
                    @if ($records['prev_page_url'])
                        <a class="page-link" href="{{ $records['prev_page_url'] }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    @else
                        <span class="page-link" aria-hidden="true">&laquo;</span>
                    @endif
                </li>

                {{-- Números das páginas --}}
                @for ($i = 1; $i <= $records['last_page']; $i++)
                    <li class="page-item {{ $records['current_page'] === $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ route('reports.index', array_merge(request()->all(), ['page' => $i])) }}">
                            {{ $i }}
                        </a>
                    </li>
                @endfor

                {{-- Botão Próximo --}}
                <li class="page-item {{ $records['next_page_url'] ? '' : 'disabled' }}">
                    @if ($records['next_page_url'])
                        <a class="page-link" href="{{ $records['next_page_url'] }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    @else
                        <span class="page-link" aria-hidden="true">&raquo;</span>
                    @endif
                </li>
            </ul>
        </nav>
    </div>
@endif

</div>
@endsection
