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
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wo_profile_id')->constrained('wo_profiles')->onDelete('cascade');
            $table->string('name');
            $table->text('address')->nullable();
            $table->integer('capacity')->nullable();
            $table->text('facilities')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->string('contact_phone')->nullable();
            $table->json('images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
