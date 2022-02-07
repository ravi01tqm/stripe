<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Stripe\PaymentMethod;
use Stripe\Token;
use Stripe\Plan;
use Stripe\Product;
use Stripe\Price;
use Stripe\Subscription;
use Stripe\Exception\ExceptionInterface;

class StripeComponent extends Component
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        Stripe::setApiKey(STRIPE_SECRET);
    }

    public function paymentMethod($type, $detail)
    {
        try {
            return paymentMethod::create([
                'type' => $type,
                $type => $detail
            ]);
        } catch (ExceptionInterface $e) {
            return $e;
        }
    }

    public function listPaymentMethod($customer, $type)
    {
        try {
            return paymentMethod::all([
                'customer' => $customer,
                'type' => $type,
            ]);
        } catch (ExceptionInterface $e) {
            return $e;
        }
    }


    public function createCustomer($details, $make_default = false)
    {
        try {
            if ($make_default) {
                return Customer::create(
                    $details['invoice_settings'] = 
                    ['default_payment_method' => $details['payment_method']]);
            }
            return Customer::create($details);
        } catch (ExceptionInterface $e) {
            return $e;
        }
    }

    public function updateCustomer($id, $updates)
    {
        try {
            return Customer::update($id, $updates);
        } catch (ExceptionInterface $e) {
            return $e;
        }
    }

    // ----- get customer-------
    public function getCustomer($id, $options = null)
    {
        try {
            return Customer::retrieve($id, $options);
        } catch (ExceptionInterface $e) {
            return $e;
        }
    }

    // --------- list customers
    public function listCustomer($options = null)
    {
        return Customer::all($options);
    }


    public function card($detail)
    {
        try {
            return Token::create([
                'card' => $detail,
            ]);
        } catch (ExceptionInterface $e) {
            return $e;
        }
    }

    public function getCharges($charge_id)
    {
        try{
            return charge::retrieve($charge_id);
        }catch(ExceptionInterface $e)
        {
            return $e;
        }
    }

    public function createCharge($token, $amount)
    {
        try {
            return  charge::create([
                'amount' => $amount,
                'currency' => 'usd',
                'source' => $token,
                'description' => 'My First Test Charge (created for API docs)',
            ]);
        } catch (ExceptionInterface $e) {
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

    // ---------------- create product for plan --------------
    /**
     * @param string $name product name
     * @param array $options optional params for create product.
     */

    public function createProduct($name, $options = null)
    {
        try {
            return Product::create([
                'name' => $name,
                $options
            ]);
        } catch (ExceptionInterface $e) {
            return $e;
        }
    }
    // ---------- get Product-----------

    public function getProduct($id)
    {
        try {
            return Product::retrieve($id);
        } catch (ExceptionInterface $e) {
            return $e;
        }
    }

    // -------------- list all product ------

    public function listProduct($options = null)
    {
        return Product::all($options);
    }

    // --------------- create price for product ---------
    /**
     * @param array $options optional paramsm for product price.
     */
    public function createPriceForProduct($unit_amount, $currency, $product, $options = null)
    {
        try {
            return Price::create([
                'unit_amount' => $unit_amount * 100,
                'currency' => $currency,
                'product' => $product,
                $options
            ]);
        } catch (ExceptionInterface $e) {
            return $e;
        }
    }


    // ---------------- create a plan for subscription -------------
    /**
     * @param string $product enter prodcut id of product object
     * @param array $options other optional param for create plan 
     * @param string $interval ( month, week, year, day)
     */

    public function createPlan($amount, $currency, $interval, $product, $options = null)
    {
        try {
            return plan::create([
                'amount' => $amount * 100,
                'currency' => $currency,
                'interval' => $interval,
                'product' => $product,
                $options
            ]);
        } catch (ExceptionInterface $e) {
            return $e;
        }
    }

    // --------------get plan--------
    public function getPlan($id, $options = null)
    {
        try {
            return Plan::retrieve($id, $options);
        } catch (ExceptionInterface $e) {
            return $e;
        }
    }

    // ---------- list all plans---
    public function listPlan($options = null)
    {
        return Plan::all($options);
    }

    // ------- create subscription ----------
    /**
     * @param array $items plan or price objec (id)
     */
    public function createSubscription($customer, $items)
    {
        try {
            return Subscription::create([
                'customer' => $customer,
                'items' => [
                    $items,
                ],
            ]);
        } catch (ExceptionInterface $e) {
            return $e;
        }
    }
}
