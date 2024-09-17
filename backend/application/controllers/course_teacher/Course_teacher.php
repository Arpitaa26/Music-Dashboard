<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Course_teacher extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(["user_model", "course_model", "course_teacher_model"]);
    }
    private function save_view($id = null)
    {

$users = $this->user_model->get_all("active", 4,$id );
        $courses = $this->course_model->get_all(1);
        if ($id) {
            $course_teacher = $this->course_teacher_model->get_all(1, $id);
            if (!empty($course_teacher)) {
                $teachers = $this->course_teacher_model->get($course_teacher[0]->id);
                $course_teacher_map = array_map(function ($c_id) {
                    return (object)[
                        "course_id" => $c_id->course_id
                    ];
                }, $course_teacher);
                view("course_teacher/create", compact("users", "courses", "course_teacher_map", "course_teacher", "teachers"), "Portal | Teacher's Course Edit");
            }else {
                redirect(base_url('user?user_type_id=4'), 'refresh');
            }

        } else {
            redirect(base_url('user?user_type_id=4'), 'refresh');
        }
      
    }

    public function index()
    {
        try {

            $this->http->auth(["get"], "ADMIN");
            redirect(base_url('user?user_type_id=4'), 'refresh');
        } catch (\Throwable $th) {
            redirect(base_url('user?user_type_id=4'), 'refresh');
        }
    }

    public function save($id = null)
    {
        try {

           $this->http->auth(["get", "post"], "ADMIN");
            if (is_post()) {
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
                            'field' => 'course_id[]',
                            'label' => 'Courses',
                            'rules' => 'required|numeric|is_exist[courses.id]',

                        ],
                        [
                            'field' => 'is_accepted_for_course',
                            'label' => 'Is Accepted',
                            'rules' => 'required|in_list[0,1]',
                            'errors' => array(
                                'in_list' => '%s select one of Yes/No',
                            ),
                        ],
                        [
                            'field' => 'status',
                            'label' => 'Status',
                            'rules' => 'required|in_list[0,1]',
                            'errors' => array(
                                'in_list' => '%s select one of Active/Inactive',
                            ),
                        ],
                    ]
                );

                if ($this->form_validation->run() == true) {
                    $p = $this->http->request->all();
                    $u_id = $p['user_id'];
                    $is = $p['is_accepted_for_course'];
                    $s = $p['status'];
                    $data = array_map(function ($c_id) use ($u_id, $is, $s) {
                        return [
                            "user_id" => $u_id,
                            "course_id" => $c_id,
                            "is_accepted_for_course" => $is,
                            "status" => $s,
                        ];
                    }, $p['course_id']);

                    if (!is_null($id)) {

                        if ($this->course_teacher_model->delete_course($id)) {
                            $this->course_teacher_model->insert_batch($data);
                            set_message("success", "Teacher course updated successfully");
                        } else {
                            set_message("danger", "Teacher course no changes found/failed");
                        }
                    } else {
                        if ($this->course_teacher_model->insert_batch($data)) {
                            set_message("success", "Teacher's course created successfully");
                        } else {
                            set_message("danger", "Teacher's course creation failed");
                        }
                    }
                    redirect(base_url('user?user_type_id=4'), 'refresh');
                } else {
                    $this->save_view($id);
                }
            } else {
                $this->save_view($id);
            }
        } catch (\Throwable $th) {
            $this->save_view($id);
        }
    }

    public function get_all()
    {
        try {

            $this->http->auth(["get"], ["ADMIN", "SUPPORT"]);

            $user_id = is_numeric($this->input->get("user_id")) ? $this->input->get("user_id") : "";
            $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
            if ($data = $this->course_teacher_model->get_all(1, $user_id, $course_id)) {

                return $this->http->response->create(200, "Teacher's course fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Teacher's course not found");
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
            if ($this->course_teacher_model->delete($id)) {
                set_message("success", "Teacher's course deleted successfully");
            } else {
                set_message("danger", "Teacher's course delete failed");
            }

            redirect(base_url('course_teacher'), 'refresh');
        } catch (\Throwable $th) {
            redirect(base_url('course_teacher'), 'refresh');
        }
    }
}
