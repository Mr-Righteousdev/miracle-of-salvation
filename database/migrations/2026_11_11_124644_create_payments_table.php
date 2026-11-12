<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_type_id')->constrained()->restrictOnDelete();
            $table->foreignId('prayer_request_id')->nullable()->constrained()->nullOnDelete();
            $table->string('method');
            $table->unsignedBigInteger('amount');
            $table->string('currency', 3)->default('UGX');
            $table->string('payer_name')->nullable();
            $table->string('phone')->nullable();
            $table->text('note')->nullable();
            $table->string('status')->default('pending');
            $table->string('provider_reference')->nullable()->unique();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
