<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Module extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("module_model");
        $this->load->model("course_model");
        $this->load->model("course_level_model");
    }
    private function save_view($id = null)
    {
        $course_levels = $this->course_level_model->get_all(1);
        $courses = $this->course_model->get_all(1);
        if ($module = $this->module_model->get($id)) {
            view("module/create", compact("course_levels", "courses", "module"), "Portal | Module Edit");
        } else {
            view("module/create", compact("course_levels", "courses"), "Portal | Module Create");
        }
    }

    public function index()
    {
        try {
            $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
            $course_level_id = is_numeric($this->input->get("course_level_id")) ? $this->input->get("course_level_id") : "";
            $course_levels = $this->course_level_model->get_all(1);
            $courses = $this->course_model->get_all(1);
         
            $this->http->auth(["get"],["ADMIN","SUPPORT","STUDENT"]);
            view("module/index", compact("course_levels", "courses", "course_id", "course_level_id"), "Portal | Module");
        } catch (\Throwable $th) {
            //throw $th
            redirect(base_url('module'), 'refresh');
        }
    }

    public function save($id = null)
    {
        try {
            $this->http->auth(["get", "post"],["ADMIN", "SUPPORT","STUDENT"]);
            if (is_post()) {
                $p = $this->http->request->all();
                $this->form_validation->set_rules(
                    [
                        [
                            'field' => 'course_id',
                            'label' => 'Course',
                            'rules' => 'required|numeric|is_exist[courses.id]',
                            'errors' => array(
                                'is_exist' => '%s not exist',
                            ),
                        ],
                        [
                            'field' => 'course_level_id',
                            'label' => 'Course level',
                            'rules' => 'required|numeric|is_exist[course_levels.id]',
                            'errors' => array(
                                'is_exist' => '%s not exist',
                            ),
                        ],
                        [
                            'field' => 'name[]',
                            'label' => 'Name',
                            'rules' => "trim|required|alpha_numeric_spaces|is_unique_custom[modules.name.{$id}.id]",
                            'errors' => array(
                                'is_unique_custom' => '%s already taken',
                            ),
                        ],
                        [
                            'field' => 'status[]',
                            'label' => 'Status',
                            'rules' => 'required|in_list[0,1]',
                            'errors' => array(
                                'in_list' => '%s select one of Active/Inactive',
                            ),
                        ],
                        [
                            'field' => 'description[]',
                            'label' => 'Description',
                            'rules' => 'trim|required|alpha_numeric_spaces'
                        ]

                    ]
                );

                if ($this->form_validation->run() == true) {
                    
                    $course_id = $p['course_id'];
                    $course_level_id = $p['course_level_id'];

                    $data = array_map(function ($n, $s, $d) use ($course_id, $course_level_id) {
                        return [
                            "course_id" => $course_id,
                            "course_level_id" => $course_level_id,
                            "name" => $n,
                            "status" => $s,
                            "description" => $d,
                        ];
                    }, $p['name'], $p['status'], $p['description']);

                    if (!is_null($id)) {
                        $data = $data[0];
                        if ($this->module_model->update($id, $data)) {
                            set_message("success", "Module updated successfully");
                        } else {
                            set_message("danger", "Module no changes found/failed");
                        }
                    } else {
                        if ($this->module_model->insert_batch($data)) {
                            set_message("success", "Module created successfully");
                        } else {
                            set_message("danger", "Module creation failed");
                        }
                    }
                    redirect(base_url('module'), 'refresh');
                } else {
                    $this->save_view($id);
                }
            } else {
                $this->save_view($id);
            }
        } catch (\Throwable $th) {
            redirect(base_url('module'), 'refresh');
        }
    }
  
    public function get($id = null)
    {
      try {
        $this->http->auth(["get"], ["ADMIN","SUPPORT","STUDENT"]);
        if ($d = $this->module_model->get($id)) {
          return $this->http->response->create(200, "Module fetched successfully", $d);
        } else {
          return $this->http->response->create(203, "Module  not found");
        }
      } catch (\Throwable $th) {
        return $this->http->response->serverError();
      }
    }
    public function get_all()
    {
        try {
            $this->http->auth(["get"],["ADMIN","SUPPORT","STUDENT","TEACHER"]);
            $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
            $course_level_id = is_numeric($this->input->get("course_level_id")) ? $this->input->get("course_level_id") : "";
          
            if ($data = $this->module_model->get_all(1, $course_id, $course_level_id)) {
                return $this->http->response->create(200, "Module fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Module not found");
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->http->response->serverError();
        }
    }

    public function delete($id)
    {
        try {
            $this->http->auth(["get"], ["ADMIN", "SUPPORT"]);
            if ($this->module_model->delete($id)) {
                set_message("success", "Module deleted successfully");
            } else {
                set_message("danger", "Module delete failed");
            }

            redirect(base_url('module'), 'refresh');
        } catch (\Throwable $th) {
            redirect(base_url('module'), 'refresh');
        }
    }

    //update orders
  public function updateOrder()
  {
    try {
      $this->http->auth(["post"], ["ADMIN", "SUPPORT"]);
      $p = $this->http->request->all();
      if (!is_null($p['ids'])) {
        $data = explode(",", $p['ids']);
        if ($d =$this->module_model->updateOrder($data)) {
          return $this->http->response->create(200, "Order  successfully", $d);
        } else {
          return $this->http->response->create(203, "Order failed");
        }
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }
}
