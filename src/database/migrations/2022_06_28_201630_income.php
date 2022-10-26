<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * This updates includes.
     *
     * - Default category and wallet in incomes
     * - Deletes tags tables since tags is a removed feature.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('incomes', 'category_id')) {
            Schema::table('incomes', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
                $table->dropForeign(['wallet_id']);
            });

            Schema::table('incomes', function (Blueprint $table) {
                //We need this to avoid changes in the date on updates
                // see: https://stackoverflow.com/a/61379469
                $table->timestamp('date')->nullable()->change();

                //This will allow null on categories
                $table->unsignedBigInteger('category_id')->nullable()->change();
                $table->unsignedBigInteger('wallet_id')->nullable()->change();

                $table->foreign('category_id')
                    ->references('id')
                    ->on('categories')
                    ->nullOnDelete()
                    ->cascadeOnUpdate();

                $table->foreign('wallet_id')
                    ->references('id')
                    ->on('wallets')
                    ->nullOnDelete()
                    ->cascadeOnUpdate();
            });

            Schema::dropIfExists('income_tags');
            Schema::dropIfExists('expense_tags');
            Schema::dropIfExists('tags');
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
