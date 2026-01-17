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
    Schema::create('claims', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
        $table->foreignId('item_id')->constrained()->onDelete('cascade'); 
        
        $table->string('claimer_name');  
        $table->string('claimer_nim');
        $table->string('claimer_email');
        $table->string('claimer_phone'); 
        $table->text('claim_description'); 
        $table->string('claim_proof')->nullable(); 
        
        // Status Klaim: pending (menunggu), verified (disetujui admin), rejected (ditolak)
        $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
