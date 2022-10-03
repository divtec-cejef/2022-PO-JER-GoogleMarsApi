<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bases', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 30)->unique();
            $table->integer('credit')->default(0);
            $table->integer('oxygene')->default(100);
            $table->integer('position_x')->default(0);
            $table->integer('position_y')->default(0);
            $table->integer('img_base')->default(1);
            $table->dateTime('date_fin')->nullable();
            $table->foreignId('user_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bases');
    }
}
