@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">{{ isset($employee) ? 'Editar Administrador' : 'Adicionar Novo Administrador' }}</h1>

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

    <form action="{{ isset($employee) ? route('administrators.update', $employee->id) : route('administrators.store') }}" method="POST">
        @csrf
        @if(isset($employee))
            @method('PUT')
        @endif

            @include('admin.person.form', [
                'model' => $employee ?? null
            ])

            <!-- Botão Enviar -->
            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-success">
                    {{ isset($employee) ? 'Atualizar' : 'Cadastrar' }}
                </button>
                <a href="{{ route('administrators.index') }}" class="btn btn-secondary">Cancelar</a>
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
