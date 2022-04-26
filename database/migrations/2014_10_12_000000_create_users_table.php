<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->unique();
            $table->date('date_of_birth')->nullable();
            $table->string('id_number')->unique();
            $table->string('job')->nullable();
            $table->boolean('gender')->default(1)->comment('0 female 1 male');
            $table->string('main_address')->nullable();
            $table->string('id_photo')->nullable();
            $table->string('photo')->nullable();
            // $table->string('last_visited_address')->nullable();
            // $table->boolean('active')->default(1);
            // $table->boolean('is_verified')->default(0);
            // $table->string('verfication_code')->nullable();
            $table->string('long')->nullable();
            $table->string('lat')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
