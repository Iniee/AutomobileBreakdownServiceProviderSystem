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
        Schema::create('breakdowns', function (Blueprint $table) {
            $table->id('breakdown_id');
            $table->string('breakdown_location');
            $table->decimal('breakdown_latitude', 10,8);
            $table->decimal('breakdown_longitude', 11,8);
            $table->string('destination_location')->nullable();
            $table->decimal('destination_latitude', 10,8)->nullable();
            $table->decimal('destination_longitude', 11,8)->nullable();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('service_provider')->nullable();
            $table->foreign('client_id')->references('client_id')->on('clients');
            $table->foreign('service_provider')->references('sp_id')->on('service_provider');
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
        Schema::dropIfExists('breakdowns');
    }
};