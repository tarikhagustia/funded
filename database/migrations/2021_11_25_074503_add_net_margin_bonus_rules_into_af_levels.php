<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNetMarginBonusRulesIntoAfLevels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('af_levels', function (Blueprint $table) {
            $table->double('nm_bonus');
            $table->enum('nm_bonus_type', ['fixed', 'percentage']);
            $table->double('nm_min_new_downline')->nullable()->default(20);
            $table->double('nm_min_net_margin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('af_levels', function (Blueprint $table) {
            $table->dropColumn(['nm_bonus', 'nm_bonus_type', 'nm_min_new_downline', 'nm_min_net_margin']);
        });
    }
}
