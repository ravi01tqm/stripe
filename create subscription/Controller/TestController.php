<?php

namespace App\Controller;

use App\Controller\AppController;

class TestController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Stripe');
    }

    public function index()
    {
    }

    public function payment()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // dd($data);
            $card_detail = [
                'number' => $data['card_number'],
                'exp_month' => $data['expiration_month'],
                'exp_year' => $data['expiration_year'],
                'cvc' => $data['CVC']
            ];
            // $customer = $this->Stripe->createCustomer();
            $token = $this->Stripe->card($card_detail);
            $charges = $this->Stripe->createCharge($token->id, 200);
            // dd($charges->status == 'succeeded');
            if ($charges->getError()) {
                $this->set('error', $charges->getMessage());
            }
        }
    }

    public function product()
    {
        $product = $this->Stripe->createProduct('gold subscription');
        $id = $this->Stripe->listProduct()->data[0]->id;
        $pro_price = $this->Stripe->createPriceForProduct(200, 'usd', $id);
    }

    public function subs()
    {
        $list_plan = $this->Stripe->listPlan()->data[0]->id;
        $item = ['plan' => $list_plan];
        $list_customer = $this->Stripe->listcustomer()->data[0]->id;
        $subs = $this->Stripe->createSubscription($list_customer, $item);
        dd($subs);
    }

    public function customer()
    {
        $this->autoRender = false;
        $type = 'card';
        $detail = [
            'number' => '4242424242424242',
            'exp_month' => 2,
            'exp_year' => 2023,
            'cvc' => '314'
        ];
        $pay_method = $this->Stripe->paymentMethod($type,$detail);
        $customer = [
            'description' => 'Test user case for subscription',
            'email'=>'rk@gmail.com',
            "metadata" => ["user" => "test"],
            'name'=>'Ravi',
            'payment_method'=>$pay_method->id
        ];
        $customer = $this->Stripe->createCustomer($customer);
        dd($customer);
    }

}
