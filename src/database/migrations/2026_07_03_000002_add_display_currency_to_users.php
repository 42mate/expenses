<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'display_currency_id')) {
            Schema::table('users', function (Blueprint $table) {
                // Presentation-only: the currency every amount is converted to for
                // this user. Separate from default_currency_id (which rewrites
                // transaction data when changed). Nullable => falls back to
                // default_currency_id, then USD.
                $table->unsignedBigInteger('display_currency_id')->nullable();
                $table->foreign('display_currency_id')->references('id')->on('currencies');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'display_currency_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['display_currency_id']);
                $table->dropColumn('display_currency_id');
            });
        }
    }
};
