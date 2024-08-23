@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cadastrar Nova Carona</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('caronas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="origem">Origem</label>
            <input type="text" name="origem" id="origem" class="form-control" required value="{{ old('origem') }}">
        </div>
        <div class="form-group">
            <label for="destino">Destino</label>
            <input type="text" name="destino" id="destino" class="form-control" required value="{{ old('destino') }}">
        </div>
        <div class="form-group">
            <label for="data_hora">Data e Hora</label>
            <input type="datetime-local" name="data_hora" id="data_hora" class="form-control" required value="{{ old('data_hora') }}">
        </div>
        <div class="form-group">
            <label for="valor">Valor (opcional)</label>
            <input type="number" step="0.01" name="valor" id="valor" class="form-control" value="{{ old('valor') }}">
        </div>
        <div class="form-group">
            <label for="veiculo">Veiculo</label>
            <input type="text" name="veiculo" id="veiculo" class="form-control" required value="{{ old('veiculo') }}">
        </div>
        <div class="form-group">
            <label for="placa">Placa</label>
            <input type="text" name="placa" id="placa" class="form-control" required value="{{ old('placa') }}">
        </div>
        <div class="form-group">
            <label for="vagas">Quantidade de Vagas</label>
            <input type="number" name="vagas" id="vagas" class="form-control" min="1" required value="{{ old('vagas', 1) }}">
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar Carona</button>
    </form>
</div>
@endsection
