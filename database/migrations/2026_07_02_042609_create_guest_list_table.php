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
        Schema::create('guest_list', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('wedding_projects')->onDelete('cascade');
            $table->string('name');
            $table->string('category')->comment('Keluarga Pria, Keluarga Wanita, Teman, Kolega, etc.');
            $table->enum('rsvp_status', ['pending', 'confirmed', 'declined'])->default('pending');
            $table->integer('guest_count')->default(1);
            $table->string('seat_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_list');
    }
};
