@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Card -->
    <div class="card mx-auto" style="max-width: 500px;">
        <div class="card-body text-center">
            <h4 class="card-title">Bem-vindo ao CaronaFacil!</h4>
            <p class="card-text">Escolha uma das opções abaixo para continuar:</p>

            <div class="d-grid gap-2 d-md-block">
                <a href="{{ route('motorista.login') }}" class="btn btn-primary btn-lg">Sou Motorista</a>
                <a href="{{ route('passageiro.login') }}" class="btn btn-secondary btn-lg">Sou Passageiro</a>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .container {
        padding-top: 50px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .header h2 {
        font-size: 2rem;
        font-weight: bold;
    }

    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        padding: 20px;
    }

    .card-title {
        font-size: 1.5rem;
        margin-bottom: 20px;
    }

    .card-text {
        margin-bottom: 20px;
        font-size: 1rem;
    }

    .btn-lg {
        width: 45%;
        margin: 10px 2.5%;
    }
</style>
