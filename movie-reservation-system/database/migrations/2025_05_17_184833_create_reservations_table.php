<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('reservations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->foreignId('showtime_id')->constrained()->onDelete('cascade');
      $table->foreignId('seat_id')->constrained()->onDelete('cascade');
      $table->string('reservation_code')->unique();
      $table->decimal('price', 8, 2);
      $table->enum('status', ['confirmed', 'cancelled'])->default('confirmed');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('reservations');
  }
};
