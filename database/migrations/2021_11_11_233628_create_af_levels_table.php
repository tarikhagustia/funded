<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAfLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('af_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('referral_bonus_percentage')->default(0);
            $table->double('affiliate_max_bonus', 12)->default(0); // Bonus in USD
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
        Schema::dropIfExists('af_levels');
    }
}
