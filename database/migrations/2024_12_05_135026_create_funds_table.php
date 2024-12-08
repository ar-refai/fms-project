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
        Schema::create('funds', function (Blueprint $table) {
            $table->id();
            $table->string('stakeholder'); // Stakeholder column
            $table->date('date'); // Date column
            $table->string('accounting_id'); // Accounting ID column
            $table->text('description')->nullable(); // Description column (nullable)
            $table->enum('transaction_type', ['to', 'from']); // Transaction Type column (either "to" or "from")
            $table->decimal('amount', 15, 2); // Amount column (with precision for currency)
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funds');
    }
};
