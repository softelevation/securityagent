<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('customer_id');
            $table->string('title');
            $table->string('location');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('intervention')->nullable();
            $table->string('agent_type')->nullable();
            $table->string('total_hours')->nullable();
            $table->string('quick_book')->nullable();
            $table->string('start_date_time')->nullable();
            $table->string('vehicle_required')->nullable();
            $table->string('description')->nullable();
			$table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('custom_requests');
    }
}
