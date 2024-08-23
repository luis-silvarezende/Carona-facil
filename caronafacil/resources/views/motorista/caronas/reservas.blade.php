@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Reservas</h1>

    <a href="{{ route('caronas.index') }}" class="btn btn-primary mb-3">Voltar</a>

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
                <th>Passageiro</th>
                <th>Vagas Reservadas</th>
                <th>Telefone</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservas as $reserva)
                <tr>
                    <td>{{ $reserva->passageiro->nome }}</td>
                    <td>{{ $reserva->vagas }}</td>
                    <td>{{ $reserva->passageiro->telefone }}</td>
                    <td>{{ ucfirst($reserva->status) }}</td>
                    <td>
                        <form action="{{ route('caronas.reservas.aceitar', $reserva->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success btn-sm">Aceitar</button>
                        </form>
                        <form action="{{ route('caronas.reservas.recusar', $reserva->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger btn-sm">Recusar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
