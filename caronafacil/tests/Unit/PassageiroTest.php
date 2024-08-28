<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Passageiro;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PassageiroTest extends TestCase
{
    use RefreshDatabase;

    //Verifica se o formulário de registro é exibido corretamente.

    public function test_show_register_form()
    {
        $response = $this->get(route('passageiro.register'));

        $response->assertStatus(200);
        $response->assertViewIs('passageiros.register');
    }

    //Testa o processo de registro, certificando-se de que um novo Passageiro é criado no banco de dados e que o usuário é autenticado.

    public function test_register_creates_passageiro_and_logs_in()
    {
        $this->withoutMiddleware();  // Desabilita o middleware de verificação CSRF
    
        $data = [
            'nome' => 'Teste Passageiro',
            'email' => 'teste@exemplo.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'telefone' => '1234567890',
        ];
    
        $response = $this->post(route('passageiro.register'), $data);
    
        $response->assertRedirect(route('passageiro.login'));
    
        $this->assertDatabaseHas('passageiros', [
            'email' => 'teste@exemplo.com',
        ]);
    
        $this->assertTrue(Auth::guard('passageiro')->check());
    }
    

    //Verifica se o formulário de login é exibido corretamente.

    public function test_show_login_form()
    {
        $response = $this->get(route('passageiro.login'));

        $response->assertStatus(200);
        $response->assertViewIs('passageiros.login');
    }

    //Testa o processo de login, verificando se o Passageiro é autenticado e redirecionado corretamente.

    public function test_login_authenticates_and_redirects()
    {
        $this->withoutMiddleware();  // Desabilita o middleware de verificação CSRF

        $passageiro = Passageiro::factory()->create([
            'password' => Hash::make('password123')
        ]);
    
        $response = $this->post(route('passageiro.login'), [
            'email' => $passageiro->email,
            'password' => 'password123',
        ]);
    
        $response->assertRedirect(route('reservas.index'));
        $this->assertTrue(Auth::guard('passageiro')->check());
    }
    
}
