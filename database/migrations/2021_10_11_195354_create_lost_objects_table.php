<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLostObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lost_objects', function (Blueprint $table) {
            $table->id();
            $table->integer('needer_id');
            $table->string('type');
            $table->dateTime('expected_lost_date');
            $table->string('expected_lost_place');
            $table->string('description');
            $table->string('attach')->nullable();
            $table->string('first_color')->nullable();
            $table->string('second_color')->nullable();
            $table->string('brand')->nullable();
            $table->string('category')->nullable();
            // $table->timestamps();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lost_objects');
    }
}
