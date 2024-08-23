<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVagasToCaronasTable extends Migration
{
    public function up()
    {
        Schema::table('caronas', function (Blueprint $table) {
            $table->integer('vagas')->default(1)->min(0);
        });
    }

    public function down()
    {
        Schema::table('caronas', function (Blueprint $table) {
            $table->dropColumn('vagas');
        });
    }
}
