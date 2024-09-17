<?php
defined('BASEPATH') or exit('No direct script access allowed');

//use mrmoni\base\CI_Rest;

class Country extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("country_model");
    }

    public function index()
    {
        try {

            $this->http->auth(["get"], ["ADMIN","STUDENT","TEACHER"]);
            view("country/index", null, "Portal | Course Level");
        } catch (\Throwable $th) {
            redirect(base_url('country'), 'refresh');
        }
    }

    private function save_view($id = null)
    {

        if ($country= $this->country_model->get($id)) {
            
          view("country/create", compact("country"), "Portal | Country Edit");
        } else {
          view("country/create", null, "Portal | Country Create");
         
        }
    }

    public function save($id = null)
    {
        try {
            $this->http->auth(["post", "get"], ["ADMIN","STUDENT","TEACHER"]);
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
                        "country_name" => $p["country_name"],
                        "country_code" => $p["country_code"],
                        "course_currency" => $p["course_currency"],
                        "status" =>1,
                    ];

                    if (!is_null($id)) {
                        if ($this->country_model->update($id, $d)) {
                            set_message("success", "Country updated successfully");
                        } else {
                            set_message("danger", "Country no changes found / failed");
                        }
                    } else {
                        if ($this->country_model->insert($d)) {
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
            $this->http->auth(["get"],["ADMIN","STUDENT","TEACHER"]);
            if ($data = $this->country_model->get($id)) {
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
            $this->http->auth(["get"],["ADMIN","STUDENT","TEACHER"]);
            $country =$this->getRealIpAddr();
            $country_id =$country[0]->id;
           
            if ($data = $this->country_model->get_all(1,$country_id)) {
                return $this->http->response->create(200, "Country fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Country not found");
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->http->response->serverError();
        }
    }
   
    public function get_country()
    {
        try {
            $this->http->auth(["get"],["ADMIN","STUDENT","TEACHER"]);
           
            if ($data = $this->country_model->get_country(1)) {
                return $this->http->response->create(200, "Country fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Country not found");
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->http->response->serverError();
        }
    }
   
    public function delete($id)
    {
        try {
            $this->http->auth(["get"], ["ADMIN","STUDENT","TEACHER"]);
            if ($affected_rows = $this->country_model->delete($id)) {
                return $this->http->response->create(200, "Country delete successfully");
            }
            else{
                return $this->http->response->create(203, "Country is not found / deleted");
            }
        } catch (\Throwable $th) {
            return $this->http->response->serverError();
        }
    }
    public function get_country_price()
    {
         
        try {
            $this->http->auth(["get"],["ADMIN","STUDENT","TEACHER"]);
            $country =$this->getRealIpAddr();
           // pp($country);
            if ($data = $this->country_model->get_all(1,$country[0]->country_name)) {
                return $this->http->response->create(200, "Country fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Country not found");
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->http->response->serverError();
        }
    }
   
    function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
        $ip=$_SERVER['REMOTE_ADDR'];
        }
        $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=". $ip);
        $c= $this->country_model->get_all(1,$xml->geoplugin_countryName);

         if($c){
             return $c;
         }else{
            $data= $this->country_model->get_filter(1,'Germany');
            return $data;
         }
    }

}
