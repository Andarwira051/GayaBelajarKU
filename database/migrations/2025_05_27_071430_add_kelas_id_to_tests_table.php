<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('tests', function (Blueprint $table) {
            $table->foreignId('kelas_id')
                ->nullable()
                ->after('user_id')
                ->constrained('kelas')
                ->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::table('tests', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
        });
    }
};
