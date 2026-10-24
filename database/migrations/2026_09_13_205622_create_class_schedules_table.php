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
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gym_class_id')->constrained()->cascadeOnDelete();
            $table->foreignId('coach_id')->nullable()->constrained()->nullOnDelete();
            $table->string('day_of_week', 10);
            $table->time('starts_at');
            $table->time('ends_at');
            $table->string('location')->nullable();
            $table->index(['gym_class_id', 'day_of_week']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
    }
};
