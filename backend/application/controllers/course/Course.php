<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Course extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(["course_model", "country_model"]);
    }

    public function index()
    {
        try {

            $this->http->auth(["get"], "ADMIN");
            view("course/index", null, "Portal | Course");
        } catch (\Throwable $th) {
            redirect(base_url('course'), 'refresh');
        }
    }

    private function save_view($id = null)
    {

        if ($course = $this->course_model->get($id)) {
            view("course/create", compact("course"), "Portal | Course Edit");
        } else {
            view("course/create", null, "Portal | Course Create");
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
                            'field' => 'name',
                            'label' => 'Name',
                            'rules' => "trim|required|alpha_numeric_spaces|is_unique_custom[courses.name.{$id}.id]",
                            'errors' => array(
                                'is_unique_custom' => '%s already taken',
                            ),
                        ],
                        [
                            'field' => 'code',
                            'label' => 'Code',
                            'rules' => "trim|required|alpha_numeric_spaces|is_unique_custom[courses.code.{$id}.id]",
                            'errors' => array(
                                'is_unique_custom' => '%s already taken',
                            ),
                        ],
                        [
                            'field' => 'role',
                            'label' => 'Role',
                            'rules' => 'trim|required|in_list[free,paid]',
                            'errors' => array(
                                'in_list' => '%s select one of Free/Paid',
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
                        "name" => $p["name"],
                        "role" => $p["role"],
                        // "price" => $p["price"],
                        "description" => $p["description"],
                        "short_description" => $p["short_description"],
                        "status" => $p["status"],
                        "code" => $p["code"],
                    ];

                    if (!is_null($id)) {
                        if ($this->course_model->update($id, $d)) {
                            set_message("success", "Course updated successfully");
                        } else {
                            set_message("danger", "Course no changes found / failed");
                        }
                    } else {
                        if ($this->course_model->insert($d)) {
                            set_message("success", "Course created successfully");
                        } else {
                            set_message("danger", "Course creation failed");
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
            redirect(base_url('course'), 'refresh');
        }
    }

    public function delete($id)
    {
        try {
            $this->http->auth(["get"], "ADMIN");
            if ($this->course_model->delete($id)) {
                set_message("success", "Course deleted successfully");
            } else {
                set_message("danger", "Course dlete failed");
            }

            redirect(base_url('course'), 'refresh');
        } catch (\Throwable $th) {
            redirect(base_url('course'), 'refresh');
        }
    }

    public function get_all()
    {
        try {
            $this->http->auth(["get"], ["ADMIN", "STUDENT", "TEACHER"]);
            $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";

            if ($data = $this->course_model->get_all(1, $course_id)) {
                return $this->http->response->create(200, "Courses fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Courses not found");
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->http->response->serverError();
        }
    }
    public function get_course_price()
    {
        try {
            $this->http->auth(["get"], ["ADMIN", "STUDENT", "TEACHER"]);

            $country = $this->getRealIpAddr();
            $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";

            if ($data = $this->course_model->get_course_price(1, $country, $course_id)) {
                return $this->http->response->create(200, "Courses price fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Courses price not found");
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->http->response->serverError();
        }
    }
    //country ,ip
    function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // $ip = $_SERVER['REMOTE_ADDR'];
        //$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
        //$result = json_decode(file_get_contents("http://ip-api.io/json/{$ip}"));

        $result = json_decode(file_get_contents("http://ip-api.io/json/{$ip}"));
        //$country= $this->country_model->get_by_name($result->country_name);
        $country = $this->country_model->get_by_name($result->country_name);

        if ($country) {
            return $country;
        }
    }
    public function all_course()
    {
        try {

            $this->http->auth(["get", "post"], "ADMIN");
            $country = $this->getRealIpAddr();
            $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
            $all_course = $this->course_model->get_course_price(1, $country, $course_id);

            view("course/courses", compact("all_course"), "Portal | Course");
           
        } catch (\Throwable $th) {
            return $this->http->response->serverError();
        }
    }
    public function all_courses()
    {
        try {

            $this->http->auth(["get", "post"], "ADMIN");
            $country = $this->getRealIpAddr();
            $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
            

            if ($all_course = $this->course_model->get_course_price(1, $country, $course_id)) {
                return $this->http->response->create(200, "Courses price fetched successfully", $all_course);
            } else {
                return $this->http->response->create(203, "Courses price not found");
            }
           
        } catch (\Throwable $th) {
            return $this->http->response->serverError();
        }
    }
    public function course_details()
    {
        try {
           // $this->http->auth(["get", "post"], ["ADMIN", "STUDENT", "TEACHER"]);

            $country = $this->getRealIpAddr();
            $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";

            if ($data = $this->course_model->get_course_price(1, $country, $course_id)) {

                $html = ' <div class="flex-row row">
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div class="whatyou coursebox-body mbDM15">
                <div class="coursebox mb0">


                    <div class="course-video-height">
                        <iframe width="100%" src="//www.youtube.com/embed/cFr9iLY7zdc" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                    </div>


                </div>

            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="whatyou coursebox-body relative">
                <div class="author-block-center text-center">
                    <img class="img-circle" src="<?=base_url();?>/uploads/staff_images/default_male.jpg" alt="">
                    <span class="authornamebig">Jason Sharlton (900002301)</span>
                    <span class="descriptionbig">Last Updated <span>
                            08/05/2023 </span></span>
                </div>
                <ul class="lessonsblock ptt10 ">
                    <li><i class="fa fa-list-alt"></i>Class: Class 3 (A, C, D)</li>
                    <li>
                        <i class="fa fa-play-circle"></i>Lesson: 2
                    </li>


                    <li>
                        <i class="fa fa-clock-o"></i>04:00:00 Hrs
                    </li>
                    <li>
                        $ 170.00

                        <del>$ 200.00</del>

                    </li>
                    <li>
                        Created By: Jason Sharlton (900002301) </li>
                </ul>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="imgbottomtext">
                <h3 class="modal-title pb3 fontmedium">Classroom Management</h3>
                <p>Participants will learn classroom management strategies and skills that will benefit their students. They will learn how to create structure and routines, how to set expectations, and how to make smooth transitions from one activity to the next, plus so much more. These strategies will help to reduce the amount of down time for children thus, reducing student behavior issues in the classroom. Classroom Management will be discussed such as the following: Structure and Routines in the classroom the need and benefit of them. Knowing your students and their needs (how to incorporate those into your management system)..</p>
            </div>
        </div><!--./col-lg-9-->

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="coursecard whatyou">
                <h3 class="fontmedium">What will i learn?</h3>
                <ul class="whatlearn">
                    <li>
                        Participants will learn classroom management strategies and skills that will benefit their students. Participants will learn how to create structure and routines, how to set expectations. </li>
                </ul>
            </div><!--./coursecard-->
            <div class="coursecard ptt10">
                <h4 class="fontmedium">Curriculum for this course </h4>
                <div class="panel-group faq mb10" id="accordionplus">
                    <div class="panel panel-info">
                        <div class="panel-heading" data-toggle="collapse" data-parent="#accordionplus" data-target="#0" aria-expanded="true">
                            <h4 class="panelh3 accordion-togglelpus"><b>Section 1</b>: Classroom Management<span class="mr0"><i class="fa fa-play-circle"></i> Lesson</span></h4>
                        </div>
                        <div id="0" class="panel-collapse collapse in" aria-expanded="true">
                            <ul class="introlist">
                                <li><i class="fa fa-play-circle"></i><b>Lesson 1: </b>Classroom Management<span>02:30:00</span></li>

                                <li><i class="fa fa-play-circle"></i><b>Lesson 2: </b>Managing Your Class Room<span>01:30:00</span></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    ';
                echo $html;
            } else {
                return $this->http->response->create(203, "Courses price not found");
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->http->response->serverError();
        }
    }
}
