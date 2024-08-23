<?php
namespace App\Http\Controllers\Auth;

use App\Models\Motorista;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MotoristaAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('motorista.register');
    }

    public function index()
    {
        return view('motorista.home');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:motoristas',
            'password' => 'required|string|min:8|confirmed',
            'telefone' => 'required|string|max:15',
            'cnh' => 'required|string|max:20|unique:motoristas',
        ]);

        $motorista = Motorista::create([
            'nome' => $validatedData['nome'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'telefone' => $validatedData['telefone'],
            'cnh' => $validatedData['cnh'],
        ]);
    
        // Redireciona para a tela de login após o registro
        return redirect()->route('motorista.login')->with('success', 'Cadastro realizado com sucesso! Faça login para continuar.');
    }
    

    public function showLoginForm()
    {
        return view('motorista.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('motorista')->attempt($credentials)) {
            return redirect()->intended('/motorista/caronas');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não coincidem com nossos registros.',
        ]);
    }

    public function logout()
    {
        dd('oi');
        Auth::logout();

        return redirect('/motorista/login');
    }
}


