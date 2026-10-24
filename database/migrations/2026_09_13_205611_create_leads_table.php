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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone')->index();
            $table->string('gender', 10)->nullable()->index();
            $table->date('inquired_at');
            $table->string('interested_in')->nullable();
            $table->string('source')->nullable();
            $table->text('notes')->nullable();
            $table->date('follow_up_at')->nullable()->index();
            $table->string('status')->default('new')->index();
            $table->date('last_contacted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
