<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landlord_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tenant_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('transaction_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('payment_method_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('payment_type', ['Registration', 'Monthly Rent', 'Parking Fee', 'Deposit', 'Penalty', 'Other']);
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('IDR');
            $table->enum('status', ['Pending', 'Processing', 'Completed', 'Failed', 'Refunded', 'Cancelled'])->default('Pending');
            $table->string('gateway_transaction_id')->nullable();
            $table->text('gateway_payment_url')->nullable();
            $table->text('qr_code_url')->nullable();
            $table->string('payment_proof_url', 500)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->json('metadata')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('landlord_id');
            $table->index('tenant_id');
            $table->index('status');
            $table->index('gateway_transaction_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
