@extends('layouts.app') <!-- Assumindo que você tenha um layout base -->

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Administradores</h1>
        <a href="{{ route('administrators.create') }}" class="btn btn-primary">
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
                        <th>Email</th>
                        <th>CPF</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($administrators as $admin)
                    <tr>
                        <td>{{ $admin->id }}</td>
                        <td>{{ $admin->person->name }}</td>
                        <td>{{ $admin->person->user->email }}</td>
                        <td>{{ $admin->person->cpf }}</td>
                        <td>
                            <a href="{{ route('administrators.edit', $admin) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('administrators.destroy', $admin) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Confirma exclusão?')">Remover</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $administrators->links() }}
        </div>
    </div>
</div>
@endsection
