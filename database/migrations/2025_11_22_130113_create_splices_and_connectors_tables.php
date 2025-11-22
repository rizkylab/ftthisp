<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('splices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiber_cable_id')->constrained('fiber_cables')->onDelete('cascade');
            $table->json('location')->nullable();
            $table->float('loss_value')->default(0.1);
            $table->timestamps();
        });

        Schema::create('connectors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiber_cable_id')->constrained('fiber_cables')->onDelete('cascade');
            $table->json('location')->nullable();
            $table->float('loss_value')->default(0.5);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('connectors');
        Schema::dropIfExists('splices');
    }
};
