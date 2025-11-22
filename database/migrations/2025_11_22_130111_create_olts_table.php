<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('olts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->nullable(); // Brand/Model
            $table->json('coordinates'); // {lat: ..., lng: ...}
            $table->integer('total_ports')->default(0);
            $table->integer('used_ports')->default(0);
            $table->enum('status', ['active', 'maintenance', 'down'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('olts');
    }
};
