<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landlord_id')->constrained()->cascadeOnDelete();
            $table->enum('gateway_type', ['Midtrans', 'Xendit', 'Manual', 'BankTransfer']);
            $table->string('gateway_name', 100);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->text('api_key')->nullable();
            $table->text('api_secret')->nullable();
            $table->string('merchant_id')->nullable();
            $table->text('webhook_secret')->nullable();
            $table->json('configuration')->nullable();
            $table->timestamps();

            $table->index('landlord_id');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
