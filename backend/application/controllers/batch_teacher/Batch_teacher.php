<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Batch_teacher extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(["user_model", "batch_model", "course_teacher_model", "module_model", "batch_teacher_model"]);
    }

    private function save_view($id = null)
    {

        if ($batches = $this->batch_model->get($id)) {

            $batch_teacher = array_column($this->batch_teacher_model->get_all(1, $id), "user_id", "module_id");

            $modules = $this->module_model->get_all(1, $batches->course_id);

            $teachers = $this->course_teacher_model->get_all(1, null, $batches->course_id);

            view("batch_teacher/create", compact("batches", "batch_teacher", "modules", "teachers"), "Portal | Teacher Batch Edit");
        } else {
            view("Batch/index", null, "Portal | Batch");
        }
    }

    public function index()
    {
        try {
            $this->http->auth(["get"], "ADMIN");
            view("batch_teacher/index", null, "Portal | Teacher Batch");
        } catch (\Throwable $th) {
            redirect(base_url('batch'), 'refresh');
        }
    }

    public function save($id = null)
    {
        try {
            $this->http->auth(["get", "post"], "ADMIN");
            if (is_post()) {
                $p = $this->http->request->all();

                foreach ($p['module_id'] as $key => $row) {
                    $this->form_validation->set_rules(
                        [

                            [
                                'field' => 'module_id[' . $key . ']',
                                'label' => 'Module',
                                'rules' => 'required',

                            ],
                            [
                                'field' => 'status[' . $key . ']',
                                'label' => 'status',
                                'rules' => 'required',

                            ]

                        ]
                    );
                }


                if ($this->form_validation->run() == TRUE) {
                    $data = array_map(function ($m, $u, $s) use ($id) {
                        return [
                            "module_id" => $m,
                            "batch_id" => $id,
                            "user_id" => ($u == "" ? NULL : $u),
                            "status" => $s,
                        ];
                    }, $p['module_id'], $p['user_id'], $p['status']);

                    if (!is_null($id)) {

                        if ($id) {
                            $this->batch_teacher_model->delete_batch($id);
                            $this->batch_teacher_model->insert_batch($data);
                            set_message("success", "Teacher batches updated successfully");
                        } else {
                            set_message("danger", "Teacher batches no changes found/failed");
                        }
                    }
                    redirect(base_url('batch'), 'refresh');
                } else {

                    $this->save_view($id);
                }
            } else {
                $this->save_view($id);
            }
        } catch (\Throwable $th) {
            redirect(base_url('batch'), 'refresh');
        }
    }

    public function get_all()
    {
        try {
     $u = $this->http->auth("get", ["ADMIN", "SUPPORT","TEACHER","STUDENT"]);
      if ($u->type == "SUPPORT" || $u->type == "ADMIN") {
        if ($this->input->get("self") == "true") {
        $user_id = $u->id;
        $batch_id= !empty($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
        } else {
        $user_id = !empty($this->input->get('user_id')) ? $this->input->get('user_id') : null;
        $batch_id= !empty($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
        }
      }else {
        $user_id=$u->id;
        $batch_id= !empty($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
      }

            if ($data = $this->batch_teacher_model->get_all(1,$batch_id,$user_id)) {
                return $this->http->response->create(200, "Teacher's batches fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Teacher's batches not found");
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
            if ($this->batch_teacher_model->delete($id)) {
                set_message("success", "Teacher's batch deleted successfully");
            } else {
                set_message("danger", "Teacher's batch delete failed");
            }

            redirect(base_url('batch_teacher'), 'refresh');
        } catch (\Throwable $th) {
            redirect(base_url('batch_teacher'), 'refresh');
        }
    }
}
