<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('jobs')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('gender')->nullable();
            $table->integer('age')->nullable();
            $table->bigInteger('no_telp')->nullable();
            $table->string('parents_name')->nullable();
            $table->bigInteger('parents_no_telp')->nullable();
            $table->string('photo')->nullable();
            $table->enum('status',['active','not_active'])->default('not_active');
            $table->string('code_activate')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
};
