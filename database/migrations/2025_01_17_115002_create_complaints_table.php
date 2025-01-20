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
        Schema::create('complaints', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->string('subject');
            $table->text('description');
            $table->string('category');
            $table->enum('priority', ['low', 'medium', 'high']);
            $table->enum('status', ['in_progress', 'pending', 'completed']);
            $table->foreignId('assigned_technician_id')->nullable()->constrained('users');
            $table->date('schedule')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
