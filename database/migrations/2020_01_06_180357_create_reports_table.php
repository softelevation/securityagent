<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('mission_id');
            $table->tinyInteger('intervention')->default(0);
            $table->tinyInteger('ronde')->default(0);
            $table->tinyInteger('gardiennage')->default(0);
            $table->tinyInteger('oui')->default(0);
            $table->tinyInteger('non')->default(0);
            $table->date('date')->nullable();
			$table->string('heure_appel');
			$table->string('heure_arrivee');
			$table->string('heure_de_depart');
			$table->tinyInteger('vent_fort_01')->default(0);
			$table->tinyInteger('pluie')->default(0);
			$table->tinyInteger('orage')->default(0);
			$table->tinyInteger('neige')->default(0);
			$table->tinyInteger('mauvaise')->default(0);
			$table->tinyInteger('interieur')->default(0);
			$table->tinyInteger('exterieur')->default(0);
			$table->tinyInteger('non_09')->default(0);
			$table->tinyInteger('oui_pièce')->default(0);
			$table->tinyInteger('non_11')->default(0);
			$table->tinyInteger('oui_lesquelles_12')->default(0);
			$table->tinyInteger('non_13')->default(0);
			$table->tinyInteger('oui_14')->default(0);
			$table->tinyInteger('en_service_15')->default(0);
			$table->tinyInteger('hors_service_16')->default(0);
			$table->tinyInteger('non_17')->default(0);
			$table->tinyInteger('oui_18')->default(0);
			$table->tinyInteger('zone_19')->default(0);
			$table->tinyInteger('zones_isolees')->default(0);
			$table->tinyInteger('non_21')->default(0);
			$table->tinyInteger('oui_22')->default(0);
			$table->tinyInteger('client_23')->default(0);
			$table->tinyInteger('police_24')->default(0);
			$table->tinyInteger('gendarmerie_25')->default(0);
			$table->tinyInteger('pompiers_26')->default(0);
			$table->tinyInteger('ads_27')->default(0);
			$table->tinyInteger('demande_par')->default(0);
			$table->tinyInteger('maitre_chien')->default(0);
			$table->tinyInteger('non_29')->default(0);
			$table->tinyInteger('oui_30')->default(0);
			$table->tinyInteger('non_31')->default(0);
			$table->tinyInteger('oui_32')->default(0);
			$table->string('n_0')->nullable();
			$table->tinyInteger('non_33')->default(0);
			$table->tinyInteger('oui_34')->default(0);
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
        Schema::dropIfExists('reports');
    }
}
