<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('odps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('coordinates');
            $table->integer('capacity')->default(8);
            $table->integer('used_core')->default(0);
            $table->foreignId('olt_id')->constrained('olts')->onDelete('cascade');
            $table->enum('status', ['active', 'maintenance', 'down'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('odps');
    }
};
