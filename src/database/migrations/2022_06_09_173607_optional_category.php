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
        if (Schema::hasTable('expenses')) {
            if (Schema::hasColumn('expenses', 'category_id')) {
                Schema::table('expenses', function (Blueprint $table) {
                    $table->dropForeign(['category_id']);
                });

                Schema::table('expenses', function (Blueprint $table) {
                    //We need this to avoid changes in the date on updates
                    // see: https://stackoverflow.com/a/61379469
                    $table->timestamp('date')->nullable()->change();

                    //This will allow null on categories
                    $table->unsignedBigInteger('category_id')->nullable()->change();

                    $table->foreign('category_id')
                        ->references('id')
                        ->on('categories')
                        ->nullOnDelete()
                        ->cascadeOnUpdate();
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
        if (Schema::hasColumn('expenses', 'category_id')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
            });

            Schema::table('expenses', function (Blueprint $table) {
                $table->unsignedBigInteger('category_id')->nullable(false)->change();

                $table->foreign('category_id')
                    ->references('id')
                    ->on('categories')
                    ->restrictOnDelete();
            });
        }
    }
};
