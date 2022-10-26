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
        if (Schema::hasTable('wallets')) {
            if (!Schema::hasColumn('wallets', 'balance')) {
                Schema::table('wallets', function (Blueprint $table) {
                    $table->decimal('balance', 10, 2)->default(0);
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
        if (Schema::hasTable('wallets')) {
            if (Schema::hasColumn('wallets', 'balance')) {
                Schema::dropColumns('wallets', ['balance']);
            }
        }
    }
};
