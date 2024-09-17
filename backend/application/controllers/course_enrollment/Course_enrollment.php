<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Course_enrollment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(["course_enrollment_model","course_performance_model", "session_type_model","course_level_model", "user_model", "course_model", "batch_model"]);
    }
    private function save_view($id = null)
    {
        $users = $this->user_model->get_all("active", 5);
        $courses = $this->course_model->get_all(1);
        $course_levels = $this->course_level_model->get_all(1);
        $session_types = $this->session_type_model->get_all(1);
        $batches = $this->batch_model->get_all(1);
        if ($course_enrollment = $this->course_enrollment_model->get($id)) {
            view("course_enrollment/create", compact("users", "courses", "batches","course_enrollment","session_types", "course_levels"), "Portal | Course Enrollment Edit");
        } else {
            view("course_enrollment/create", compact("courses", "users", "batches","course_levels","session_types"), "Portal | Course Enrollment Create");
        }
    }

    public function index()
    {
        try {
            $s = $this->http->auth(["get"], "ADMIN");

            $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
            $course_level_id = is_numeric($this->input->get("course_level_id")) ? $this->input->get("course_level_id") : "";
            $user_id = is_numeric($this->input->get("user_id")) ? $this->input->get("user_id") : "";
            $batch_id = is_numeric($this->input->get("batch_id")) ? $this->input->get("batch_id") : "";
            $status = is_numeric($this->input->get("status")) ? $this->input->get("status") : "";
            $users = $this->user_model->get_all("active", 5);
            $course_levels = $this->course_level_model->get_all(1);
            $courses = $this->course_model->get_all(1);
            $batches = $this->batch_model->get_all(1);

            view("course_enrollment/index", compact("courses","batches", "users","course_levels" ,"batch_id","course_id","course_level_id", "user_id","status"), "Portal | Course Enrollment");
        } catch (\Throwable $th) {
            redirect(base_url('course_enrollment'), 'refresh');
        }
    }

    public function save($id = null)
    {
        try {
            $this->http->auth(["get", "post"], "ADMIN");
            $p = $this->http->request->all();
            

            if (is_post()) {
                $course_level_id = $p['course_level_id'];
                $course_id = $p['course_id'];
                $user_id = $p['user_id'];
                
               
                $this->form_validation->set_rules(
                    [
                        [
                            'field' => 'user_id',
                            'label' => 'User',
                            'rules' => 'required|numeric|is_exist[users.id]',
                            'errors' => array(
                                'is_exist' => '%s not exist',
                            ),
                        ],
                        [
                            'field' => 'id',
                            'label' => 'Course',
                            'rules' => "required|numeric|is_unique_custom_multi[courses_enrollment.id.user_id::course_id::course_level_id.{$user_id}::{$course_id}::{$course_level_id}]",
                            'errors' => array(
                                'is_unique_custom_multi' => '%s already taken',
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
                            'field' => 'category',
                            'label' => 'Category',
                            'rules' => 'required|in_list[CLUSTER,ONE_ON_ONE]',
                        ],

                        [
                            'field' => 'referral_code_used',
                            'label' => 'Referral Code',
                            'rules' => ''
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
                if ($this->form_validation->run() == true) {




                    if (empty($p['batch_id'])) {
                        $data = [
                            "user_id" => $p['user_id'],
                            "course_id" => $p['course_id'],
                            "course_level_id" => $p['course_level_id'],
                            "referral_code_used" => $p['referral_code_used'],
                            "category" => $p['category'],
                            "status" => $p['status'],
                        ];
                        $performance_data= [
                            "user_id" => $p['user_id'],
                            "course_id" => $p['course_id'],
                            "course_level_id" => $p['course_level_id'],
                            "session_type" => $p['category'],
                            "status" => $p['status'],
                        ];
                    } else {
                        $data = [
                            "user_id" => $p['user_id'],
                            "batch_id" => $p['batch_id'],
                            "course_id" => $p['course_id'],
                            "course_level_id" => $p['course_level_id'],
                            "referral_code_used" => $p['referral_code_used'],
                            "category" => $p['category'],
                            "status" => $p['status'],
                        ];
                        
                    }
                    if (!is_null($id)) {
                        if ($this->course_enrollment_model->update($id, $data)) {
                            $this->course_performance_model->update_performance($id,$performance_data);
                            set_message("success", "Course Enrollment updated successfully");
                        } else {
                            set_message("danger", "Course Enrollment no changes found/failed");
                        }
                    } else {
                        if ($en_id=$this->course_enrollment_model->insert($data)) {
                            $performance_data= [
                                "enrollment_id" =>$en_id,
                                "user_id" => $p['user_id'],
                                "batch_id" => $p['batch_id'],
                                "course_id" => $p['course_id'],
                                "course_level_id" => $p['course_level_id'],
                                "session_type" => $p['category'],
                                "status" => $p['status'],
                            ];
                            $this->course_performance_model->insert($performance_data);
                            set_message("success", "Course Enrollment created successfully");
                        } else {
                            set_message("danger", "Course Enrollment creation failed");
                        }
                    }
                    redirect(base_url('course_enrollment'), 'refresh');
                } else {
                    $this->save_view($id);
                }
            } else {
                $this->save_view($id);
            }
        } catch (\Throwable $th) {
            redirect(base_url('course_enrollment'), 'refresh');
        }
    }

    public function get_all()
    {

        try {
            $u = $this->http->auth("get", ["ADMIN", "SUPPORT", "STUDENT", "TEACHER"]);
            if ($u->type == "SUPPORT" || $u->type == "ADMIN") {
                if ($this->input->get("self") == "true") {
                    $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
                    $course_level_id = is_numeric($this->input->get("course_level_id")) ? $this->input->get("course_level_id") : "";
                    $user_id =is_numeric($this->input->get("user_id")) ? $this->input->get("user_id") : "";
                    $batch_id = is_numeric($this->input->get("batch_id")) ? $this->input->get("batch_id") : "";
                    $teacher_id = null;
                    $status = is_numeric($this->input->get("status")) ? $this->input->get("status") :"1";
                  
                } else {
                    $status = is_numeric($this->input->get("status")) ? $this->input->get("status") :"1";
                   
                    $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
                    $course_level_id = is_numeric($this->input->get("course_level_id")) ? $this->input->get("course_level_id") : "";
                    $user_id =  is_numeric($this->input->get("user_id")) ? $this->input->get("user_id") : "";
                    $batch_id = is_numeric($this->input->get("batch_id")) ? $this->input->get("batch_id") : "";
                    $teacher_id = null;
                  
                }
            } elseif ($u->type == "TEACHER") {
                $teacher_id = $u->id;
                $status = is_numeric($this->input->get("status")) ? $this->input->get("status") :"1";
                $user_id = is_numeric($this->input->get("user_id")) ? $this->input->get("user_id") : "";
                $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
                $course_level_id = is_numeric($this->input->get("course_level_id")) ? $this->input->get("course_level_id") : "";
                $batch_id = is_numeric($this->input->get("batch_id")) ? $this->input->get("batch_id") : "";
              } else {
                $teacher_id = null;
                $user_id =$u->id;
                $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
                $course_level_id = is_numeric($this->input->get("course_level_id")) ? $this->input->get("course_level_id") : "";
                $batch_id = is_numeric($this->input->get("batch_id")) ? $this->input->get("batch_id") : "";
                $status = is_numeric($this->input->get("status")) ? $this->input->get("status") :"1";
            }
          
            if ($data = $this->course_enrollment_model->get_all($status, $user_id, $course_id,$course_level_id,$batch_id,$teacher_id)) {
                return $this->http->response->create(200, "Course Enrollment fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Course Enrollment batches not found");
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->http->response->serverError();
        }
    }
    public function get_batch_students()
    {
        try {
            $u = $this->http->auth("get", ["ADMIN", "SUPPORT", "STUDENT", "TEACHER"]);
            if ($u->type == "SUPPORT" || $u->type == "ADMIN") {
                if ($this->input->get("self") == "true") {
                    $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
                    $course_level_id = is_numeric($this->input->get("course_level_id")) ? $this->input->get("course_level_id") : "";
                    $user_id =null;
                    $batch_id = is_numeric($this->input->get("batch_id")) ? $this->input->get("batch_id") : "";
                } else {
                    $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
                    $course_level_id = is_numeric($this->input->get("course_level_id")) ? $this->input->get("course_level_id") : "";
                    $user_id = null;
                    $batch_id = is_numeric($this->input->get("batch_id")) ? $this->input->get("batch_id") : "";
                }
            } else {
                
                $user_id =$u->id;
                $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
                $course_level_id = is_numeric($this->input->get("course_level_id")) ? $this->input->get("course_level_id") : "";
                $batch_id = is_numeric($this->input->get("batch_id")) ? $this->input->get("batch_id") : "";
            }
           
            if ($data = $this->course_enrollment_model->get_batch_students(1, $user_id, $course_id,$course_level_id,$batch_id)) {
                return $this->http->response->create(200, "Course Enrollment fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Course Enrollment batches not found");
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
            if ($this->course_enrollment_model->delete($id)) {
                set_message("success", "Course Enrollment deleted successfully");
            } else {
                set_message("danger", "Course Enrollment batch delete failed");
            }

            redirect(base_url('course_enrollment'), 'refresh');
        } catch (\Throwable $th) {
            redirect(base_url('course_enrollment'), 'refresh');
        }
    }
  

}
