<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Recurrent expenses defaulted to currency_id = 1 ("DEF"), which has no
     * exchange rate and therefore never converted. Backfill those to each
     * owner's profile default currency so the pending list can convert them.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('recurrent_expense', 'currency_id')) {
            DB::statement(
                'UPDATE recurrent_expense re
                 JOIN users u ON u.id = re.user_id
                 SET re.currency_id = u.default_currency_id
                 WHERE re.currency_id = 1'
            );
        }
    }

    /**
     * Not reversible (original per-row values are not retained).
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
