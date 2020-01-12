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
    protected $stripe;

    public function __construct(){
        $this->stripe = Stripe::make(config('services.stripe.secret'));
    }
    // Craete Customer on Stripe
    public function createCustomer($email){
        $customer = $this->stripe->customers()->create([
            'email' => $email,
        ]);
        return $customer;
    }

    // Craete New Card of Customer
    public function addNewCard($cardData,$customer_stripe_id){
        $token = $this->stripe->tokens()->create([
            'card' => $cardData,
        ]);
        return $this->stripe->cards()->create($customer_stripe_id, $token['id']);
    }

    // Create Charge 
    public function createCharge($data){
        $charge = $this->stripe->charges()->create($data);
        return $charge;
    }
 
}
