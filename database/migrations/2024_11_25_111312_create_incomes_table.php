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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->string('accounting_id');
            $table->date('date');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade'); // Foreign key to projects table by id
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade'); // Foreign key to clients table by id
            $table->enum('instalment_type', [
                'Instalment',
                'Down-Payment',
                'Finalization Invoice',
                'Upfront',
                'Single-Payment'
            ]);
            $table->string('basis'); // Holds the name of the project (descriptive)
            $table->string('designation'); // Holds the name of the client (descriptive)
            $table->decimal('total_amount', 15, 2); // Total amount with precision
            $table->string('collection_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
