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
        if (!Schema::hasColumn('users', 'default_currency_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('default_currency_id')->default(1);
                $table->foreign('default_currency_id')->references('id')->on('currencies');
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
        if (Schema::hasColumn('users', 'default_currency_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['default_currency_id']);
                $table->dropColumn(['default_currency_id']);
            });
        }
    }
};
