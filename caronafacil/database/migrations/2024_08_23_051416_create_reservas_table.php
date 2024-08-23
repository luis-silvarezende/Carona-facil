<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasTable extends Migration
{
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carona_id')->constrained('caronas')->onDelete('cascade');
            $table->foreignId('passageiro_id')->constrained('passageiros')->onDelete('cascade');
            $table->enum('status', ['pendente', 'aceita', 'rejeitada'])->default('pendente');
            $table->integer('vagas')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservas');
    }
}

