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
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->decimal('cost', 10,2);
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('breakdown_id')->nullable();
            $table->foreign('provider_id')->references('sp_id')->on('service_provider');
            $table->foreign('client_id')->references('client_id')->on('clients');
            $table->foreign('breakdown_id')->references('breakdown_id')->on('breakdowns');
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
        Schema::dropIfExists('diagnoses');
    }
};