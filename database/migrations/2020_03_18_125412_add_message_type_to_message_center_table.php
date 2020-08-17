<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMessageTypeToMessageCenterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('message_centers', function (Blueprint $table) {
			DB::statement("ALTER TABLE `message_centers` CHANGE `message_type` `message_type` ENUM('send_by_cus','send_by_op','send_by_agent') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'send_by_cus';");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('message_centers', function (Blueprint $table) {
            DB::statement("ALTER TABLE `message_centers` CHANGE `message_type` `message_type` ENUM('send_by_cus','send_by_op','send_by_agent') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'send_by_cus';");
        });
    }
}
