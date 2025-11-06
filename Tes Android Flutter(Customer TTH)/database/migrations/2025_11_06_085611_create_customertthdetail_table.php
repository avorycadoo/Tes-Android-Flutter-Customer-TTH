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
        Schema::create('dbo.customertthdetail', function (Blueprint $table) {
            $table->id('ID');
            $table->string('TTHNo', 50);
            $table->string('TTOTTPNo', 50);
            $table->string('Jenis', 100);
            $table->integer('Qty');
            $table->string('Unit', 20);
            
            // Foreign key
            $table->foreign('TTHNo')
                  ->references('TTHNo')
                  ->on('dbo.customertth')
                  ->onDelete('cascade');
            
            // Index
            $table->index('TTHNo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbo.customertthdetail');
    }
};
