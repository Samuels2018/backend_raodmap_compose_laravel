<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('workout_exercises', function (Blueprint $table) {
      $table->id();
      $table->foreignId('workout_id')->constrained()->onDelete('cascade');
      $table->foreignId('exercise_id')->constrained()->onDelete('cascade');
      $table->integer('sets');
      $table->integer('repetitions');
      $table->decimal('weight', 8, 2)->nullable();
      $table->text('notes')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('workout_exercises');
  }
};
