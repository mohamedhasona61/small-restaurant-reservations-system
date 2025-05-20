<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('waiting_lists', function (Blueprint $table) {
            $table->foreignId('table_id')
                ->nullable()
                ->constrained('tables')
                ->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::table('waiting_lists', function (Blueprint $table) {
            if (Schema::hasColumn('waiting_lists', 'table_id')) {
                $table->dropForeign(['table_id']);
                $table->dropColumn('table_id');
            }
        });
    }
};
