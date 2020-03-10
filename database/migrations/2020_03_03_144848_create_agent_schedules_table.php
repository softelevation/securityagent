<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('agent_id');
            $table->time('sunday_from')->nullable();
            $table->time('sunday_to')->nullable();
            $table->boolean('sunday_off')->default(0);
            $table->time('monday_from')->nullable();
            $table->time('monday_to')->nullable();
            $table->boolean('monday_off')->default(0);
            $table->time('tuesday_from')->nullable();
            $table->time('tuesday_to')->nullable();
            $table->boolean('tuesday_off')->default(0);
            $table->time('wednesday_from')->nullable();
            $table->time('wednesday_to')->nullable();
            $table->boolean('wednesday_off')->default(0);
            $table->time('thursday_from')->nullable();
            $table->time('thursday_to')->nullable();
            $table->boolean('thursday_off')->default(0);
            $table->time('friday_from')->nullable();
            $table->time('friday_to')->nullable();
            $table->boolean('friday_off')->default(0);
            $table->time('saturday_from')->nullable();
            $table->time('saturday_to')->nullable();
            $table->boolean('saturday_off')->default(0);
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
        Schema::dropIfExists('agent_schedules');
    }
}
