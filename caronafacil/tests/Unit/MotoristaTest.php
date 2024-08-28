<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Motorista;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MotoristaTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_register_form()
    {
        $response = $this->get(route('motorista.register'));

        $response->assertStatus(200);
        $response->assertViewIs('motorista.register');
    }

    public function test_register_creates_motorista_and_redirects_to_login()
    {
        $this->withoutMiddleware();  // Desabilita o middleware de verificação CSRF

        $data = [
            'nome' => 'Teste Motorista',
            'email' => 'teste@exemplo.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'telefone' => '1234567890',
            'cnh' => '12345678901234567890',
        ];

        $response = $this->post(route('motorista.register'), $data);

        $response->assertRedirect(route('motorista.login'));
        $response->assertSessionHas('success', 'Cadastro realizado com sucesso! Faça login para continuar.');

        $this->assertDatabaseHas('motoristas', [
            'email' => 'teste@exemplo.com',
        ]);
    }

    public function test_show_login_form()
    {
        $response = $this->get(route('motorista.login'));

        $response->assertStatus(200);
        $response->assertViewIs('motorista.login');
    }

    public function test_login_authenticates_and_redirects()
    {
        $this->withoutMiddleware();  // Desabilita o middleware de verificação CSRF

        $motorista = Motorista::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post(route('motorista.login'), [
            'email' => $motorista->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/motorista/caronas');
        $this->assertTrue(Auth::guard('motorista')->check());
    }
}
