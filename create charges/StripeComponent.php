<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Stripe\paymentMethod;
use Stripe\Token;
use Stripe\Exception\ExceptionInterface;

class StripeComponent extends Component
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        Stripe::setApiKey(STRIPE_SECRET);
    }

    public function createCustomer()
    {
        $res = Customer::create([
            'name'=>'Ravi',
            'email'=>'rk@gmail.com'
        ]);
        return $res;
    }

    public function paymentMethod($type,$detail)
    {
        $res = paymentMethod::create([
            'type' => $type,
            $type => $detail
          ]);
          return $res;
    }

    public function card($detail)
    {
        try{
            $card = Token::create([
                'card' => $detail,
              ]);
              return $card;
        }catch(ExceptionInterface $e){
            return $e;
        }
    }

    public function getCharges($charge_id)
    {
        return charge::retrieve($charge_id);

    }

    public function createCharge($token,$amount)
    {
        try{
            $res = charge::create([
                'amount' => $amount,
                'currency' => 'usd',
                'source' => $token,
                'description' => 'My First Test Charge (created for API docs)',
            ]);
            return $res;
        }catch(ExceptionInterface $e)
        {
            return $e;
        }
    }

    // public function paymentIntent()
    // {
    //     try {
    //         $paymentIntent = PaymentIntent::create([
    //             'amount' => '123',
    //             'currency' => 'usd',
    //             'automatic_payment_methods' => [
    //                 'enabled' => true,
    //             ],
    //         ]);
    //         return $paymentIntent;
            
    //     } catch (ErrorObject $e) {
    //        return $e;
    //     }
    // }

}
