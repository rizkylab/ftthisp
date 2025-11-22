<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fault_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('technician_id')->constrained('users');
            $table->json('location');
            $table->string('cause');
            $table->string('photo_path')->nullable();
            $table->enum('status', ['open', 'in_progress', 'resolved'])->default('open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fault_logs');
    }
};
