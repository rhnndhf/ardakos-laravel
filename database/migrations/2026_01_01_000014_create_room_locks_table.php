<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_locks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landlord_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->string('lock_id', 100)->nullable();
            $table->enum('lock_type', ['TTLock', 'Manual', 'Other'])->default('Manual');
            $table->string('lock_mac_address', 20)->nullable();
            $table->string('lock_alias')->nullable();
            $table->string('battery_level')->nullable();
            $table->boolean('is_online')->default(false);
            $table->enum('sync_status', ['Synced', 'Pending', 'Failed'])->default('Synced');
            $table->timestamp('last_synced_at')->nullable();
            $table->text('lock_data')->nullable(); // JSON configuration details
            $table->timestamps();

            $table->unique(['landlord_id', 'room_id']);
            $table->unique(['landlord_id', 'lock_id']);
            $table->index('landlord_id');
            $table->index('is_online');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_locks');
    }
};
