<div class="row g-3">
<!-- Nome -->
<div class="col-md-6">
    <label for="name" class="form-label">Nome Completo</label>
    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $model->person->name ?? '') }}" required>
</div>

<!-- CPF -->
<div class="col-md-3">
    <label for="cpf" class="form-label">CPF</label>
    <input type="text" name="cpf" id="cpf" class="form-control @error('cpf') is-invalid @enderror"
            value="{{ old('cpf', $model->person->cpf ?? '') }}" required>
</div>

<!-- E-mail -->
<div class="col-md-3">
    <label for="email" class="form-label">E-mail</label>
    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $model->person->user->email ?? '') }}" required>
</div>

<!-- Cargo -->
<div class="col-md-6">
    <label for="position" class="form-label">Cargo</label>
    <input type="text" name="position" id="position" class="form-control @error('position') is-invalid @enderror"
            value="{{ old('position', $model->person->position ?? '') }}" required>
</div>

<!-- Data de Nascimento -->
<div class="col-md-3">
    <label for="birthdate" class="form-label">Data de Nascimento</label>
    <input type="date" name="birthdate" id="birthdate" class="form-control @error('birthdate') is-invalid @enderror"
            value="{{ old('birthdate', isset($model->person->birthdate) ? $model->person->birthdate->format('Y-m-d') : '') }}" required>
</div>

<!-- CEP -->
<div class="col-md-3">
    <label for="cep" class="form-label">CEP</label>
    <input type="text" name="cep" id="cep" class="form-control @error('cep') is-invalid @enderror"
            value="{{ old('cep', $model->person->address->cep ?? '') }}" required>
</div>

<!-- Rua -->
<div class="col-md-6">
    <label for="street" class="form-label">Rua</label>
    <input type="text" name="street" id="street" class="form-control @error('street') is-invalid @enderror"
            value="{{ old('street', $model->person->address->street ?? '') }}" required readonly>
</div>

<!-- Número -->
<div class="col-md-2">
    <label for="number" class="form-label">Número</label>
    <input type="text" name="number" id="number" class="form-control @error('number') is-invalid @enderror"
            value="{{ old('number', $model->person->address->number ?? '') }}" required>
</div>

<!-- Complemento -->
<div class="col-md-4">
    <label for="complement" class="form-label">Complemento</label>
    <input type="text" name="complement" id="complement" class="form-control"
            value="{{ old('complement', $model->person->address->complement ?? '') }}">
</div>

<!-- Bairro -->
<div class="col-md-4">
    <label for="neighborhood" class="form-label">Bairro</label>
    <input type="text" name="neighborhood" id="neighborhood" class="form-control @error('neighborhood') is-invalid @enderror"
            value="{{ old('neighborhood', $model->person->address->neighborhood ?? '') }}" required readonly>
</div>

<!-- Cidade -->
<div class="col-md-4">
    <label for="city" class="form-label">Cidade</label>
    <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror"
            value="{{ old('city', $model->person->address->city ?? '') }}" required readonly>
</div>

<!-- Estado -->
<div class="col-md-4">
    <label for="state" class="form-label">Estado</label>
    <input type="text" name="state" id="state" class="form-control @error('state') is-invalid @enderror"
            value="{{ old('state', $model->person->address->state ?? '') }}" required readonly>
</div>

@if(is_null($model))
    <div class="col-md-6">
        <label for="password" class="form-label">Senha</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label for="password_confirmation" class="form-label">Confirmar Senha</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
    </div>
@endif
