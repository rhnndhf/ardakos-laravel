<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landlord_id')->constrained()->cascadeOnDelete();
            $table->string('room_number', 10);
            $table->string('floor', 10)->nullable();
            $table->decimal('base_price', 10, 2)->default(0);
            $table->enum('room_type', ['Putra', 'Putri', 'Campur', 'Kosong'])->default('Kosong');
            $table->enum('occupancy_status', ['Terisi', 'Tersedia'])->default('Tersedia');
            $table->integer('active_occupants')->default(0);
            $table->text('facilities')->nullable();
            $table->text('condition_notes')->nullable();
            $table->timestamps();

            $table->unique(['landlord_id', 'room_number']);
            $table->index('landlord_id');
            $table->index('occupancy_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
