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
        Schema::create('apps', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index()->comment('Name of the app');
            $table->string('slug')->unique()->index()->comment('Slug of the app');
            $table->string('url')->nullable()->comment('URL of the app');
            $table->string('icon')->nullable()->comment('Icon of the app');
            $table->string('description')->nullable()->comment('Description of the app');
            $table->string('key')->unique()->index()->comment('Key of the app');
            $table->string('privacy_policy_url')->nullable()->comment('Privacy policy URL of the app');
            $table->string('terms_and_conditions_url')->nullable()->comment('Terms and conditions URL of the app');
            $table->string('status')->default('active')->comment('Status of the app');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apps');
    }
};
