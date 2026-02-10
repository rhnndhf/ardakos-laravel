<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landlord_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('tenant_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('transaction_type', ['registration', 'monthly_payment', 'parking_fee', 'checkout']);
            $table->string('period', 7)->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->text('description')->nullable();
            $table->string('payment_proof_url', 500)->nullable();
            $table->string('actor_email')->nullable();
            $table->timestamps();

            $table->index('landlord_id');
            $table->index('period');
            $table->index('transaction_type');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
