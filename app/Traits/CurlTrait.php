<?php

namespace App\Traits;
use Auth;

trait CurlTrait
{
	// private $base_url = 'http://localhost:7000/';
	private $base_url = 'http://51.68.139.99:3000/';
	
	public function Make_GET($link){
        $curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->base_url.$link,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_TIMEOUT => 30000,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				// Set Here Your Requesred Headers
				'Content-Type: application/json',
				'authorization: '.Auth::user()->token,
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
	
	public function Make_Login($link,$input){
		$curl = curl_init();
		$options = array(
			CURLOPT_URL => $this->base_url.$link,
			CURLOPT_HEADER => false,
			CURLOPT_POST => 1,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json'
			),
			CURLOPT_POSTFIELDS => json_encode($input),
			CURLOPT_RETURNTRANSFER => true
			); // cURL options
			curl_setopt_array($curl, $options);
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				echo "cURL Error #:" . $err;
			} else {
				return json_decode($response);
			}
	}
	
	
	public function Make_POST($link,$input){
		$curl = curl_init();
		$options = array(
			CURLOPT_URL => $this->base_url.$link,
			CURLOPT_HEADER => false,
			CURLOPT_POST => 1,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'authorization: '.Auth::user()->token,
			),
			CURLOPT_POSTFIELDS => json_encode($input),
			CURLOPT_RETURNTRANSFER => true
			); // cURL options
			curl_setopt_array($curl, $options);
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				echo "cURL Error #:" . $err;
			} else {
				return json_decode($response);
			}
	}
	
	public function Make_PATCH($link,$input){
		$ch = curl_init();
		// set url
		curl_setopt($ch, CURLOPT_URL, $this->base_url.$link);
		// set method
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
		// return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// set headers
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
		  'Content-Type: application/json',
		  'authorization: '.Auth::user()->token,
		]);
		// set body
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input));

		// send the request and save response to $response
		$response = curl_exec($ch);
		$err = curl_error($ch);
		curl_close($ch);
			
			if ($err) {
				echo "cURL Error #:" . $err;
			} else {
				return json_decode($response);
			}
	}
	
}
