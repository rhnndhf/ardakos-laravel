<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landlord_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->enum('status', ['AKTIF', 'NONAKTIF'])->default('AKTIF');
            $table->string('phone', 20)->nullable();
            $table->string('ktp_url', 500)->nullable();
            $table->date('check_in_date')->nullable();
            $table->date('check_out_date')->nullable();
            $table->timestamps();

            $table->index('landlord_id');
            $table->index('room_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
