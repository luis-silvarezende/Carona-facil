<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaronasTable extends Migration
{
    public function up()
    {
        Schema::create('caronas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motorista_id')->constrained('motoristas')->onDelete('cascade');
            $table->string('origem');
            $table->string('destino');
            $table->dateTime('data_hora');
            $table->decimal('valor', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('caronas');
    }
}

