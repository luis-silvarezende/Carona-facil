<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVeiculoAndPlacaToCaronasTable extends Migration
{
    public function up()
    {
        Schema::table('caronas', function (Blueprint $table) {
            $table->string('veiculo')->nullable();
            $table->string('placa')->nullable();
        });
    }

    public function down()
    {
        Schema::table('caronas', function (Blueprint $table) {
            $table->dropColumn('veiculo');
            $table->dropColumn('placa');
        });
    }
}

