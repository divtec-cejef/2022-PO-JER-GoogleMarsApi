<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadgesTable extends Migration
{

    public function up()
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100);
            $table->integer('prix');
            $table->foreignId('section_id')->constrained('sections');
        });

    }

    public function down()
    {
        Schema::dropIfExists('badges');
    }
}
