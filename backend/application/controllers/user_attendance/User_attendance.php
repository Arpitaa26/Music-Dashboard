<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_attendance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(["user_attendance_model","user_model","batch_model","course_history_model", "scheduled_class_model", "course_enrollment_model", "course_teacher_model"]);
    }

    private function save_view($id = null)
    {
      
      $attendance = $this->user_attendance_model->get_all(1,null,$id);
      
      if ($users = $this->user_model->get($id)) {
     
        view("user_attendance/create", compact("attendance","users"), "Portal | attendance Edit");
      } else {
        view("user_attendance/create", compact("attendance"), "Portal | attendance Create");
      }
    }
    
  public function create($id = null)
  {
    try {
      $this->http->auth(["get", "post"], "ADMIN");
      $this->save_view($id);
    } catch (\Throwable $th) {
      redirect(base_url('user_attendance'), 'refresh');
    }
  }
  public function index()
  {
    try {
       
      $this->http->auth(["get"], "ADMIN");
      $class_id = !empty($this->input->get('class_id')) ? $this->input->get('class_id') : null;
      $batch_id = !empty($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
      $user_id = !empty($this->input->get('user_id')) ? $this->input->get('user_id') : null;
      $from= !empty($this->input->get('from')) ? $this->input->get('from') : null;
      $to = !empty($this->input->get('to')) ? $this->input->get('to') : null;
      $batches = $this->batch_model->get_all(1);
      $users = $this->user_model->get_all("active");
      view("user_attendance/index", compact("class_id", "batch_id","user_id","batches","from","to","users"), "Portal | user_attendance");
    } catch (\Throwable $th) {
      //throw $th;
      redirect(base_url('user_attendance'), 'refresh');
    }
  }

    public function start_end_class($class_id)
    {
        try {

            $p = $this->http->request->all();
            $user = $this->http->auth(["post", "get"], ["TEACHER"]);
            $class = $this->scheduled_class_model->get($class_id);
            $current_time = date('Y-m-d H:i:s');
            if ($class->status == "STARTED") {
                if (empty($class->actual_end_time)&&($user->type == "TEACHER")&&('END'==isset($p['END']))) {
                 
                    $this->scheduled_class_model->update($class_id, ["actual_end_time" => $current_time]);
                    if ($this->user_attendance_model->get_filter_batch($class_id, $class->batch_id, "ATTENDED")) {
                     $attendance = $this->user_attendance_model->get_all('ATTENDED',$class_id,$class->batch_id);
                     $this->scheduled_class_model->update($class_id, ["status" => "COMPLETED"]);
                     foreach ($attendance AS $key=>$value){
                          
                             if(is_null($value->left_on)){
                                  $d= $this->user_attendance_model->update_batch($class->batch_id, ["left_on" =>$value->class_end_time]);
                                  }
                     }
                    
                        return $this->http->response->create(200, " are already attendance { $d}");
                    }
                    return $this->http->response->create(203, "Class " . strtolower($class->status));
                }
            } else {
                return $this->http->response->create(203, "Given class not available");
            }

        } catch (\Throwable $th) {
            return $this->http->response->serverError();
        }
    }
    public function save($class_id)
    {
       
        try {
            $user = $this->http->auth(["post", "get"], ["TEACHER", "STUDENT"]);
            
            $class = $this->scheduled_class_model->get($class_id);
        
            if ($class) {
                if ($class->status != "NOT_STARTED" && $class->status != "STARTED") {
                    return $this->http->response->create(203, "Class " . strtolower($class->status));
                }
            } else {
                return $this->http->response->create(203, "Given class not available");
            }

            if ($user->type == "TEACHER") {
                // for teacher's attendence
              
                if ($df=$this->course_teacher_model->get_filter($class->batch_id, $user->id, 1)) {
                    $actual_start_time = date('Y-m-d H:i:s');
                    $current_time = date('H:i:s');
                    $start_time = date("H:i:s", strtotime($class->start_time) - (TIME_FOR_EARLY_ATTENDANCE * 60));
                    $time_limit = date("H:i:s", strtotime($class->end_time));
                
                    if ($start_time <= $current_time && $time_limit >= $current_time) {
                        if ($this->user_attendance_model->get_filter($class_id, $user->id, "ATTENDED")) {
                            $this->scheduled_class_model->update($class_id, ["status" => "STARTED"]);
                            return $this->http->response->create(200, "Teacher are already attendance");
                        } else {
                          
                            $d = [
                                'user_id' => $user->id,
                                'class_id' => $class->id,
                                'batch_id' => $class->batch_id,
                                'status' => "ATTENDED"
                            ];
                           
                        //     $batch_student= $this->course_enrollment_model->get_all(null,null,null,null,$class->batch_id);
                        //     $data=[];
                        //     foreach($batch_student as $student){
                        //     $data[] = [
                        //         'user_id' => $student->user_id,
                        //         'batch_id' => $class->batch_id,
                        //         'module_id' => $class->module_id,
                        //         'tutorial_id' =>0,
                        //         'status' =>1
                        //     ];
                        // }
                           
                            if ($this->user_attendance_model->insert($d)) {

                               //$this->course_history_model->insert_batch($data);//batch insert course_history`
                                if ($this->scheduled_class_model->update($class_id, ["status" => "STARTED",])) {
                                    $this->scheduled_class_model->update($class_id, ["actual_start_time" => $actual_start_time]);
                                    return $this->http->response->create(200, "Teacher attendance has been created successfully");
                                } else {
                                    return $this->http->response->create(203, "Class status update failure / no change");
                                }
                            } else {
                                return $this->http->response->create(203, "Teacher attendance creation failed");
                            }
                        }
                    } else {
                        return $this->http->response->create(203, "Class time is over / Class is not start");
                    }
                } else {
                    return $this->http->response->create(203, "Teacher does not exit in this class");
                }
            } else {
                // for student's attendence
                if ($this->course_enrollment_model->get_filter($class->batch_id, $user->id, 1)) {
                    $current_time = date('H:i:s');
                    $start_time = date("H:i:s", strtotime($class->start_time) - (TIME_FOR_EARLY_ATTENDANCE * 60));
                    $time_limit = date("H:i:s", strtotime($class->end_time));

                    if ($start_time <= $current_time && $time_limit >= $current_time) {
                        if ($this->user_attendance_model->get_filter($class_id, $user->id, "ATTENDED")) {
                            return $this->http->response->create(200, "Student attendance already created");
                        } else {
                            $d = [
                                'user_id' => $user->id,
                                'class_id' => $class->id,
                                'batch_id' => $class->batch_id,
                                'status' => "ATTENDED"
                            ];
                            if ($this->user_attendance_model->insert($d)) {
                                return $this->http->response->create(200, "Student attendance has been created successfully");
                            } else {
                                return $this->http->response->create(203, "Student attendance creation failed");
                            }
                        }
                    } else {
                        return $this->http->response->create(203, "Class time is over / Class is not start");
                    }
                } else {
                    return $this->http->response->create(203, "Student does not exit in this class");
                }
            }
        } catch (\Throwable $th) {
            return $this->http->response->serverError();
        }
    }
    public function get($id)
    {
        try {
            $this->http->auth(["get", "post"], ["TEACHER", "STUDENT", "ADMIN"]);
            if ($data = $this->user_attendance_model->get($id)) {
                return $this->http->response->create(200, "Attendance fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Attendance not found of given id");
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->http->response->serverError();
        }
    }
    public function get_all()
    {
        try {
            $user = $this->http->auth(["get", "post"], ["TEACHER", "STUDENT", "ADMIN"]);
            $batch_id = !empty($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
            $class_id = !empty($this->input->get('class_id')) ? $this->input->get('class_id') : null;
            $user_id = !empty($this->input->get('user_id')) ? $this->input->get('user_id') : null;
            $from= !empty($this->input->get('from')) ? $this->input->get('from') : null;
            $to = !empty($this->input->get('to')) ? $this->input->get('to') : null;
           
            if ($data = $this->user_attendance_model->get_all('ATTENDED', $class_id,$batch_id,$user_id,$from,$to )) {
               
                return $this->http->response->create(200, "Attendance fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Attendance not found");
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->http->response->serverError();
        }
    }
    public function get_attendance()
    {
        try {
            $user = $this->http->auth(["get", "post"], ["TEACHER", "STUDENT", "ADMIN"]);
            $class_id = !empty($this->input->get('class_id')) ? $this->input->get('class_id') : null;
            $user_id = !empty($this->input->get('user_id')) ? $this->input->get('user_id') : null;
            $batch_id = !empty($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
            if ($data = $this->user_attendance_model->get_attendance('ATTENDED', $class_id,$batch_id,$user_id)) {
               
                return $this->http->response->create(200, "Attendance fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Attendance not found");
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->http->response->serverError();
        }
    }

    // public function delete($id)
    // {
    //     try {
    //         $this->http->auth(["post"], ["TEACHER", "STUDENT", "ADMIN"]);
    //         if ($affected_rows = $this->user_attendance_model->delete($id)) {
    //             return $this->http->response->create(200, "Attendance delete successfully");
    //         } else {
    //             return $this->http->response->create(203, "Attendance is not found / deleted");
    //         }
    //     } catch (\Throwable $th) {
    //         return $this->http->response->serverError();
    //     }
    // }

    public function left($class_id)
    {
        try {
            $user = $this->http->auth(["post"], ["TEACHER", "STUDENT"]);
            $class = $this->scheduled_class_model->get($class_id);
            $current_time = date('H:i:s');
            $start_time = date("H:i:s", strtotime($class->start_time) - (TIME_FOR_EARLY_ATTENDANCE * 60));
            $time_limit = date("H:i:s", strtotime($class->end_time));

            if ($start_time <= $current_time && $time_limit >= $current_time) {
                if ($this->user_attendance_model->get_filter($class_id, $user->id, "ATTENDED")) {
                    if ($this->user_attendance_model->left($class_id, $user->id)) {
                        return $this->http->response->create(200, "Class left successfully");
                    } else {
                        return $this->http->response->create(203, "Class left failure / no change");
                    }
                } else {
                    return $this->http->response->create(203, "User are not attended this class");
                }
            } else {
                return $this->http->response->create(203, "Class time is over / Class is not start");
            }
        } catch (\Throwable $th) {
            return $this->http->response->serverError();
        }
    }

    public function feedback()
    {
        try {
            $user = $this->http->auth(["post"], ["STUDENT"]);
            $post = $this->http->request->all();
            $feedback = $post['feedback'];
            $class_id = $post['class_id'];
            if ($this->user_attendance_model->get_filter($class_id, $user->id, "ATTENDED")) {
                if ($this->user_attendance_model->feedback($class_id, $user->id, $feedback)) {
                    return $this->http->response->create(200, "Feedback saved successfully");
                } else {
                    return $this->http->response->create(203, "Feedback no change/ not save");
                }
            } else {
                return $this->http->response->create(203, "User are not attended this class");
            }
        } catch (\Throwable $th) {
            return $this->http->response->serverError();
        }
    }
    public function barchart() {
        try {
        $this->http->auth(["post","get"], ["ADMIN","TEACHER", "STUDENT"]);
       
        $record= $this->user_attendance_model->get_month_barchart();
       
        } catch (\Throwable $th) {
            //throw $th;
            return $this->http->response->serverError();
        }
     }
}
