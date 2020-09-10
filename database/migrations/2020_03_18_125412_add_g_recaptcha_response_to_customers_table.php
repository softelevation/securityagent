<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGRecaptchaResponseToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('g-recaptcha-response')->nullable();
        });
		Schema::table('agents', function (Blueprint $table) {
            $table->string('g-recaptcha-response')->nullable();
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
                $table->dropColumn('g-recaptcha-response');
        });
		Schema::table('agents', function (Blueprint $table) {
                $table->dropColumn('g-recaptcha-response');
        });
    }
}
