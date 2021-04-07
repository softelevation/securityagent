<?php

namespace App\Traits;

trait CurlTrait
{
    public function Make_GET($link){
        $curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://51.68.139.99:3000/$link",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_TIMEOUT => 30000,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				// Set Here Your Requesred Headers
				'Content-Type: application/json',
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			return $err;
			// echo "cURL Error #:" . $err;
		} else {
			return json_decode($response);
			// print_r(json_decode($response));
		}
    }
}
