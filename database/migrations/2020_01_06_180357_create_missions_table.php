<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id');
            $table->integer('agent_id')->default(0);
            $table->string('title')->nullable();
            $table->string('location')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->datetime('start_date_time')->nullable();
            $table->integer('agent_type')->default(0);
            $table->text('description')->nullable();
            $table->tinyInteger('quick_book')->default(0);
            $table->integer('total_hours')->default(0);
            $table->float('amount')->default(0);
            $table->tinyInteger('payment_status')->default(0)->comment('0=>Not Paid, 1=>Paid');
            $table->tinyInteger('status')->default(0);
            $table->integer('step')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
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
        Schema::dropIfExists('missions');
    }
}
