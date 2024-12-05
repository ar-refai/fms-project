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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->string('accounting_id');
            $table->enum('expense_type', [
                'Logistics',
                'Material Purchases',
                'Fabrication & Installation',
                'G&A',
                'Factory',
                'Other Expenses',
            ]);

            // Client name (Designation)
            $table->string('designation')->nullable();

            // Project name (Basis)
            $table->string('basis')->nullable();

            // Description, Unit, Unit Rate, Quantity, and other expense details
            $table->text('description')->nullable();
            $table->enum('unit', [
                'Set',
                'No',
                'Sheet',
                'SQM',
                'Roll',
                'Pack',
                'Ampula',
                'L.S',
                'Strip',
                'Box',
                'Cubic Meter',
                'K.G',
                '',
            ])->nullable();
            $table->decimal('unit_rate', 15, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('total_amount', 15, 2);
            $table->string('recipient');

            // Nullable foreign keys for client and project
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('set null');
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key constraints first
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropForeign(['project_id']);
        });

        // Drop the table
        Schema::dropIfExists('expenses');
    }
};
