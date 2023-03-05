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
        Schema::create('service_provider', function (Blueprint $table) {
            $table->id('sp_id');
            $table->string('name');
            $table->foreignIdFor(\App\Models\User::class, 'user_id')->constrained()->onDelete('cascade');
            $table->string('phone_number')->unique();
            $table->string('state');
            $table->string('business_address');
            $table->decimal('latitude', 10,8);
            $table->decimal('longitude', 11,8);
            $table->enum('status', ['Pending', 'Approved'])->default('Pending');
            $table->string('lga');
            $table->string('gender');
            $table->string('plate_number')->default('null');
            $table->enum('type', ['Artisan', 'Cab Driver', 'Tow Truck']);
            $table->string('account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('profile_picture');
            $table->unsignedBigInteger('verified_by_agent')->nullable();
            $table->foreign('verified_by_agent')->references('agent_id')->on('agents');
            $table->rememberToken();
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
        Schema::dropIfExists('service_provider');
    }
};