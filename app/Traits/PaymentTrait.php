<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\HelperTrait;
use Stripe;

trait PaymentTrait
{
    use HelperTrait;

    // Create Stripe API Token
    public function stripe_token(){
        return Stripe::make(config('services.stripe.secret'));
    }

    // Craete Customer on Stripe
    public function createCustomer($email){
        $stripe = $this->stripe_token();
        $customer = $stripe->customers()->create([
            'email' => $email,
        ]);
        return $customer;
    }

    // Craete New Card of Customer
    public function addNewCard($cardData,$customer_stripe_id){
        $stripe = $this->stripe_token();
        $token = $stripe->tokens()->create([
            'card' => $cardData,
        ]);
        return $stripe->cards()->create($customer_stripe_id, $token['id']);
    }

    // Create Charge 
    public function createCharge($data){
        $stripe = $this->stripe_token();
        $charge = $stripe->charges()->create($data);
        return $charge;
    }
 
    // Get all card's list
    public function getCardsList($customer_stripe_id){
        // $header = "Authorization: Bearer ". config('services.stripe.secret');
        // $url = 'https://api.stripe.com/v1/customers/'.$customer_stripe_id.'/sources';
        // $response = \Curl::to($url)->withHeader($header)->get();
        // $response = json_decode($response,1);
        // return $response;  
        $stripe = $this->stripe_token(); 
 
        $res = $stripe->cards()->all($customer_stripe_id);
      
    }

    // Get all card's list
    public function refundCharge($charge_id){
        $stripe = $this->stripe_token(); 
        return $stripe->refunds()->create($charge_id);    
    }
 
}
