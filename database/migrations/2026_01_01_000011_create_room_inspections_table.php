<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landlord_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tenant_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('inspection_type', ['Check-in', 'Check-out', 'Routine', 'Emergency']);
            $table->string('inspector_name')->nullable();
            $table->timestamp('inspection_date')->useCurrent();
            $table->enum('overall_condition', ['Excellent', 'Good', 'Fair', 'Poor'])->default('Good');
            $table->tinyInteger('cleanliness_score')->unsigned();
            $table->text('damage_notes')->nullable();
            $table->json('missing_items')->nullable();
            $table->json('damaged_items')->nullable();
            $table->decimal('replacement_cost', 10, 2)->default(0);
            $table->decimal('cleaning_cost', 10, 2)->default(0);
            $table->decimal('total_deduction', 10, 2)->default(0);
            $table->json('photos')->nullable();
            $table->string('signature_url', 500)->nullable();
            $table->enum('status', ['Draft', 'Completed', 'Approved', 'Disputed'])->default('Draft');
            $table->timestamps();

            $table->index('landlord_id');
            $table->index('room_id');
            $table->index('tenant_id');
            $table->index('inspection_type');
            $table->index('inspection_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_inspections');
    }
};
