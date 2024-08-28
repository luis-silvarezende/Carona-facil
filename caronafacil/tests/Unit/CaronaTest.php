<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Carona;
use App\Models\Reserva;
use App\Models\Motorista;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CaronaTest extends TestCase
{
    use RefreshDatabase;
    
    protected $motorista;

    protected function setUp(): void
    {
        parent::setUp();

        // Cria um usuário motorista e autentica
        $this->motorista = Motorista::factory()->create();
        $this->actingAs($this->motorista, 'motorista');
    }

    public function test_index_displays_all_caronas()
    {
        $caronas = Carona::factory()->count(3)->create(['motorista_id' => $this->motorista->id]);

        $response = $this->get(route('caronas.index'));

        $response->assertStatus(200);
        $response->assertViewIs('motorista.caronas.index');
        $response->assertViewHas('caronas', function($viewCaronas) use ($caronas) {
            return $viewCaronas->count() === $caronas->count();
        });
    }

    public function test_create_displays_create_form()
    {
        $response = $this->get(route('caronas.create'));

        $response->assertStatus(200);
        $response->assertViewIs('motorista.caronas.create');
    }

    public function test_store_creates_carona_and_redirects()
    {
        $this->withoutMiddleware(); // Desabilita o middleware de verificação CSRF

        $data = [
            'origem' => 'Origem Teste',
            'destino' => 'Destino Teste',
            'data_hora' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'valor' => 50.0,
            'vagas' => 3,
            'veiculo' => 'Veículo Teste',
            'placa' => 'ABC1234',
        ];

        $response = $this->post(route('caronas.store'), $data);

        $response->assertRedirect(route('caronas.index'));
        $this->assertDatabaseHas('caronas', [
            'origem' => 'Origem Teste',
            'motorista_id' => $this->motorista->id,
        ]);
    }

    public function test_edit_displays_edit_form()
    {
        $carona = Carona::factory()->create(['motorista_id' => $this->motorista->id]);

        $response = $this->get(route('caronas.edit', $carona));

        $response->assertStatus(200);
        $response->assertViewIs('motorista.caronas.edit');
        $response->assertViewHas('carona', $carona);
    }
  
    public function test_show_reservas_displays_reservas_for_carona()
    {
        $this->withoutMiddleware(); // Desabilita o middleware de verificação CSRF

        $carona = Carona::factory()->create(['motorista_id' => $this->motorista->id]);
        $reservas = Reserva::factory()->count(2)->create(['carona_id' => $carona->id, 'status' => 'pendente']);

        $response = $this->get(route('caronas.reservas', $carona->id));

        $response->assertStatus(200);
        $response->assertViewIs('motorista.caronas.reservas');
        $response->assertViewHas('reservas', $reservas);
    }

    public function test_recusar_reserva_updates_reserva_status_to_rejeitada()
    {
        $this->withoutMiddleware(); // Desabilita o middleware de verificação CSRF
    
        $carona = Carona::factory()->create(['motorista_id' => $this->motorista->id]);
        $reserva = Reserva::factory()->create(['carona_id' => $carona->id, 'status' => 'pendente']);
    
        // Corrigir o nome da rota no teste para corresponder ao nome definido na rota
        $response = $this->put(route('caronas.reservas.recusar', $reserva->id));
    
        $response->assertRedirect();
        $this->assertDatabaseHas('reservas', ['id' => $reserva->id, 'status' => 'rejeitada']);
    }
    
}
