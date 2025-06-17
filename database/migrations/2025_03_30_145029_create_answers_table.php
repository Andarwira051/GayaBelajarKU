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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained()->onDelete('cascade'); // Tes yang dijawab
            $table->foreignId('question_id')->constrained()->onDelete('cascade'); // Soal yang dijawab
            $table->integer('score'); // Nilai jawaban (1 atau 0, bisa dibalik jika unfavoritable)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
