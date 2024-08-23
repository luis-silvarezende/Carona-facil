@extends('layouts.app')

@section('content')
<style>
    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 1.8rem;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        font-size: 1rem;
    }

    .form-control, 
    #vagas {
        width: 100%;
        padding: 10px;
        font-size: 1rem;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    .btn {
        display: block;
        width: 100%;
        padding: 10px;
        font-size: 1.2rem;
        font-weight: bold;
        color: white;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    @media (max-width: 768px) {
        h1 {
            font-size: 1.5rem;
        }

        .form-control, 
        #vagas {
            font-size: 0.9rem;
            padding: 8px;
        }

        .btn {
            font-size: 1rem;
            padding: 8px;
        }
    }
</style>

<div class="container">
    <h1>Editar Reserva</h1>

    <form action="{{ route('reservas.update', $reserva->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="carona_id">Carona</label>
            <select name="carona_id" id="carona_id" class="form-control" disabled>
                @foreach($caronas as $carona)
                    <option value="{{ $carona->id }}" {{ $carona->id == $reserva->carona_id ? 'selected' : '' }}>
                        Origem: {{ $carona->origem }} - Destino: {{ $carona->destino }} - Data: {{ $carona->data_hora }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="vagas">Vagas</label>
            <input type="number" name="vagas" id="vagas" class="form-control" placeholder="Quantidade de vagas" value="{{ $reserva->vagas ?? null }}" 
                min="1" max="{{ $carona->vagas ?? null }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar Reserva</button>
    </form>
</div>
@endsection
