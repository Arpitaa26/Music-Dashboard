<?php
defined('BASEPATH') or exit('No direct script access allowed');

//use mrmoni\base\CI_Rest;

class Course_level extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(["course_level_model", "module_model", "batch_model", "question_model"]);
    }

    public function index()
    {
        try {

            $this->http->auth(["get"], "ADMIN");
            view("course_level/index", null, "Portal | Course Level");
        } catch (\Throwable $th) {
            redirect(base_url('course_level'), 'refresh');
        }
    }

    private function save_view($id = null)
    {

        if ($course_level = $this->course_level_model->get($id)) {

            view("course_level/create", compact("course_level"), "Portal | Course_level Edit");
        } else {
            view("course_level/create", null, "Portal | Course_level Create");
        }
    }

    public function save($id = null)
    {
        try {
            $this->http->auth(["post", "get"], "ADMIN");

            if (is_post()) {
                $this->form_validation->set_rules(
                    [
                        [
                            'field' => 'level',
                            'label' => 'Level',
                            'rules' => "trim|required|alpha_numeric_spaces|is_unique_custom[course_levels.level.{$id}.id]",
                            'errors' => array(
                                'is_unique_custom' => '%s already taken',
                            ),
                        ],
                        [
                            'field' => 'description',
                            'label' => 'Description',
                            'rules' => "trim|required|alpha_numeric_spaces",
                            'errors' => array(
                                'is_unique_custom' => '%s already taken',
                            ),
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

                    $p =  $this->http->request->all();

                    $d = [
                        "level" => $p["level"],
                        "description" => $p["description"],
                        "status" => $p["status"],
                    ];

                    if (!is_null($id)) {
                        if ($this->course_level_model->update($id, $d)) {
                            set_message("success", "Course Level updated successfully");
                        } else {
                            set_message("danger", "Course Level no changes found / failed");
                        }
                    } else {
                        if ($this->course_level_model->insert($d)) {
                            set_message("success", "Course Level created successfully");
                        } else {
                            set_message("danger", "Course Level creation failed");
                        }
                    }

                    redirect(base_url('course_level'), 'refresh');
                } else {
                    $this->save_view($id);
                }
            } else {
                $this->save_view($id);
            }
        } catch (\Throwable $th) {
            redirect(base_url('course_level'), 'refresh');
        }
    }

    public function saves()
    {
        try {
            $this->http->auth(["get", "post"], "ADMIN");
            $p =  $this->http->request->all();
            $d = [
                "level" => $p["level"],
                "description" => $p["description"],
                "status" => $p["status"],
            ];

            if ($this->course_level_model->insert($d)) {
                return $this->http->response->create(200, "Course Level has been created successfully");
            } else {
                return $this->http->response->create(203, "Course Level creation failed");
            }
        } catch (\Throwable $th) {
            return $this->http->response->serverError();
        }
    }
    public function get($id)
    {
        try {
            $this->http->auth(["get"], "ADMIN");
            if ($data = $this->course_level_model->get($id)) {
                return $this->http->response->create(200, "Course Level fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Course Level not found of given id");
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->http->response->serverError();
        }
    }
    public function get_all()
    {
        try {
            $this->http->auth(["get"], ["ADMIN", "STUDENT", "TEACHER"]);
            $course_level_id = is_numeric($this->input->get("course_level_id")) ? $this->input->get("course_level_id") : "";
            if ($data = $this->course_level_model->get_all(1, $course_level_id)) {
                return $this->http->response->create(200, "Course Levels fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Course Levels not found");
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->http->response->serverError();
        }
    }
    public function update($id)
    {
        try {
            $this->http->auth(["get"], "ADMIN");
            $p =  $this->http->request->all();
            $d = [
                "level" => $p["level"],
                "description" => $p["description"],
                "status" => $p["status"],
            ];
            if ($affected_rows = $this->course_level_model->update($id, $d)) {
                return $this->http->response->create(200, "Course Level updated successfully");
            } else {
                return $this->http->response->create(203, "Course Level no changes found / failed");
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
            $modules = $this->module_model->get_all(1, null, $id);
            $batches = $this->batch_model->get_all(1, null, $id);

            if (isset($modules[0]->id) && (isset($batches[0]->id))) {
                $question = $this->question_model->get_all(1, $batches[0]->id);
                if (empty($question)) {

                    $affected_rows = $this->course_level_model->delete($id);
                    return $this->http->response->create(200, "Course Level delete successfully");
                } else {
                    set_message("danger", "Course Level delete / failed. exist this level modules, batches and question");
                    redirect(base_url('course_level'), 'refresh');
                }
            } else {
                $this->course_level_model->delete($id);
                set_message("danger", "Course Level delete successfully.");
                redirect(base_url('course_level'), 'refresh');
            }
        } catch (\Throwable $th) {
            return $this->http->response->serverError();
        }
    }
     //update orders
  public function updateOrder()
  {
    try {
      $this->http->auth(["post","get"], ["ADMIN", "SUPPORT"]);
      $p = $this->http->request->all();
      if (!is_null($p['ids'])) {
        $data = explode(",", $p['ids']);
       
        if ($d =$this->course_level_model->updateOrder($data)) {
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
