<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_access_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landlord_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lock_id')->constrained('room_locks')->cascadeOnDelete();
            $table->string('access_type', 50); // PIN, Card, Fingerprint, App
            $table->string('user_identifier')->nullable(); // Who accessed it
            $table->boolean('is_success')->default(true);
            $table->string('failure_reason')->nullable();
            $table->timestamp('accessed_at')->useCurrent();
            $table->json('metadata')->nullable();

            $table->index('landlord_id');
            $table->index('room_id');
            $table->index('accessed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_access_logs');
    }
};
