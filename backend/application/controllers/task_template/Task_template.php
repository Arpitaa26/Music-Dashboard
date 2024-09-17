<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Task_template extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(["task_template_model","task_model","user_model"]);
       
    }
    private function save_view($id = null)
    {
        $tasks = $this->task_template_model->get_all();
       
        $users = $this->task_template_model->get_all("ACTIVE");
        if ($task = $this->task_template_model->get($id)) {
            
            view("task_template/create", compact("task","users"), "Portal |Task Template Edit");
        } else {
            view("task_template/create", compact("users"), "Portal |Task Template Create");
        }
    }

    public function index()
    {
        try {
            
            $this->http->auth(["get"], "ADMIN");
          
            $tasks = $this->task_template_model->get_all();
            $users = $this->task_template_model->get_all();
           
            view("task_template/index", compact("tasks","users"), "Portal | Task Template");
        } catch (\Throwable $th) {
            //throw $th;
            redirect(base_url('task_template'), 'refresh');
        }
    }

    public function save($id = null)
    {
        try {
      
            $this->http->auth(["get", "post"], "ADMIN");
            if (is_post()) {
                $p = $this->http->request->all();
                $this->form_validation->set_rules(
                    [
                        [
                            'field' => 'task_title',
                            'label' => 'Task Title',
                            'rules' => 'required',
                            'errors' => array(
                                'is_exist' => '%s not exist',
                            ),
                        ],
                        [
                            'field' => 'delta_time',
                            'label' => 'Delta Time',
                            'rules' => 'trim|required'
                        ],
                        [
                            'field' => 'category',
                            'label' => 'Catecory',
                            'rules' => 'trim|required'
                        ],
                        [
                            'field' => 'status',
                            'label' => 'Status',
                            'rules' => 'required|in_list[0,1]',
                            'errors' => array(
                                'in_list' => '%s select one of Active/Inactive',
                            ),
                        ],
                        [
                            'field' => 'description',
                            'label' => 'Description',
                            'rules' => 'trim|required'
                        ]

                    ]
                );

                if ($this->form_validation->run() == true) {
                    
                    
                    $d = [
                        "title" => $p["task_title"],
                        "delta_time" =>$p["delta_time"] ,
                        "category" => $p["category"],
                        "description" => $p["description"],
                        "status" => $p["status"],
                    ];

                    if (!is_null($id)) {
                       //$d = $d[0];
                        if ($this->task_template_model->update($id, $d)) {
                            set_message("success", "Task Template updated successfully");
                        } else {
                            set_message("danger", "Task Template no changes found/failed");
                        }
                    } else {
                        if ($this->task_template_model->insert($d)) {
                            set_message("success", "Task Template created successfully");
                        } else {
                            set_message("danger", "Task Template creation failed");
                        }
                    }
                   redirect(base_url('task_template'), 'refresh');
                } else {
                    $this->save_view($id);
                }
            } else {
                $this->save_view($id);
            }
        } catch (\Throwable $th) {
           redirect(base_url('task_template'), 'refresh');
        }
    }
  
    public function get($id = null)
    {
      try {
        $this->http->auth(["get"], "ADMIN");
        if ($d = $this->task_template_model->get($id)) {
          return $this->http->response->create(200, "Task Template fetched successfully", $d);
        } else {
          return $this->http->response->create(203, "Task Template not found");
        }
      } catch (\Throwable $th) {
        return $this->http->response->serverError();
      }
    }
    public function get_all()
    {
        try {
            $this->http->auth(["get"],["ADMIN","STUDENT"]);
           
            if ($data = $this->task_template_model->get_all()) {
                return $this->http->response->create(200, "Task Template fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Task Template not found");
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
            if ($this->task_template_model->delete($id)) {
                set_message("success", "Task Template deleted successfully");
            } else {
                set_message("danger", "Task Template delete failed");
            }

            redirect(base_url('task_template'), 'refresh');
        } catch (\Throwable $th) {
            redirect(base_url('task_template'), 'refresh');
        }
    }

}
