<?php
defined('BASEPATH') or exit('No direct script access allowed');

//use mrmoni\base\CI_Rest;

class Price extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
      
        $this->load->model(["price_model", "course_level_model", "country_model","session_type_model"]);
    }

    public function index()
    {
        try {
            $this->http->auth(["get"], "ADMIN");
            $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
            $course_levels = $this->course_level_model->get_all(1);
            $session_types = $this->session_type_model->get_all(1);
            $countries = $this->country_model->get_all(1);
            $price  = $this->price_model->get_all(1,$course_id);
            $price_by_country = array();
            foreach ($price as $element) {
                if (!isset($price_by_country[$element->country_id])) 
                    $price_by_country[$element->country_id] = [];
                if (!isset($price_by_country[$element->country_id][$element->course_level_id])) 
                    $price_by_country[$element->country_id][$element->course_level_id] = [];
            
                   $price_by_country[$element->country_id][$element->course_level_id][$element->session_type_id] = [
                    "cost_per_class" => $element->cost_per_class
                ];
            }

          
         
            view("price/create",compact("course_levels" ,"countries","session_types","course_id","price","price_by_country"), "Portal | Price");
        } catch (\Throwable $th) {

         
            redirect(base_url('price'), 'refresh');
        }
    }

    private function save_view($id = null)
    {

        if ($id) {
            $course_levels = $this->course_level_model->get_all(1);
            $session_types = $this->session_type_model->get_all(1);
            $countries = $this->country_model->get_all(1);
            $price  = $this->price_model->get_all(1,$id);
            $price_by_country = array();
            foreach ($price as $element) {
                if (!isset($price_by_country[$element->country_id])) 
                    $price_by_country[$element->country_id] = [];
                if (!isset($price_by_country[$element->country_id][$element->course_level_id])) 
                    $price_by_country[$element->country_id][$element->course_level_id] = [];
            
                   $price_by_country[$element->country_id][$element->course_level_id][$element->session_type_id] = [
                    "cost_per_class" => $element->cost_per_class
                ];
            }
            view("price/create", compact("course_levels" ,"countries","session_types","course_id","price","price_by_country"), "Portal | Price Edit");
        } else {
            
            view("price/create",compact("course_levels" ,"countries","session_types","course_id","price"), "Portal | Price Create");
        }
    }

    public function save($id = null)
    {
        try {
            $this->http->auth(["post", "get"], "ADMIN");
            $p = $this->http->request->all();
           
            if (is_post()) {
                if (isset($p['cost_per_class'])) {
                foreach ($p['cost_per_class'] as $key => $row) {
                $this->form_validation->set_rules(
                    [
                        [
                            'field' => 'cost_per_class[' . $key . ']',
                            'label' => 'price',
                            'rules' => "trim|required|numeric",
                           
                        ],
                        [
                            'field' => 'session_type_id[' . $key . ']',
                            'label' => 'Session Type',
                            'rules' => "trim|required|numeric",
                           
                        ],
                        [
                            'field' => 'country_id[' . $key . ']',
                            'label' => 'Country',
                            'rules' => "trim|required|numeric",
                           
                        ],
                        [
                            'field' => 'course_level_id[' . $key . ']',
                            'label' => 'Level',
                            'rules' => "trim|required|numeric",
                           
                        ],
                        [
                            'field' => 'course_id[' . $key . ']',
                            'label' => 'Course',
                            'rules' => 'required|numeric',
                            
                        ]
                    ]
                );
            }
        }
                if ($this->form_validation->run() == TRUE) {

                    $status=1;
                    $data = array_map(function ($c, $cl,$cc,$s,$cr) use ($status) {
                        return [
                            "course_id" => $c,
                            "course_level_id" => $cl,
                            "country_id" => $cr,
                            "session_type_id" => $s,
                            "cost_per_class" => $cc,
                            "status" => $status,
                        ];
                    }, $p['course_id'],$p['course_level_id'], $p['cost_per_class'], $p['session_type_id'], $p['country_id']);

           
                    if (!is_null($id)) {

                     
                            $this->price_model->delete_batch($id);
                            $this->price_model->insert_batch($data);
                            set_message("success", "Price updated successfully");
                       
                    } else {
                        if ($this->price_model->insert_batch($data)) {
                            set_message("success", "Price created successfully");
                        } else {
                            set_message("danger", "Price creation failed");
                        }
                    }

                    redirect(base_url('course'), 'refresh');
                } else {
                    $this->save_view($id);
                }
            } else {
                $this->save_view($id);
            }
        } catch (\Throwable $th) {
           redirect(base_url('price'), 'refresh');
         
        }
    }


    public function get($id)
    {
        try {
            $this->http->auth(["get"], "ADMIN");
            if ($data = $this->price_model->get($id)) {
                return $this->http->response->create(200, "Price fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Price not found of given id");
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
            $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
            $country =$this->getRealIpAddr();
        
          
         
            if ($data = $this->price_model->get_all(1,$course_id,$country->id)) {
                return $this->http->response->create(200, "Price fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Price not found");
            }
      
        } catch (\Throwable $th) {
            //throw $th;
            return $this->http->response->serverError();
        }
    }
   
    public function delete($id)
    {
        try {
            $this->http->auth(["get"], "ADMIN");
            if ($affected_rows = $this->price_model->delete($id)) {
                return $this->http->response->create(200, "Price delete successfully");
            }
            else{
                return $this->http->response->create(203, "Price is not found / deleted");
            }
        } catch (\Throwable $th) {
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
