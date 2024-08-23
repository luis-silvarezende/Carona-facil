<?php

namespace App\Http\Controllers;

use App\Models\Carona;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;

class CaronaController extends Controller
{
    public function index()
    {
        // Carrega as caronas com as informações do motorista e do veículo
        $caronas = Carona::where('motorista_id', Auth::id())
                    ->with(['motorista'])
                    ->get()
                    ->map(function($carona) {
                        $carona->data_hora = \Carbon\Carbon::parse($carona->data_hora)->format('d/m/Y H:i');
                        return $carona;
                    });
        
        return view('motorista.caronas.index', compact('caronas'));
    }
    
    public function create()
    {
        // Exibe o formulário de criação de nova carona
        return view('motorista.caronas.create');
    }

    public function store(Request $request)
    {
        // Valida e salva a nova carona
        $validatedData = $request->validate([
            'origem' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'data_hora' => 'required|date',
            'valor' => 'nullable|numeric',
            'vagas' => 'required|integer|min:1',
            'veiculo' => 'required|string|max:255',
            'placa' => 'required|string|max:255',
        ]);
    
        $carona = new Carona($validatedData);
        $carona->motorista_id = Auth::id();
        $carona->save();
    
        return redirect()->route('caronas.index')->with('success', 'Carona cadastrada com sucesso!');
    }
    

    public function edit(Carona $carona)
    {
        // Formata o campo data_hora para o formato correto do input datetime-local
        $carona->data_hora = Carbon::parse($carona->data_hora)->format('Y-m-d\TH:i');

        // Exibe o formulário de edição de carona
        return view('motorista.caronas.edit', compact('carona'));
    }

    public function update(Request $request, Carona $carona)
    {
        // Valida e atualiza a carona
        $validatedData = $request->validate([
            'origem' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'data_hora' => 'required|date',
            'valor' => 'nullable|numeric',
            'veiculo' => 'required|string|max:255',
            'placa' => 'required|string|max:255',
        ]);

        $carona->update($validatedData);

        return redirect()->route('caronas.index')->with('success', 'Carona atualizada com sucesso!');
    }

    public function destroy(Carona $carona)
    {
        // Exclui a carona
        $carona->delete();

        return redirect()->route('caronas.index')->with('success', 'Carona excluída com sucesso!');
    }

    public function showReservas($caronaId) 
    {
        $carona = Carona::query()->where('id', $caronaId)->first();

        $reservas = Reserva::where('carona_id', $carona['id'])->where('status', 'pendente')->get();
        
        return view('motorista.caronas.reservas')->with([
            'reservas' => $reservas,
            'carona' => $carona,
        ]);
    }

    public function aceitarReserva($reservaId)
    {
        try {
            $reserva = Reserva::where('id', $reservaId)->first();
            $carona = Carona::where('id', $reserva['carona_id'])->first();

            $vagas = $carona['vagas'];

            if($reserva['vagas'] < $vagas || $vagas <= 0) {
                return redirect()->back()->with('error', 'Carona com vagas insuficientes.');
            }

            $reserva->update([
                'status' => 'aceita',
            ]);
    
            $reserva->save();

            if($reserva['status'] == 'aceita') {
                $carona->update(['vagas' => $vagas - $reserva['vagas']]);
                $carona->save();
            }

            return redirect()->back()->with('success', 'Carona aceita com sucesso.');
        } catch(Exception $e) {
            return redirect()->back()->with('error', 'Não foi possivel aceitar essa carona, tente novamente. / Erro: ' . $e->getMessage());
        }
    }

    public function recusarReserva($reservaId)
    {
        try {
            $reserva = Reserva::where('id', $reservaId)->first();

            $carona = Carona::where('id', $reserva['carona_id'])->first();

            $reserva->update([
                'status' => 'rejeitada',
            ]);
    
            $reserva->save();

            return redirect()->back()->with('success', 'Carona rejeitada com sucesso.');
        } catch(Exception $e) {
            return redirect()->back()->with('error', 'Não foi possivel rejeitar essa carona, tente novamente. / Erro: ' . $e->getMessage());
        }
    }
}
