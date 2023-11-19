<?php

use App\Enums\TransactionStatus;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10)->default(0);
            $table->decimal('vat_amount')->default(0);
            $table->decimal('total_paid_amount', 10)->default(0);
            $table->foreignId('payer_id')
                ->references('id')
                ->on('users');
            $table->date('due_on');
            $table->boolean('is_vat_inclusive')
                ->default(false);
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
