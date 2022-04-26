<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialHelpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_helps', function (Blueprint $table) {
            $table->id();
            $table->integer('needer_id');
            $table->string('type_of_help');
            $table->string('specific_address')->nullable();
            $table->integer('value')->nullable();
            $table->enum('target_help',['for_me','for_another_one'])->default('for_me');
            $table->string('another_user_name')->nullable();
            $table->enum('provide_help_way',['online','by_hand'])->default('by_hand');
            $table->boolean('status')->comment('0 still not helped 1 helped')->default(0);
            $table->string('attach')->nullable();
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
        Schema::dropIfExists('financial_helps');
    }
}
