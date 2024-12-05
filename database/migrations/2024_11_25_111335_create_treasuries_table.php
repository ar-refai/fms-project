<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up()
    {
        Schema::create('treasuries', function (Blueprint $table) {
            $table->id();
            $table->string('treasury_id')->unique();
            $table->dateTime('date');
            $table->decimal('starting_balance', 15, 2);
            $table->string('type');
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->decimal('ending_balance', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('treasuries');
    }
};
