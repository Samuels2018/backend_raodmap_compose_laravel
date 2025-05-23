<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up(): void {
    Schema::create('exercises', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->text('description')->nullable();
      $table->enum('category', ['cardio', 'strength', 'flexibility']);
      $table->string('muscle_group');
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('exercises');
  }
};
