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

    // Craete Customer on Stripe
    public function createCustomer($email){
        $stripe = Stripe::make(config('services.stripe.secret'));
        $customer = $stripe->customers()->create([
            'email' => $email,
        ]);
        return $customer;
    }

    // Craete New Card of Customer
    public function addNewCard($cardData,$customer_stripe_id){
        $stripe = Stripe::make(config('services.stripe.secret'));
        $token = $stripe->tokens()->create([
            'card' => $cardData,
        ]);
        return $stripe->cards()->create($customer_stripe_id, $token['id']);
    }

    // Create Charge 
    public function createCharge($data){
        $stripe = Stripe::make(config('services.stripe.secret'));
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
        $stripe = Stripe::make(config('services.stripe.secret'));          
        return $stripe->cards()->all($customer_stripe_id);
    }
 
}
