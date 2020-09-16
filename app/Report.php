<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';
	protected $fillable = [
        'mission_id','intervention','ronde','gardiennage','oui','non','date','heure_appel','heure_arrivee','heure_de_depart','vent_fort_01','pluie',
        'orage','neige','mauvaise','interieur','exterieur','non_09','oui_pièce','non_11','oui_lesquelles_12','non_13','oui_14','en_service_15',
        'hors_service_16','non_17','oui_18','zone_19','zones_isolees','non_21','oui_22','client_23','police_24','gendarmerie_25','pompiers_26','ads_27',
        'demande_par','maitre_chien','non_29','oui_30','non_31','oui_32','n_0','non_33','oui_34','status'
	];
}
