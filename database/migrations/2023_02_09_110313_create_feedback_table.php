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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id('feedback_id');
            $table->text('review')->nullable();
            $table->decimal('rating', 2, 1)->dafault(5.0);
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('breakdown_id');
            $table->unsignedBigInteger('sp_id');
            $table->foreign('client_id')->references('client_id')->on('clients');
            $table->foreign('breakdown_id')->references('breakdown_id')->on('breakdowns');
            $table->foreign('sp_id')->references('sp_id')->on('service_provider')->onDelete('cascade');
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
        Schema::dropIfExists('feedback');
    }
};