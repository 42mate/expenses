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
        if (Schema::hasColumn('incomes', 'category_id')) {
            Schema::table('incomes', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
                $table->dropColumn(['category_id']);
            });
        }

        Schema::create('income_sources', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('incomes', function (Blueprint $table) {
            $table->unsignedBigInteger('income_source_id')
                ->nullable(true);

            $table->foreign('income_source_id')
                ->references('id')
                ->on('income_sources')
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('incomes', 'income_source_id')) {
            Schema::table('incomes', function (Blueprint $table) {
                $table->dropForeign(['income_source_id']);
                $table->dropColumn(['income_source_id']);
            });
        }

        Schema::dropIfExists('income_sources');

        if (! Schema::hasColumn('incomes', 'category_id')) {
            Schema::table('incomes', function (Blueprint $table) {
                $table->unsignedBigInteger('category_id')
                    ->nullable(true);
            });

            Schema::table('incomes', function (Blueprint $table) {
                $table->foreign('category_id')
                    ->references('id')
                    ->on('categories')
                    ->restrictOnDelete();
            });
        }
    }
};
