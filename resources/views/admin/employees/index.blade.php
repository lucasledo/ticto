@extends('layouts.app') <!-- Assumindo que você tenha um layout base -->

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Funcionários</h1>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Adicionar Novo
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover table-striped">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>E-mail</th>
                        <th>Cargo</th>
                        <th>Gestor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->person->name }}</td>
                            <td>{{ $employee->person->cpf }}</td>
                            <td>{{ $employee->person->user->email }}</td>
                            <td>{{ $employee->administrator->person->name }}</td>
                            <td>{{ $employee->person->position }}</td>
                            <td>
                                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-fill"></i> Editar
                                </a>
                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja remover?')">
                                        <i class="bi bi-trash-fill"></i> Remover
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Nenhum funcionário cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $employees->links() }}
        </div>
    </div>
</div>
@endsection
