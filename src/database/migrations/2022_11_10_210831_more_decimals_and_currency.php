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
        if (!Schema::hasTable('currencies')) {
            Schema::create('currencies', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->char('code', 5);
                $table->char('symbol', 5);
            });

            //Default Currency
            DB::table('currencies')->insert([
                'name' => 'Default Currency',
                'symbol' => '$',
                'code' => 'DEF'
            ]);
        }

        if (Schema::hasTable('wallets')) {
            if (Schema::hasColumn('wallets', 'balance')) {
                Schema::table('wallets', function (Blueprint $table) {
                    $table->decimal('balance', 17, 8)->default(0)->change();
                });
            }

            if (! Schema::hasColumn('wallets', 'currency')) {
                Schema::table('wallets', function (Blueprint $table) {
                    $table->unsignedBigInteger('currency_id')->default(1);
                    $table->foreign('currency_id')->references('id')->on('currencies');
                });
            }
        }

        if (Schema::hasTable('expenses')) {
            if (Schema::hasColumn('expenses', 'amount')) {
                Schema::table('expenses', function (Blueprint $table) {
                    $table->decimal('amount', 17, 8)->default(0)->change();
                    $table->unsignedBigInteger('currency_id')->default(1);
                    $table->foreign('currency_id')->references('id')->on('currencies');
                });

            }
        }

        if (Schema::hasTable('incomes')) {
            if (Schema::hasColumn('incomes', 'amount')) {
                Schema::table('incomes', function (Blueprint $table) {
                    $table->decimal('amount', 17, 8)->default(0)->change();
                    $table->unsignedBigInteger('currency_id')->default(1);
                    $table->foreign('currency_id')->references('id')->on('currencies');
                });
            }
        }

        if (Schema::hasTable('recurrent_expense')) {
            if (Schema::hasColumn('recurrent_expense', 'amount')) {
                Schema::table('recurrent_expense', function (Blueprint $table) {
                    $table->decimal('amount', 17, 8)->default(0)->change();
                    $table->unsignedBigInteger('currency_id')->default(1);
                    $table->foreign('currency_id')->references('id')->on('currencies');
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
        //
    }
};
