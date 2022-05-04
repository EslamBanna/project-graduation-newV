<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateFoundObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('found_objects', function (Blueprint $table) {
            $table->id();
            $table->integer('helper_id');
            $table->string('type');
            $table->dateTime('found_date');
            $table->string('found_place');
            $table->string('description');
            $table->string('attach')->nullable();
            $table->string('first_color')->nullable();
            $table->string('second_color')->nullable();
            $table->string('brand')->nullable();
            $table->string('category')->nullable();
            // $table->timestamps();
            $table->string('long')->nullable();
            $table->string('lat')->nullable();
            $table->string('region')->nullable();
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
        Schema::dropIfExists('found_objects');
    }
}
