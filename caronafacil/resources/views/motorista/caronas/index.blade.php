@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Minhas Caronas</h1>

    <!-- Botão para cadastrar nova carona -->
    <a href="{{ route('caronas.create') }}" class="btn btn-primary mb-3">Cadastrar Nova Carona</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Motorista</th>
                <th>Origem</th>
                <th>Destino</th>
                <th>Data e Hora</th>
                <th>Valor</th>
                <th>Veículo</th>
                <th>Placa</th>
                <th>Vagas</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($caronas as $carona)
                <tr>
                    <td>{{ $carona->motorista->nome }}</td>
                    <td>{{ $carona->origem }}</td>
                    <td>{{ $carona->destino }}</td>
                    <td>{{ $carona->data_hora }}</td>
                    <td>{{ $carona->valor ? 'R$' . number_format($carona->valor, 2, ',', '.') : 'Gratuita' }}</td>
                    <td>{{ $carona->veiculo }}</td>
                    <td>{{ $carona->placa }}</td>
                    <td>{{ $carona->vagas > 0 ? $carona->vagas : 'Lotada' }}</td>
                    <td>
                        <a href="{{ route('caronas.reservas', $carona->id) }}" class="btn btn-primary btn-sm">Reservas</a>
                        <a href="{{ route('caronas.edit', $carona->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('caronas.destroy', $carona->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
