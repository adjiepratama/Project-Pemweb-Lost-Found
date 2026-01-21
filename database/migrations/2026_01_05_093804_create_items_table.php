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
    Schema::create('items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('title');
        $table->text('description');
        $table->string('category');
        $table->string('location');
        $table->date('date_event');
        
        $table->enum('status', [
            'pending', 'available', 'rejected', 'returned', 'donated'
        ])->default('pending'); 

        $table->string('image')->nullable();
        
        // --- TAMBAHKAN BARIS INI ---
        // Kolom ini akan menyimpan kode biner gambar (contoh: 101011001...)
        $table->string('image_hash')->nullable(); 
        // ---------------------------

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};