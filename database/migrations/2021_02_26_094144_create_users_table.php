<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 30);
            $table->string('last_name', 30);
            $table->string('username', 30)->unique();
            $table->string('email')->unique();
            $table->boolean('is_admin')->default(0);
            $table->longText('website')->nullable();
            $table->string('password');
            $table->ipAddress('ip_adress')->default("1.1.1.1");
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
