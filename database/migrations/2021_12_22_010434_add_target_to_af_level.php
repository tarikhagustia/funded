<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTargetToAfLevel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('af_levels', function (Blueprint $table) {
            $table->integer('target_new_member')->default(0);
            $table->integer('target_nmi')->default(0);
            $table->integer('target_maintain_downline')->default(0);
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
            $table->dropColumn(['target_new_member', 'target_nmi', 'target_maintain_downline']);
        });
    }
}
