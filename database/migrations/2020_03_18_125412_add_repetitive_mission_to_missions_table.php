<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRepetitiveMissionToMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->string('repetitive_mission')->nullable();
            $table->string('mission_finish_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('missions', function (Blueprint $table) {
                $table->dropColumn('repetitive_mission');
                $table->dropColumn('mission_finish_time');
        });
    }
}
