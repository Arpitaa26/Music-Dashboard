<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
|  Stripe API Configuration
| -------------------------------------------------------------------
|
| You will get the API keys from Developers panel of the Stripe account
| Login to Stripe account (https://dashboard.stripe.com/)
| and navigate to the Developers � API keys page
|
|  stripe_api_key        	string   Your Stripe API Secret key.
|  stripe_publishable_key	string   Your Stripe API Publishable key.
|  stripe_currency   		string   Currency code.
*/
$config['stripe_api_key']         = 'sk_test_51NNXJ0SB8OcLibA9mJ4ryxmZuQRzsQCtOhitKWGqJmqXmWw2M9JfigC3eHYj1GmBAmuq1X6WeRKmz0yry8BQG7yV0099VzMVgT'; 
$config['stripe_publishable_key'] = 'pk_test_51NNXJ0SB8OcLibA98PBLC3xCInlR2YayPd60YXm392j3HxOqlhUP4V4yV3b7f6HMU6dGnLuRsAlrdGllPvBo3fGg00aA3OfRcc'; 
$config['stripe_currency']        = 'usd';