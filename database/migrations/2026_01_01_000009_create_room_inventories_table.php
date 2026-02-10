<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landlord_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->foreignId('inventory_item_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->enum('condition_status', ['Excellent', 'Good', 'Fair', 'Poor', 'Missing', 'Damaged'])->default('Good');
            $table->text('notes')->nullable();
            $table->timestamp('last_checked_at')->nullable();
            $table->timestamps();

            $table->unique(['room_id', 'inventory_item_id']);
            $table->index('landlord_id');
            $table->index('condition_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_inventories');
    }
};
