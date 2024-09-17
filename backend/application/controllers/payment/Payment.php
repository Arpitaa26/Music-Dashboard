<?php
defined('BASEPATH') or exit('No direct script access allowed');

//use mrmoni\base\CI_Rest;

class Payment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(["payment_model", "course_enrollment_model", "course_model"]);
        $this->load->library('stripe_lib');
    }


    private function save_view($id = null)
    {

        if ( $this->payment_model->get($id)) {
          view("payment/create", compact("payment"), "Portal | Payment Edit");
        } else {
          view("payment/index", null, "Portal | Country Create");
         
        }
    }

    public function save($id = null)
    {
        try {
            $this->http->auth(["post", "get"], "ADMIN");
            $p =  $this->http->request->all();
            if (is_post()) {

              
                $this->form_validation->set_rules(
                    [
                        [
                            'field' => 'country_name',
                            'label' => 'Country Name',
                            'rules' => "trim|required|alpha_numeric_spaces",
                            
                        ],
                        [
                            'field' => 'country_code',
                            'label' => 'Country Code',
                            'rules' => "trim|required|alpha_numeric_spaces",
                          
                        ],
                        [
                            'field' => 'course_currency',
                            'label' => 'Course Currency',
                            'rules' => "trim|required|alpha_numeric_spaces",
                          
                        ],
                        [
                            'field' => 'status',
                            'label' => 'Status',
                            'rules' => 'required|in_list[0,1]',
                            'errors' => array(
                                'in_list' => '%s select one of Active/Inactive',
                            ),
                        ]
                    ]
                );

                if ($this->form_validation->run() == TRUE) {

                   

                    $d = [
                        "country_code" => $p["country_code"],
                        "country_code" => $p["country_code"],
                        "course_currency" => $p["course_currency"],
                        "status" =>1,
                    ];

                    if (!is_null($id)) {
                        if ($this->payment_model->update($id, $d)) {
                            set_message("success", "Country updated successfully");
                        } else {
                            set_message("danger", "Country no changes found / failed");
                        }
                    } else {
                        if ($this->payment_model->insert($d)) {
                            set_message("success", "Country created successfully");
                        } else {
                            set_message("danger", "Country creation failed");
                        }
                    }

                    redirect(base_url('country'), 'refresh');
                } else {
                    $this->save_view($id);
                }
            } else {
                $this->save_view($id);
            }
        } catch (\Throwable $th) {
           redirect(base_url('country'), 'refresh');
         
        }
    }

    public function get($id)
    {
        try {
            $this->http->auth(["get"], "ADMIN");
            if ($data = $this->payment_model->get($id)) {
                return $this->http->response->create(200, "Country fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Country not found of given id");
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->http->response->serverError();
        }
    }
    public function get_all()
    {
        try {
            $this->http->auth(["get"],["ADMIN","STUDENT"]);
            $country =$this->getRealIpAddr();
            $country_id =$country[0]->id;
           
            if ($data = $this->payment_model->get_all(1,$country_id)) {
                return $this->http->response->create(200, "Country fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Country not found");
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->http->response->serverError();
        }
    }
    function purchasess(){
       
        try {
           
            $this->http->auth(["post", "get"], ["ADMIN","STUDENT","TEACHER"]);
            $p =  $this->http->request->all();
          
            $data = array();
            $course = $this->course_model->get(1);
           
		if($p['token']){
           
			$postData = $p ;
			$postData['course'] = $course;
           
			$payment_id= $this->payment($postData);
          
			if($payment_id){
				redirect('products/payment_status/'.$payment_id);
			}else{
				$apiError = !empty($this->stripe_lib->api_error)?' ('.$this->stripe_lib->api_error.')':'';
				$data['error_msg'] = 'Transaction has been failed!'.$apiError;
			}
	    }

        $data['course'] = $course;
       // $this->load->view('payment/details', $data);
    } catch (\Throwable $th) {
        throw $th;
        
    }
        	
		
    }
    function payment($p){
		
		try {
            $this->http->auth(["post", "get"], "ADMIN");
           
            if ($p) {
			
			$token  = $p['token'];
			$name = $p['name'];
			$email = $p['email'];
			$card_number = $p['card_num'];
			$card_number = preg_replace('/\s+/', '', $card_number);
			$card_exp_month = $p['card_exp_month'];
			$card_exp_year = $p['card_exp_year'];
			$card_cvc = $p['card_cvc'];
			
			// Unique payment ID
			$payment_id = strtoupper(str_replace('.','',uniqid('', true)));
           
			// Add customer to stripe
			$user = $this->stripe_lib->addUser($email, $token);
          //pp($user);
			if($user){
				// Charge a credit or a debit card
				$charge = $this->stripe_lib->createCharge($user->id,$p['course']->id, $p['course']->price, $payment_id);
				
				if($charge){
					// Check whether the charge is successful
					if($charge['amount_refunded'] == 0 && empty($charge['failure_code']) && $charge['paid'] == 1 && $charge['captured'] == 1){
						// Transaction details 
						$transactionID = $charge['balance_transaction'];
						$paidAmount = $charge['amount'];
						$paidAmount = ($paidAmount/100);
						$paidCurrency = $charge['currency'];
						$payment_status = $charge['status'];
						
						
						// Insert tansaction data into the database
						$orderData = array(
							'course_id' => $p['course_id'],
							'name' => $name,
							'email' => $email,
							'card_number' => $card_number,
							'card_exp_month' => $card_exp_month,
							'card_exp_year' => $card_exp_year,
							'amount' => $paidAmount,
							'currency' => $paidCurrency,
							'token' => $transactionID,
							'payment_status' => $payment_status
						);
						$payment_id = $this->payment_model->insert($orderData);
						
						// If the order is successful
						if($payment_status == 'succeeded'){
							return $payment_id;
						}
					}
				}
              }
            }
        } catch (\Throwable $th) {
            throw $th;
            
        }
		
		return false;
    }
   
    public function delete($id)
    {
        try {
            $this->http->auth(["get"], "ADMIN");
            if ($affected_rows = $this->payment_model->delete($id)) {
                return $this->http->response->create(200, "Country delete successfully");
            }
            else{
                return $this->http->response->create(203, "Country is not found / deleted");
            }
        } catch (\Throwable $th) {
            return $this->http->response->serverError();
        }
    }
   
    public function purchase()
	{
	
		//check whether stripe token is not empty
		if(!empty($_POST['stripeToken']))
		{
			//get token, card and user info from the form
			$stripeToken  = $_POST['stripeToken'];
			$name = $_POST['name'];
			$email = $_POST['email'];
			$card_num = $_POST['card_num'];
			$card_cvc = $_POST['card_cvc'];
			$card_exp_month = $_POST['card_exp_month'];
			$card_exp_year = $_POST['card_exp_year'];
			
			//include Stripe PHP library
			//require_once APPPATH."third_party/stripe-php/init.php";
			//require_once('vendor/stripe/stripe-php/init.php');
			
			//set api key
			$stripe = array(
			  "secret_key"      => "sk_test_51NNXJ0SB8OcLibA9mJ4ryxmZuQRzsQCtOhitKWGqJmqXmWw2M9JfigC3eHYj1GmBAmuq1X6WeRKmz0yry8BQG7yV0099VzMVgT",
			  "publishable_key" => "pk_test_51NNXJ0SB8OcLibA98PBLC3xCInlR2YayPd60YXm392j3HxOqlhUP4V4yV3b7f6HMU6dGnLuRsAlrdGllPvBo3fGg00aA3OfRcc"
			);
			
			\Stripe\Stripe::setApiKey($stripe['secret_key']);
			
			//add customer to stripe
			$customer = \Stripe\Customer::create(array(
				'email' => $email,
				'source'  => $stripeToken
			));
			
			//item information
			$itemName = "Stripe Donation";
			$itemNumber = "PS123456";
			$itemPrice = 50;
			$currency = "usd";
			$orderID = "SKA92712382139";
			
			//charge a credit or a debit card
			$charge = \Stripe\Charge::create(array(
				'customer' => $customer->id,
				'amount'   => $itemPrice,
				'currency' => $currency,
				'description' => $itemNumber,
				'metadata' => array(
					'item_id' => $itemNumber
				)
			));
			
			//retrieve charge details
			$chargeJson = $charge->jsonSerialize();

			//check whether the charge is successful
			if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1)
			{
				//order details 
				$amount = $chargeJson['amount'];
				$balance_transaction = $chargeJson['balance_transaction'];
				$currency = $chargeJson['currency'];
				$status = $chargeJson['status'];
				$date = date("Y-m-d H:i:s");
			
				
				//insert tansaction data into the database
				$dataDB = array(
					'name' => $name,
					'email' => $email, 
					'card_num' => $card_num, 
					'card_cvc' => $card_cvc, 
					'card_exp_month' => $card_exp_month, 
					'card_exp_year' => $card_exp_year, 
					'item_name' => $itemName, 
					'item_number' => $itemNumber, 
					'item_price' => $itemPrice, 
					'item_price_currency' => $currency, 
					'paid_amount' => $amount, 
					'paid_amount_currency' => $currency, 
					'txn_id' => $balance_transaction, 
					'payment_status' => $status,
					'created' => $date,
					'modified' => $date
				);
pp($dataDB);
				if ($this->db->insert('orders', $dataDB)) {
					if($this->db->insert_id() && $status == 'succeeded'){
						$data['insertID'] = $this->db->insert_id();
						$this->load->view('payment_success', $data);
						// redirect('Welcome/payment_success','refresh');
					}else{
						echo "Transaction has been failed";
					}
				}
				else
				{
					echo "not inserted. Transaction has been failed";
				}

			}
			else
			{
				echo "Invalid Token";
				$statusMsg = "";
			}
			
		}
	}
	public function handlePayment()
	{
		require_once('vendor/stripe/stripe-php/init.php');
	
		\Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
	 
		\Stripe\Charge::create ([
				"amount" => 100 * 120,
				"currency" => "inr",
				"source" => $this->input->post('stripeToken'),
				"description" => "Dummy stripe payment." 
		]);
			
		$this->session->set_flashdata('success', 'Payment has been successful.');
			 
		redirect('/make-stripe-payment', 'refresh');
	}
   
    
}
