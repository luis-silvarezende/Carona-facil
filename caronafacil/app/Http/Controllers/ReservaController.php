<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Carona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    public function index()
    {
        // Exibe todas as reservas feitas pelo passageiro logado
        $reservas = Reserva::where('passageiro_id', Auth::id())->get();
        return view('reservas.index', compact('reservas'));
    }

    public function create()
    {
        // Exibe o formulário de reserva de uma nova carona
        $caronas = Carona::all(); // Mostra todas as caronas disponíveis para reserva
        return view('reservas.create', compact('caronas'));
    }

    public function store(Request $request)
    {

        // Valida e salva a nova reserva
        $validatedData = $request->validate([
            'carona_id' => 'required|exists:caronas,id',
            'vagas' => 'required|numeric|min:1',
        ]);

        $carona = Carona::query()->where('id', $validatedData['carona_id'])->first();
        $vagas = $carona['vagas'];

        if($vagas >= $validatedData['vagas']) {
            $reserva = new Reserva([
                'carona_id' => $validatedData['carona_id'],
                'passageiro_id' => Auth::id(),
                'status' => 'pendente',
                'vagas' => $validatedData['vagas'],
            ]);

            $reserva->save();
        }else {
            return redirect()->route('reservas.index')->with('error', 'Infelizmente acabaram as vagas!');
        }

        return redirect()->route('reservas.index')->with('success', 'Reserva feita com sucesso!');
    }

    public function edit(Reserva $reserva)
    {
        // Exibe o formulário de edição da reserva
        $caronas = Carona::all(); // Mostra todas as caronas disponíveis para alteração de reserva
        return view('reservas.edit', compact('reserva', 'caronas'));
    }

    public function update(Request $request, Reserva $reserva)
    {
        // Valida e atualiza a reserva
        $validatedData = $request->validate([
            'status' => 'nullable|in:pendente,aceita,rejeitada',
            'vagas' => 'nullable|numeric|min:1'
        ]);

        $reserva->update($validatedData);

        return redirect()->route('reservas.index')->with('success', 'Reserva atualizada com sucesso!');
    }

    public function destroy(Reserva $reserva)
    {
        // Exclui a reserva

        if($reserva['status'] == 'aceita') {
            $carona = Carona::where('id', $reserva['carona_id'])->first();
            
            $carona->update(['vagas' => $carona['vagas'] + $reserva['vagas']]);

            $carona->save();
        }

        $reserva->delete();

        return redirect()->route('reservas.index')->with('success', 'Reserva cancelada com sucesso!');
    }
}

