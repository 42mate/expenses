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
        if (!Schema::hasTable('exchange_rates')) {
            Schema::create('exchange_rates', function (Blueprint $table) {
                $table->id();
                // Currency code (e.g. USD, ARS, XBT). Base currency is USD.
                $table->string('code', 10)->unique();
                // Units of this currency per 1 USD.
                $table->decimal('rate', 30, 15);
                $table->string('source', 10)->default('fiat');
                $table->timestamp('fetched_at')->nullable();
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
        Schema::dropIfExists('exchange_rates');
    }
};
