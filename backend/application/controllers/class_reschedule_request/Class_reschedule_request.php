<?php
defined('BASEPATH') or exit('No direct script access allowed');

//use mrmoni\base\CI_Rest;

class Class_reschedule_request extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(["class_reschedule_request_model", "user_availability_model", "course_enrollment_model", "scheduled_class_model", "course_teacher_model"]);
    }
    public function index()
    {
        try {
           
            //*********testing last date and First date class request*********** */

            //  $request_date= date('Y-m-d', strtotime('2023-10-02'));//chnges date
            //  $previous_month_last_date=date('Y-m-t', strtotime(" -1 month",strtotime($request_date)));
            //  $previous_month=date('Y-m', strtotime(" -1 month",strtotime($request_date)));
            //  $request_month=date('Y-m', strtotime($request_date));
            //  $request_month_first_date=date('Y-m-01', strtotime($request_date));

            //  $rescheduled = $this->scheduled_class_model->get_filter('19',$request_month,'RESCHEDULED');//change user_id
            //  $previous_rescheduled = $this->scheduled_class_model->get_filter('19',$previous_month,'RESCHEDULED');
            //  $rescheduled_date=isset($previous_rescheduled->rescheduled_date)?date('Y-m-d', strtotime($previous_rescheduled->rescheduled_date)):'';
            //  $rescheduled_month=date('Y-m', strtotime($rescheduled_date));
            //  if(($rescheduled)||(($previous_month_last_date==$rescheduled_date)&&($request_month_first_date== $request_date)))
            //  {
            //      return $this->http->response->create(203, "Rescheduled class request does not availabe");
            //  }
            //  else{
            //      return $this->http->response->create(200, "Rescheduled class insert");
            //  }
            //******************** */


            $u = $this->http->auth(["get", "post"], ["STUDENT", "TEACHER", "ADMIN", "SUPPORT"]);
            $type = is_numeric($this->input->get("user_type_id")) ? $this->input->get("user_type_id") : "";
            $user_id = is_numeric($this->input->get("user_id")) ? $this->input->get("user_id") : "";
            $users = $this->user_model->get_all("active", null);
            view("class_reschedule_request/index", compact("users","user_id"), "Portal | Class rescheduled request");
        } catch (\Throwable $th) {
            redirect(base_url('class_reschedule_request'), 'refresh');
        }
    }






    public function save($id = null)
    {


        try {

            $user = $this->http->auth(["get", "post"], ["STUDENT", "TEACHER", "ADMIN", "SUPPORT"]);
            $p =  $this->http->request->all();

            if ($user->type == "TEACHER" || $user->type == "SUPPORT" || $user->type == "ADMIN") {
                // ************* for TEACHER rescheduled request ************/
                $this->form_validation->set_rules(
                    [
                        [
                            'field' => 'class_id',
                            'label' => 'Class',
                            'rules' => "trim|required|is_exist[scheduled_classes.id]",
                            'errors' => array(
                                'is_exist' => '%s is not exits',
                            ),
                        ],
                        [
                            'field' => 'availability_id',
                            'label' => 'Availability',
                            'rules' => "trim|required",

                        ],
                        [
                            'field' => 'reason_for_reschedule',
                            'label' => 'Reason for reschedule',
                            'rules' => 'trim|required|alpha_numeric_spaces',
                        ],
                    ]
                );

                if ($this->form_validation->run() == TRUE) {
                    $class = $this->scheduled_class_model->get($p['class_id']);

                    if ($this->course_teacher_model->get_filter($class->batch_id, $user->id, 1) || $user->type == "SUPPORT" || $user->type == "ADMIN") {
                        //if teacher and  || admin || support
                        $new_availability = $this->user_availability_model->get($p['availability_id']);

                        if ($this->scheduled_class_model->update($class->id, ["status" => "RESCHEDULED", "rescheduled_by" => $user->id, "rescheduled_by_name" => $user->full_name, "rescheduled_date" => $new_availability->from])) { //, rescheduled_by=>$user->id, rescheduled_date => $new_availability->start_time]
                            $d = [
                                "user_id" => $user->id,
                                "class_id" => $p["class_id"],
                                "availability_id" => $p["availability_id"],
                                "reason_for_reschedule" => $p["reason_for_reschedule"],
                                "rescheduled_date" => $new_availability->from,
                                "status" => "0",
                            ];
                            if ($reschedule_request_id = $this->class_reschedule_request_model->insert($d)) {
                                $this->change_status($reschedule_request_id);
                                return $this->http->response->create(200, "Class rescheduled request create successfully");
                            } else {
                                return $this->http->response->create(203, "Class rescheduled request creation failed");
                            }
                        } else {
                            return $this->http->response->create(203, "Class rescheduled request creation failed / Class status changes failed");
                        }
                    } else {
                        return $this->http->response->create(203, "User not exit in this class");
                    }
                } else {
                    $form_errors = $this->form_validation->error_array();
                    return $this->http->response->create(203, "Form validation error", $form_errors);
                }
            } else {
                // ************* for STUDENT rescheduled request ************/
               
                $this->form_validation->set_rules(
                    [
                        [
                            'field' => 'class_id',
                            'label' => 'Class',
                            'rules' => "trim|required|is_exist[scheduled_classes.id]",
                            'errors' => array(
                                'is_exist' => '%s is not exits',
                            ),
                        ],
                        [
                            'field' => 'availability_id',
                            'label' => 'Availability',
                            'rules' => "trim|required",

                        ],
                        [
                            'field' => 'reason_for_reschedule',
                            'label' => 'Reason for reschedule',
                            'rules' => 'trim|required|alpha_numeric_spaces',
                        ],

                        // User_availability id mandatory
                    ]
                );

                if ($this->form_validation->run() == TRUE) {
                    $new_availability = $this->user_availability_model->get($p['availability_id']);
                    $class = $this->scheduled_class_model->get($p['class_id']);

                   //***********condition last date and first date */
                   $request=date('Y-m-d', strtotime($new_availability->from));
                    $request_date= date('Y-m-d', strtotime($new_availability->from));//chnges date
                    $previous_month_last_date=date('Y-m-t', strtotime(" -1 month",strtotime($request_date)));
                    $previous_month=date('Y-m', strtotime(" -1 month",strtotime($request_date)));
                    $request_month=date('Y-m', strtotime($request_date));
                    $request_month_first_date=date('Y-m-01', strtotime($request_date));

                    $rescheduled = $this->scheduled_class_model->get_filter($user->id,$request_month,'RESCHEDULED');//change user_id
                    $previous_rescheduled = $this->scheduled_class_model->get_filter('19',$previous_month,'RESCHEDULED');
                    $rescheduled_date=isset($previous_rescheduled->rescheduled_date)?date('Y-m-d', strtotime($previous_rescheduled->rescheduled_date)):'';
                    $rescheduled_month=date('Y-m', strtotime($rescheduled_date));
                    if(($rescheduled)||(($previous_month_last_date==$rescheduled_date)&&($request_month_first_date== $request_date)))
                    {
                        return $this->http->response->create(203, "Rescheduled class request does not availabe");
                    }
                    else{ //***********condition last date and first date */
                    if ($this->course_enrollment_model->get_filter($class->batch_id, $user->id, 1)) {

                       // $new_availability = $this->user_availability_model->get($p['availability_id']);

                        $d = [
                            "user_id" => $user->id,
                            "class_id" => $p["class_id"],
                            "availability_id" => $p["availability_id"],
                            "reason_for_reschedule" => $p["reason_for_reschedule"],
                            "rescheduled_date" => $new_availability->from, //should be from DB using availability_id
                            "status" => "0",
                        ];
                        //update
                        if (!is_null($id)) {
                            if ($this->class_reschedule_request_model->update($id, $d)) {

                                return $this->http->response->create(200, "Rescheduled class request updated successfully");
                            } else {
                                return $this->http->response->create(203, "Rescheduled class request no changes found / failed");
                            }
                        } else {
                            //insert
                            if ($this->class_reschedule_request_model->insert($d)) {

                                return $this->http->response->create(200, "Rescheduled class request has been created successfully");
                            } else {
                                return $this->http->response->create(203, "Rescheduled class request creation failed");
                            }
                        }
                    } else {
                        return $this->http->response->create(203, "Student does not exit in this class");
                    }

                }
                } else {
                    $form_errors = $this->form_validation->error_array();
                    return $this->http->response->create(203, "Form validation error", $form_errors);
                }
            }
        } catch (\Throwable $th) {
            return $this->http->response->serverError();
        }
    }
    public function approved_status($id = null)
    {
        try {
            $user = $this->http->auth(["get", "post"], ["ADMIN", "TEACHER"]);
            $get_data =  $this->class_reschedule_request_model->get($id);
            if (!is_null($get_data)) {


                $status = $get_data->status;
                $availability_id = $get_data->availability_id; //new()
                $class_id = $get_data->class_id; //old
                $class = $this->scheduled_class_model->get($class_id);
                $old_availability_id = $this->user_availability_model->get_all(null, null, null, null, $class_id);
                if (!empty($old_availability_id) && ($status == 0)) {
                    if ($this->course_teacher_model->get_filter($class->batch_id, $user->id, 1) || $user->type == "SUPPORT" || $user->type == "ADMIN") {


                        $new_availability = $this->user_availability_model->get($old_availability_id[0]->id); //old
                        $old_availability['class_id'] = null;
                        $old_availability['status'] = 1;
                        $this->user_availability_model->update_by_params(["class_id" => $class_id], $old_availability);
                        $this->scheduled_class_model->update($class->id, ["status" => "RESCHEDULED"]);

                        $class->start_time = $new_availability->from; //$new_availability["start_time"];
                        $class->end_time = $new_availability->to; //$new_availability["end_time"];
                        unset($class->id);
                        unset($class->status);
                        unset($class->created_on);
                        unset($class->updated_on);
                        unset($class->updated_by);
                        $new_scheduled_class_id = $this->scheduled_class_model->insert((array) $class);
                        if ($new_scheduled_class_id) { //new
                            $data = [
                                "class_id" => $new_scheduled_class_id, //new
                                "status" => '0',
                            ];
                            $this->user_availability_model->update($availability_id, $data);
                        }

                        if ($status == 0 || $status != 1) {
                            $status = 1;
                        } else {
                            $status = -1;
                        }
                        $data = array('status' => $status);

                        if ($this->class_reschedule_request_model->update($id, $data)) {

                            $batch_student = $this->course_enrollment_model->get_all(null, null, null, null,$class->batch_id);
                            $dataToReplace = [
                                "BATCH_NAME"=>$batch->code,
                                "TEACHER_NAME" =>$teacher->full_name
                              ];
                             //Email sent to user/Student
                            //$cc = array();
                            foreach ($batch_student as $rows) {
                            // $cc[]=$rows->email;
                            $this->mailer->mail_template($rows->email, 'schedule-class',$dataToReplace);
                            }
                            set_message("success", "Rescheduled class request is Approved");
                            //return $this->http->response->create(200, "Rescheduled class request is Approved");
                        } else {
                            set_message("danger", "Rescheduled class request is not found ");
                            //return $this->http->response->create(203, "Rescheduled class request is not found / {$status}");
                        }
                    }
                    redirect(base_url('class_reschedule_request'), 'refresh');
                } else {
                    set_message("danger", "Rescheduled class request is not Approved ");
                   // return $this->http->response->create(203, "Rescheduled class request is not Approved ");
                }
            } else {
                return $this->http->response->create(203, "Rescheduled class request is not found");
            }
            redirect(base_url('class_reschedule_request'), 'refresh');
        } catch (\Throwable $th) {
            redirect(base_url('class_reschedule_request'), 'refresh');
        }
    }
    public function update($id)
    {
        try {
            $user = $this->http->auth(["get", "post"], ["STUDENT", "TEACHER", "ADMIN"]);

            if (is_numeric($id)) {
                $this->save($id);
            }
        } catch (\Throwable $th) {

            return $this->http->response->serverError();
        }
    }
    public function get($id)
    {
        try {
            $this->http->auth(["get"], ["STUDENT", "TEACHER", "ADMIN"]);
            if ($data = $this->class_reschedule_request_model->get($id)) {

                return $this->http->response->create(200, "Rescheduled class request fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Rescheduled class request not found of given id");
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->http->response->serverError();
        }
    }
    public function get_all()
    {
        try {

            $u = $this->http->auth("get", ["ADMIN", "SUPPORT", "STUDENT", "TEACHER"]);
            if ($u->type == "SUPPORT" || $u->type == "ADMIN") {
              if ($this->input->get("self") == "true") {
                $user_id = $u->id;
                $class_id = is_numeric($this->input->get("class_id")) ? $this->input->get("class_id") : "";
               
              } else {
                $user_id = $this->input->get("user_id");
                $class_id = is_numeric($this->input->get("class_id")) ? $this->input->get("class_id") : "";
              }
            } else {
                $user_id = $u->id;
                $class_id = is_numeric($this->input->get("class_id")) ? $this->input->get("class_id") : "";
                
            }
           
            if ($data = $this->class_reschedule_request_model->get_all(null, $class_id,$user_id)) {
                return $this->http->response->create(200, "Rescheduled class requests fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Rescheduled class request not found");
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
            if ($affected_rows = $this->class_reschedule_request_model->delete($id)) {
                set_message("success", "Rescheduled class request delete successfully");
            } else {
                set_message("danger", "Rescheduled class request is not found / deleted");
            }
            redirect(base_url('class_reschedule_request'), 'refresh');
        } catch (\Throwable $th) {
            redirect(base_url('class_reschedule_request'), 'refresh');
        }
    }
}
