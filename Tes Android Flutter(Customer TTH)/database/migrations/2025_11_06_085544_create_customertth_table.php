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
        Schema::create('dbo.customertth', function (Blueprint $table) {
            $table->string('TTHNo', 50)->primary();
            $table->string('SalesID', 50);
            $table->string('TTOTTPNo', 50);
            $table->string('CustID', 50);
            $table->dateTime('DocDate');
            $table->integer('Received')->default(0); // 0 = pending, 1 = received
            $table->dateTime('ReceivedDate')->nullable();
            $table->text('FailedReason')->nullable();
            
            // Foreign key
            $table->foreign('CustID')
                  ->references('CustID')
                  ->on('dbo.customer')
                  ->onDelete('restrict');
            
            // Indexes
            $table->index('CustID');
            $table->index('DocDate');
            $table->index('Received');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbo.customertth');
    }
};
