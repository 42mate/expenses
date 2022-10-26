<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WalletTagsIncome extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2);
            $table->timestamp('date');
            $table->longText('description');
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('wallet_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('wallet_id')->references('id')->on('wallets');
        });

        Schema::create('expense_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('expense_id');
            $table->unsignedBigInteger('tag_id');
            $table->foreign('expense_id')->references('id')->on('expenses');
            $table->foreign('tag_id')->references('id')->on('tags');
        });

        Schema::create('income_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('income_id');
            $table->unsignedBigInteger('tag_id');
            $table->foreign('income_id')->references('id')->on('incomes');
            $table->foreign('tag_id')->references('id')->on('tags');
        });

        if (Schema::hasTable('expenses')) {
            if (! Schema::hasColumn('expenses', 'wallet_id')) {
                Schema::table('expenses', function (Blueprint $table) {
                    $table->unsignedBigInteger('wallet_id')->nullable();
                });
            }
        }

        if (Schema::hasTable('expenses')) {
            if (Schema::hasColumn('expenses', 'wallet_id')) {
                Schema::table('expenses', function (Blueprint $table) {
                    $table->foreign('wallet_id')->references('id')->on('wallets');
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
        if (Schema::hasColumn('expenses', 'wallet_id')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->dropForeign('expenses_wallet_id_foreign');
                $table->dropColumn('wallet_id');
            });
        }

        Schema::dropIfExists('income_tags');
        Schema::dropIfExists('expense_tags');
        Schema::dropIfExists('incomes');
        Schema::dropIfExists('wallets');
        Schema::dropIfExists('tags');
    }
}
