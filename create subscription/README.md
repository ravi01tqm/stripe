# stripe

Stripe component in cakePHP 4

path of the stripe component.--------
controller/component/StripeComponent.php


1. create a customer with paument method .
2. payment method to create and paymentMethod object use while create customer.
3. create products to use while creating subscription.
4. create price for product.
5. create plan to use in subscription.
6. create subscription with the customer id and a items.
	
		items => [plan] or [price];

	note : - make a customer with the default paymeny method for creating the subscription of that customer

 ----------------------------------------- Associations ---------------------------------------------

 -> payment mehtod with customer.
 -> procuct with price.
 -> plan with product.
 -> subscription with plan
 or 
 -> subscription with price. 

controller where these component methods are test .
path------------
controller/TestController.php

