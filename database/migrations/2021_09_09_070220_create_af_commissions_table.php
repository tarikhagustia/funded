<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAfCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('af_commissions', function (Blueprint $table) {
            $table->id();
            $table->date('comm_date');
            $table->integer('af_id');
            $table->integer('login');
            $table->string('client_name');
            $table->string('af_name');
            $table->integer('af_level');
            $table->float('af_percentage');
            $table->float('max_rebate');
            $table->float('lot');
            $table->double('total_commission');
            $table->timestamps();
            $table->unique(['comm_date', 'af_id', 'login']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('af_commissions');
    }
}
