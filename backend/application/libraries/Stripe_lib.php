<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Stripe Library for CodeIgniter 3.x
 *
 * Library for Stripe payment gateway. It helps to integrate Stripe payment gateway
 * in CodeIgniter application.
 *
 * This library requires the Stripe PHP bindings and it should be placed in the third_party folder.
 * It also requires Stripe API configuration file and it should be placed in the config directory.
 *

 */

class Stripe_lib{
    var $CI;
	var $api_error;
    
    function __construct(){
		$this->api_error = '';
        $this->CI =& get_instance();
        $this->CI->load->config('stripe');
		
		// Include the Stripe PHP bindings library
		//require APPPATH .'third_party/stripe-php/init.php';
		require_once('vendor/stripe/stripe-php/init.php');
		
		// Set API key
		\Stripe\Stripe::setApiKey($this->CI->config->item('stripe_api_key'));
    }

    function addUser($email, $token){
		try {
			// Add customer to stripe
			$customer = \Stripe\Customer::create(array(
				'email' => $email,
				'sourse'  => $token
			));
			pp($customer);
			return $customer;
		}catch(Exception $e) {
			$this->api_error = $e->getMessage();
			return false;
		}
    }
	
	function createCharge($user_Id, $course_name, $price, $payment_id){
	
		$priceCourse = ($price*100);
		$currency = $this->CI->config->item('stripe_currency');
		
		try {
		
			$charge = \Stripe\Charge::create(array(
				'customer' => $user_Id,
				'amount'   => $priceCourse,
				'currency' => $currency,
				'description' => $course_name,
				'metadata' => array(
					'payment_id' => $payment_id
				)
			));
			
		
			$chargeJson = $charge->jsonSerialize();
			return $chargeJson;
		}catch(Exception $e) {
			$this->api_error = $e->getMessage();
			return false;
		}
    }
}