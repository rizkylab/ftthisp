<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fiber_cables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('core_count'); // 4, 8, 12, 24
            $table->string('color')->default('#000000');
            $table->json('coordinates'); // Array of {lat, lng} for polyline
            $table->enum('status', ['normal', 'degraded', 'cut'])->default('normal');
            $table->float('length_meters')->default(0);
            $table->float('total_loss_db')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fiber_cables');
    }
};
