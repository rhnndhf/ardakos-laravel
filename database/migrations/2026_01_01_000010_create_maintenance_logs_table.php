<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landlord_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('maintenance_type', ['Repair', 'Replacement', 'Cleaning', 'General Maintenance', 'Inspection']);
            $table->text('description');
            $table->decimal('cost', 10, 2)->default(0);
            $table->string('performed_by')->nullable();
            $table->timestamp('performed_at')->nullable();
            $table->enum('status', ['Pending', 'In Progress', 'Completed', 'Cancelled'])->default('Pending');
            $table->enum('priority', ['Low', 'Medium', 'High', 'Urgent'])->default('Medium');
            $table->text('notes')->nullable();
            $table->string('receipt_url', 500)->nullable();
            $table->timestamps();

            $table->index('landlord_id');
            $table->index('room_id');
            $table->index('status');
            $table->index('priority');
            $table->index('performed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_logs');
    }
};
