<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('customer_id_string')->unique();
            $table->json('coordinates');
            $table->foreignId('odp_id')->constrained('odps')->onDelete('cascade');
            $table->enum('status', ['online', 'offline', 'trouble'])->default('online');
            $table->float('signal_level_dbm')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
