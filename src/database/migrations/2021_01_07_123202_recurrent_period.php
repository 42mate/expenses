<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\RecurrentExpense;

class RecurrentPeriod extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('recurrent_expense')) {
            if (!Schema::hasColumn('recurrent_expense', 'period')) {
                Schema::table('recurrent_expense', function (Blueprint $table) {
                    $table->integer('period')
                        ->default(RecurrentExpense::PERIOD_MONTHLY);
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
            if (Schema::hasColumn('recurrent_expense', 'period')) {
                Schema::table('recurrent_expense', function (Blueprint $table) {
                    $table->dropColumn('period');
                });
            }
        }
    }
}
