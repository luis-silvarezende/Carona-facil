@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Minhas Reservas</h1>

    <a href="{{ route('reservas.create') }}" class="btn btn-primary mb-3">Reservar Nova Carona</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Motorista</th>
                <th>Passageiro</th>
                <th>Vagas</th>
                <th>Origem</th>
                <th>Destino</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservas as $reserva)
                <tr>
                    <td>{{ $reserva?->carona?->motorista?->nome }}</td>
                    <td>{{ $reserva?->passageiro?->nome }}</td>
                    <td>{{ $reserva?->vagas }}</td>
                    <td>{{ $reserva?->carona?->origem }}</td>
                    <td>{{ $reserva?->carona?->destino }}</td>
                    <td>{{ ucfirst($reserva?->status) }}</td>
                    <td>
                        @if( $reserva->status != 'rejeitada')
                            @if( $reserva->status == 'pendente')
                                <a href="{{ route('reservas.edit', $reserva->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            @endif
                            <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
