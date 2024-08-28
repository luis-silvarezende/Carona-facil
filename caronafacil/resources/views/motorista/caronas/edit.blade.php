@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Carona</h1>

    <form action="{{ route('caronas.update', $carona->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="origem">Origem</label>
            <input type="text" name="origem" id="origem" class="form-control" value="{{ $carona->origem }}" required>
        </div>
        <div class="form-group">
            <label for="destino">Destino</label>
            <input type="text" name="destino" id="destino" class="form-control" value="{{ $carona->destino }}" required>
        </div>
        <div class="form-group">
            <label for="data_hora">Data e Hora</label>
            <input type="datetime-local" name="data_hora" id="data_hora" class="form-control" value="{{ old('data_hora', $carona->data_hora) }}">
        </div>
        <div class="form-group">
            <label for="valor">Valor (opcional)</label>
            <input type="number" step="0.01" name="valor" id="valor" class="form-control" value="{{ $carona->valor }}">
        </div>
        <div class="form-group">
            <label for="veiculo">Veiculo</label>
            <input type="text" name="veiculo" id="veiculo" class="form-control" value="{{ $carona->veiculo }}" required>
        </div>
        <div class="form-group">
            <label for="placa">Placa</label>
            <input type="text" name="placa" id="placa" class="form-control" value="{{ $carona->placa }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar Carona</button>
    </form>
</div>
@endsection
