<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Motorista;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MotoristaTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Testa o formulário de registro de motorista.
     */
    public function test_register_motorista()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/motorista/register')
                    ->type('nome', 'Teste Motorista')
                    ->type('email', 'teste@exemplo.com')
                    ->type('password', 'password123')
                    ->type('password_confirmation', 'password123')
                    ->type('telefone', '1234567890')
                    ->type('cnh', '12345678901234567890')
                    ->press('Cadastrar')
                    ->assertPathIs('/motorista/login') // Verifica se foi redirecionado para a página de login
                    ->assertSee('Cadastro realizado com sucesso! Faça login para continuar.');
        });
    }

    /**
     * Testa o login de um motorista.
     */
    public function test_login_motorista()
    {
        // Cria um motorista para o teste de login
        $motorista = Motorista::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $this->browse(function (Browser $browser) use ($motorista) {
            $browser->visit('/motorista/login')
                    ->type('email', $motorista->email)
                    ->type('password', 'password123')
                    ->press('Entrar')
                    ->assertPathIs('/motorista/caronas') // Verifica se foi redirecionado para a página de caronas
                    ->assertAuthenticatedAs($motorista, 'motorista'); // Verifica se o motorista está autenticado
        });
    }
}
