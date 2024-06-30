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
        Schema::create('app_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_id')->constrained('apps')->onDelete('cascade')->comment('Foreign key to the apps table');
            $table->text('question')->nullable()->comment('Question for the policy');
            $table->text('answer')->nullable()->comment('Answer for the policy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_questions');
    }
};
