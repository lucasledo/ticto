@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row g-4">
            <!-- Funcionários -->
            <div class="col-md-3">
                <a href="{{ route('employees.index') }}" class="text-decoration-none">
                    <div class="card text-center shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-people-fill display-4 mb-3 text-primary"></i>
                            <h5 class="card-title">Funcionários</h5>
                            <p class="card-text">Gerenciar todos os funcionários cadastrados.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Registro de Ponto -->
            <div class="col-md-3">
                <a href="{{ route('time-records.index') }}" class="text-decoration-none">
                    <div class="card text-center shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-clock-fill display-4 mb-3 text-success"></i>
                            <h5 class="card-title">Registro de Ponto</h5>
                            <p class="card-text">Visualizar e gerenciar os registros de ponto.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Relatórios -->
            <div class="col-md-3">
                <a href="{{ route('reports.index') }}" class="text-decoration-none">
                    <div class="card text-center shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-file-earmark-text-fill display-4 mb-3 text-warning"></i>
                            <h5 class="card-title">Relatórios</h5>
                            <p class="card-text">Gerar relatórios detalhados de pontos e funcionários.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Administradores -->
            <div class="col-md-3">
                <a href="{{ route('administrators.index') }}" class="text-decoration-none">
                    <div class="card text-center shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-person-badge-fill display-4 mb-3 text-danger"></i>
                            <h5 class="card-title">Administradores</h5>
                            <p class="card-text">Gerenciar outros administradores do sistema.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
