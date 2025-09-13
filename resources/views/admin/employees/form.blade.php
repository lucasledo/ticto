@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">{{ isset($employee) ? 'Editar Funcionário' : 'Adicionar Novo Funcionário' }}</h1>

    {{-- Alerts de erros --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ops!</strong> Verifique os campos abaixo:
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Alerts de sucesso --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ isset($employee) ? route('employees.update', $employee->id) : route('employees.store') }}" method="POST">
        @csrf
        @if(isset($employee))
            @method('PUT')
        @endif

        <div class="row g-3">
            <!-- Nome -->
            <div class="col-md-6">
                <label for="name" class="form-label">Nome Completo</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $employee->person->name ?? '') }}" required>
            </div>

            <!-- CPF -->
            <div class="col-md-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" name="cpf" id="cpf" class="form-control @error('cpf') is-invalid @enderror"
                       value="{{ old('cpf', $employee->person->cpf ?? '') }}" required>
            </div>

            <!-- E-mail -->
            <div class="col-md-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $employee->person->user->email ?? '') }}" required>
            </div>

            <!-- Cargo -->
            <div class="col-md-6">
                <label for="position" class="form-label">Cargo</label>
                <input type="text" name="position" id="position" class="form-control @error('position') is-invalid @enderror"
                       value="{{ old('position', $employee->person->position ?? '') }}" required>
            </div>

            <!-- Data de Nascimento -->
            <div class="col-md-3">
                <label for="birthdate" class="form-label">Data de Nascimento</label>
                <input type="date" name="birthdate" id="birthdate" class="form-control @error('birthdate') is-invalid @enderror"
                       value="{{ old('birthdate', isset($employee->person->birthdate) ? $employee->person->birthdate->format('Y-m-d') : '') }}" required>
            </div>

            <!-- CEP -->
            <div class="col-md-3">
                <label for="cep" class="form-label">CEP</label>
                <input type="text" name="cep" id="cep" class="form-control @error('cep') is-invalid @enderror"
                       value="{{ old('cep', $employee->person->address->cep ?? '') }}" required>
            </div>

            <!-- Rua -->
            <div class="col-md-6">
                <label for="street" class="form-label">Rua</label>
                <input type="text" name="street" id="street" class="form-control @error('street') is-invalid @enderror"
                       value="{{ old('street', $employee->person->address->street ?? '') }}" required readonly>
            </div>

            <!-- Número -->
            <div class="col-md-2">
                <label for="number" class="form-label">Número</label>
                <input type="text" name="number" id="number" class="form-control @error('number') is-invalid @enderror"
                       value="{{ old('number', $employee->person->address->number ?? '') }}" required>
            </div>

            <!-- Complemento -->
            <div class="col-md-4">
                <label for="complement" class="form-label">Complemento</label>
                <input type="text" name="complement" id="complement" class="form-control"
                       value="{{ old('complement', $employee->person->address->complement ?? '') }}">
            </div>

            <!-- Bairro -->
            <div class="col-md-4">
                <label for="neighborhood" class="form-label">Bairro</label>
                <input type="text" name="neighborhood" id="neighborhood" class="form-control @error('neighborhood') is-invalid @enderror"
                       value="{{ old('neighborhood', $employee->person->address->neighborhood ?? '') }}" required readonly>
            </div>

            <!-- Cidade -->
            <div class="col-md-4">
                <label for="city" class="form-label">Cidade</label>
                <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror"
                       value="{{ old('city', $employee->person->address->city ?? '') }}" required readonly>
            </div>

            <!-- Estado -->
            <div class="col-md-4">
                <label for="state" class="form-label">Estado</label>
                <input type="text" name="state" id="state" class="form-control @error('state') is-invalid @enderror"
                       value="{{ old('state', $employee->person->address->state ?? '') }}" required readonly>
            </div>

            @if(!isset($employee))
                <div class="col-md-6">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>
            @endif

            <!-- Botão Enviar -->
            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-success">
                    {{ isset($employee) ? 'Atualizar' : 'Cadastrar' }}
                </button>
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </div>
    </form>
</div>

<!-- Script para buscar endereço pelo CEP -->
<script>
document.getElementById('cep').addEventListener('blur', function() {
    let cep = this.value.replace(/\D/g, '');
    if(cep.length === 8){
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if(!data.erro){
                    document.getElementById('street').value = data.logradouro;
                    document.getElementById('neighborhood').value = data.bairro;
                    document.getElementById('city').value = data.localidade;
                    document.getElementById('state').value = data.uf;
                } else {
                    alert('CEP não encontrado!');
                }
            })
            .catch(() => alert('Erro ao consultar CEP'));
    }
});
</script>

<!-- Máscaras -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
$(document).ready(function(){
    $('#cpf').mask('000.000.000-00');
    $('#cep').mask('00000-000');
});
</script>
@endsection
