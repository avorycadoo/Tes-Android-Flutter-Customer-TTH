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
        Schema::create('dbo.customer', function (Blueprint $table) {
            $table->string('CustID', 50)->primary();
            $table->string('Name', 255);
            $table->text('Address');
            $table->string('BranchCode', 10);
            $table->string('PhoneNo', 20);
            
            // Index for faster queries
            $table->index('BranchCode');
            $table->index('Name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbo.customer');
    }
};
