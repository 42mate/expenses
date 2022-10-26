<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecurrentExpenseAddLastUseDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('recurrent_expense')) {
            if (! Schema::hasColumn('recurrent_expense', 'last_use_date')) {
                Schema::table('recurrent_expense', function (Blueprint $table) {
                    $table->date('last_use_date')->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('recurrent_expense')) {
            if (Schema::hasColumn('recurrent_expense', 'last_use_date')) {
                Schema::table('recurrent_expense', function (Blueprint $table) {
                    $table->dropColumn('last_use_date');
                });
            }
        }
    }
}
