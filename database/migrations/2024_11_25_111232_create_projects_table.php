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
        Schema::create('projects', function (Blueprint $table) {
            // $table->engine = 'InnoDB';
            $table->id();
            $table->string('project_id')->unique(); // Unique Project Identifier
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade'); // Foreign Key to Clients
            $table->date('project_validation_date'); // Validation Date
            $table->string('project_name'); // Project name
            $table->string('project_description')->nullable(); // Project Description
            $table->decimal('contracted_revenue', 15, 2)->nullable(); // Contracted Revenue
            $table->decimal('accounts_receivables', 15, 2)->nullable(); // Accounts Receivables
            $table->decimal('collection_rate', 5, 2)->nullable(); // Collection Rate
            $table->decimal('supply_cost', 15, 2)->nullable(); // Supply Cost
            $table->decimal('apply_cost', 15, 2)->nullable(); // Apply Cost
            $table->decimal('logistics_cost', 15, 2)->nullable(); // Logistics Cost
            $table->decimal('gross_profit', 15, 2)->nullable(); // Gross Profit
            $table->decimal('gpm', 5, 2)->nullable(); // Gross Profit Margin (GPM)
            $table->enum('status', ['Pending', 'Completed', 'In Progress'])->default('Pending'); // Project Status
            $table->boolean('has_quotation')->default(false); // Indicates if the project has a quotation
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
