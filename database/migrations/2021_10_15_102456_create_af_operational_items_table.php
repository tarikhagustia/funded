<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAfOperationalItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('af_operational_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('af_operational_id')->nullable()->constrained()->onDelete('cascade');         
            $table->string('name');            
            $table->double('amount');            

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
        Schema::dropIfExists('af_operational_items');
    }
}
