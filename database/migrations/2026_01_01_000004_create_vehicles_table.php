<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landlord_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->string('plate_number', 20);
            $table->enum('vehicle_type', ['Motor', 'Mobil']);
            $table->enum('user_type', ['Penghuni Arda Kos', 'Non Penghuni'])->default('Penghuni Arda Kos');
            $table->enum('status', ['AKTIF', 'NONAKTIF'])->default('AKTIF');
            $table->string('stnk_url', 500)->nullable();
            $table->string('last_payment_period', 7)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['landlord_id', 'plate_number']);
            $table->index('landlord_id');
            $table->index('room_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
