<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceStatusToMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	 
	 // 2020_03_18_125412_add_Invoice_status_to_missions_table
	 
    public function up()
    {

        Schema::table('missions', function (Blueprint $table) {

            $table->tinyInteger('invoice_status')->default(0);

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
            //
                $table->dropColumn('invoice_status');
        });
    }
}
