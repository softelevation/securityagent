<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFildToReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('reports', function (Blueprint $table) {
            $table->string('mauvaise_text')->nullable();
            $table->string('exterieur_text')->nullable();
            $table->string('oui_pièce_text')->nullable();
            $table->string('oui_lesquelles_text')->nullable();
            $table->string('zones_isolees_text')->nullable();
            $table->string('demande_par_text')->nullable();
            $table->string('maitre_chien_text')->nullable();
            $table->string('oui_30_text')->nullable();
            $table->string('oui_32_text')->nullable();
            $table->string('oui_34_text')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
                $table->dropColumn('mauvaise_text');
                $table->dropColumn('exterieur_text');
                $table->dropColumn('oui_pièce_text');
                $table->dropColumn('oui_lesquelles_text');
                $table->dropColumn('zones_isolees_text');
                $table->dropColumn('demande_par_text');
                $table->dropColumn('maitre_chien_text');
                $table->dropColumn('oui_30_text');
                $table->dropColumn('oui_32_text');
                $table->dropColumn('oui_34_text');
        });
    }
}
