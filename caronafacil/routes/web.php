<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MotoristaAuthController;
use App\Http\Controllers\Auth\PassageiroAuthController;
use App\Http\Controllers\CaronaController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Rotas para Motorista
Route::prefix('motorista')->group(function () {
    // Rotas públicas para login, registro e logout
    Route::get('login', [MotoristaAuthController::class, 'showLoginForm'])->name('motorista.login');
    Route::post('login', [MotoristaAuthController::class, 'login']);
    Route::get('register', [MotoristaAuthController::class, 'showRegisterForm'])->name('motorista.register');
    Route::post('register', [MotoristaAuthController::class, 'register']);
    Route::get('logout', [MotoristaAuthController::class, 'logout'])->name('motorista.logout');

    // Rotas protegidas para motoristas autenticados
    Route::middleware(['auth:motorista'])->group(function () {
        Route::get('/home', function () {
            return view('motorista.home');
        })->name('motorista.home');

        Route::resource('caronas', CaronaController::class);
    });
});

Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Rotas para Passageiro
Route::prefix('passageiro')->group(function () {
    Route::get('login', [PassageiroAuthController::class, 'showLoginForm'])->name('passageiro.login');
    Route::post('login', [PassageiroAuthController::class, 'login']);
    Route::get('register', [PassageiroAuthController::class, 'showRegisterForm'])->name('passageiro.register');
    Route::post('register', [PassageiroAuthController::class, 'register']);
    Route::get('logout', [PassageiroAuthController::class, 'logout'])->name('passageiro.logout');

    // Rotas protegidas para passageiros autenticados
    Route::middleware(['auth:passageiro'])->group(function () {
        Route::resource('reservas', ReservaController::class);
        // Adicione outras rotas protegidas para passageiros aqui
    });
});

Route::middleware(['auth:motorista'])->group(function () {
    // Rotas de Carona
    Route::get('/motorista/caronas', [CaronaController::class, 'index'])->name('caronas.index');
    Route::get('/motorista/caronas/create', [CaronaController::class, 'create'])->name('caronas.create');
    Route::post('/motorista/caronas', [CaronaController::class, 'store'])->name('caronas.store');
    Route::get('/motorista/caronas/{carona}', [CaronaController::class, 'show'])->name('caronas.show');
    Route::get('/motorista/caronas/{carona}/reservas/', [CaronaController::class, 'showReservas'])->name('caronas.reservas');
    Route::put('/motorista/caronas/{reserva}/reservas/aceitar', [CaronaController::class, 'aceitarReserva'])->name('caronas.reservas.aceitar');
    Route::put('/motorista/caronas/{carona}/reservas/recusar', [CaronaController::class, 'recusarReserva'])->name('caronas.reservas.recusar');
    Route::get('/motorista/caronas/{carona}/edit', [CaronaController::class, 'edit'])->name('caronas.edit');
    Route::put('/motorista/caronas/{carona}', [CaronaController::class, 'update'])->name('caronas.update');
    Route::delete('/motorista/caronas/{carona}', [CaronaController::class, 'destroy'])->name('caronas.destroy');
});

Route::middleware(['auth:passageiro'])->group(function () {
    // Rotas de Reserva
    Route::get('/passageiro/reservas', [ReservaController::class, 'index'])->name('reservas.index');
    Route::post('/passageiro/reservas', [ReservaController::class, 'store'])->name('reservas.store');
    Route::get('/passageiro/reservas/{reserva}', [ReservaController::class, 'show'])->name('reservas.show');
    Route::delete('/passageiro/reservas/{reserva}', [ReservaController::class, 'destroy'])->name('reservas.destroy');
});
// Qualquer outra rota pode ser adicionada aqui
