<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNetMarginBonusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('net_margin_bonuses', function (Blueprint $table) {
            $table->id();
            $table->date('comm_from_date');
            $table->date('comm_to_date');
            $table->bigInteger('af_id');
            $table->string('af_name');
            $table->double('total_net_margin', 11);
            $table->double('total_lot', 11);
            $table->double('total_member', 11);
            $table->double('total_commission', 11);
            $table->string('addendum')->nullable();
            $table->string('status')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('net_margin_bonuses');
    }
}
