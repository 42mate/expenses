<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DemoEntity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demo_entity', function (Blueprint $table) {
            $table->id();

            $table->text('name')
                ->nullable(false);

            $table->longText('description')
                ->nullable(false);

            $table->boolean('active')
                ->nullable(false)
                ->default(true);

            $table->date('birth_date')
                ->nullable(false);

            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demo_entity');
    }
}
