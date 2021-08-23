<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date');
            $table->string('af_code', 100);
            $table->integer('login');
            $table->string('meta_group');
            $table->string('client_name');
            $table->integer('rate');
            $table->string('af_code_numeric');
            $table->string('af_name');
            $table->integer('af_id');
            $table->float('lot')->default(0);
            $table->float('comm')->default(0);
            $table->float('or')->default(0);
            $table->float('or_idr')->default(0);
            $table->float('bop')->default(0);
            $table->float('bop_idr')->default(0);
            $table->float('total_rebate')->default(0);
            $table->float('prev_equity')->default(0);
            $table->float('net_margin_in_out')->default(0);
            $table->float('current_equity')->default(0);
            $table->float('credit')->default(0);
            $table->float('net_equity')->default(0);
            $table->float('agent_percentage')->default(0);
            $table->float('agent_pl')->default(0);
            $table->float('holding_pl')->default(0);
            $table->string('remark_adjustment')->nullable();
            $table->float('nominal_adjustment')->default(0);
            $table->float('lot_adjustment')->default(0);
            $table->date('registration_date');
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
        Schema::dropIfExists('transactions');
    }
}
