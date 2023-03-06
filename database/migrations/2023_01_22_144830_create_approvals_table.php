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
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->string('document');
            $table->boolean('address_confirmation');
            $table->boolean('plate_number')->nullable();
            $table->enum('status', ['pending', 'approved'])->default('pending');
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->foreign('provider_id')->references('sp_id')->on('service_provider');
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->foreign('agent_id')->references('agent_id')->on('agents');
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
        Schema::dropIfExists('approvals');
    }
};