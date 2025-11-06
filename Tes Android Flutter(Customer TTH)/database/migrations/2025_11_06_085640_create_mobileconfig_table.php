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
        Schema::create('dbo.mobileconfig', function (Blueprint $table) {
            $table->id('ID');
            $table->string('BranchCode', 10);
            $table->string('Name', 255);
            $table->text('Description')->nullable();
            $table->text('Value')->nullable();
            
            // Index
            $table->index('BranchCode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbo.mobileconfig');
    }
};