<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mission;
use Carbon\Carbon;
use App\Helpers\Helper;

class CommonController extends Controller
{

	/**
     * @param $request
     * @return mixed
     * @method missionExpiredRequest
     * @purpose check missions expired
     */
    public function missionExpiredCronJob(Request $request){
        $timeNow = date('Y-m-d H:i:s');
        $duration = Helper::REQUEST_TIMEOUT_MINUTES;
        $data = Mission::whereRaw("DATE_ADD(assigned_at, INTERVAL ".$duration." MINUTE) < '".$timeNow."'")->where('status',0)->whereNotNull('assigned_at');
        if($data->count() > 0){
        	$update = $data->update(['agent_id'=>0,'assigned_at'=>Null]);
	        if($update){
	        	die('Records updated successfully.');
	        }else{
	        	die('Something went wrong!');
	        }
        }else{
        	die('No record found!');
        }
    }
}
