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
            
            // --- BAGIAN ENUM YANG SUDAH DIPERBAIKI ---
            // Kita tambahkan 'pending' dan 'rejected' agar Admin Controller tidak error.
            // Default diubah ke 'pending' agar saat user lapor, statusnya menunggu admin dulu.
            $table->enum('status', [
                'pending',    // Menunggu Konfirmasi Admin
                'available',  // Disetujui Admin (Tayang)
                'rejected',   // Ditolak Admin
                'returned',   // Sudah dikembalikan
                'donated'     // Didonasikan
            ])->default('pending'); 
            // -----------------------------------------

            $table->string('image')->nullable();
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