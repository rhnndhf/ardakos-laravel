<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landlord_id')->constrained()->cascadeOnDelete();
            $table->string('item_name');
            $table->enum('item_category', ['Furniture', 'Electronics', 'Bedding', 'Bathroom', 'Kitchen', 'Cleaning', 'Other']);
            $table->text('description')->nullable();
            $table->decimal('unit_cost', 10, 2)->default(0);
            $table->boolean('is_required')->default(false);
            $table->timestamps();

            $table->index('landlord_id');
            $table->index('item_category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
