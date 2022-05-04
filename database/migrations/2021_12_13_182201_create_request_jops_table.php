<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRequestJopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_jops', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('qualification')->nullable(true);
            $table->string('skills')->nullable(true);
            $table->string('certificates')->nullable(true);
            $table->string('summary_about_you')->nullable(true);
            $table->string('attach')->nullable(true);
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
        Schema::dropIfExists('request_jops');
    }
}
