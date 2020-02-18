<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('username');
            $table->string('avatar_icon')->nullable();
            $table->string('identity_card');
            $table->string('social_security_number');
            $table->string('cv');
            $table->string('iban');
            $table->integer('agent_type')->default(0);
            $table->string('cnaps_number')->nullable();
            $table->string('home_address');
            $table->string('work_location_address');
            $table->tinyInteger('is_vehicle');
            $table->string('work_location_latitude')->nullable();
            $table->string('work_location_longitude')->nullable();
            $table->string('current_location_lat_long')->nullable();
            $table->tinyInteger('status')->comment('0 => Pending, 1 => Verified, 2 => Rejected');
            $table->tinyInteger('available')->default(1)->comment('0=>Not Available, 1=>Available, 2=>On Mission');
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
        Schema::dropIfExists('agents');
    }
}
