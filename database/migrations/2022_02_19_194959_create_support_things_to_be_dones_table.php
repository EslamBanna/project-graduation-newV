<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportThingsToBeDonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_things_to_be_dones', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('from_place')->nullable();
            $table->string('to_place')->nullable();
            $table->date('date')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('support_things_to_be_dones');
    }
}
