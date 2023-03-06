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
        Schema::create('fund_wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('paymentstatus');
            $table->string('transaction_reference')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('charged_amount')->nullable();
            $table->string('processor_response');
            $table->foreign('client_id')->references('client_id')->on('clients')->onDelete('cascade');
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
        Schema::dropIfExists('fund_wallets');
    }
};