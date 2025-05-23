<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('workout_logs', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->foreignId('workout_id')->constrained()->onDelete('cascade');
      $table->dateTime('completed_at');
      $table->text('notes')->nullable();
      $table->integer('duration_minutes')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('workout_logs');
  }
};
