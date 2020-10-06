<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyNameToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	 
	 // 2020_03_18_125412_ 
	 
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('company_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
                $table->dropColumn('company_name');
        });
    }
}
