<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wagers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('total_wager_value');
            $table->integer('odds');
            $table->integer('selling_percentage');
            $table->decimal('selling_price', 9, 2);
            $table->decimal('current_selling_price', 9, 2);
            $table->integer('percentage_sold')->nullable();
            $table->integer('amount_sold')->nullable();
            $table->datetime('placed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wagers');
    }
}
