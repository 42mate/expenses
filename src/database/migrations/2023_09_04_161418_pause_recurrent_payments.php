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
        if (!Schema::hasColumn('recurrent_expense', 'paused')) {
            Schema::table('recurrent_expense', function (Blueprint $table) {
                $table->boolean('paused')->default(false);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('recurrent_expense', 'paused')) {
            Schema::table('recurrent_expense', function (Blueprint $table) {
                $table->dropColumn(['paused']);
            });
        }
    }
};