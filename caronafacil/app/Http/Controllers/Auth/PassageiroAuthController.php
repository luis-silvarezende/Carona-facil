<?php

namespace App\Http\Controllers\Auth;

use App\Models\Passageiro;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PassageiroAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('passageiros.register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:passageiros',
            'password' => 'required|string|min:8|confirmed',
            'telefone' => 'required|string|max:15',
        ]);

        $passageiro = Passageiro::create([
            'nome' => $validatedData['nome'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'telefone' => $validatedData['telefone'],
        ]);

        Auth::guard('passageiro')->login($passageiro);

        return redirect()->route('passageiro.login');
    }

    public function showLoginForm()
    {
        return view('passageiros.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('passageiro')->attempt($credentials)) {
            return redirect()->route('reservas.index');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não coincidem com nossos registros.',
        ]);
    }

    public function logout()
    {
        Auth::guard('passageiro')->logout();

        return redirect('/passageiro/login');
    }
}
