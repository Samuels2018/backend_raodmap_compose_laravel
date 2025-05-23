<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('workouts', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->string('title');
      $table->text('description')->nullable();
      $table->dateTime('scheduled_at');
      $table->boolean('completed')->default(false);
      $table->text('comments')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('workouts');
  }
};
