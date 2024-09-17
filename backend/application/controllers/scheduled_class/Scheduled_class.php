<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Controller Question
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller Rest
 * @author    Monirul Middya
 * @param     ...
 * @return    ...
 *
 */

class Scheduled_class extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(["scheduled_class_model", "task_template_model","course_enrollment_model", "task_model", "user_model", "course_model", "batch_model", "course_level_model", "session_type_model", "module_model","user_availability_model"]);
  }
  private function save_view($id = null)
  {
    $courses = $this->course_model->get_all(1);
    $course_levels = $this->course_level_model->get_all(1);
    $teachers = $this->user_model->get_all("active", 4);
    $session_types = $this->session_type_model->get_all(1);
    $batches = $this->batch_model->get_all(1);
    $modules = $this->module_model->get_all(1);

    if ($scheduled_classes = $this->scheduled_class_model->get($id)) {
      view("scheduled_class/create", compact("scheduled_classes", "courses", "course_levels", "teachers", "session_types", "modules", "batches"), "Portal | Scheduled Class Edit");
    } else {
      view("scheduled_class/create", compact("session_types", "courses", "course_levels", "teachers", "modules", "batches"), "Portal | Scheduled Class Create");
    }
  }

  public function index()
  {

    try {
      $this->http->auth(["get"], "ADMIN");
      $scheduled_classes = $this->scheduled_class_model->get_all();
      $batches = $this->batch_model->get_all(1);
      $batch_id = !empty($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
      $from = !empty($this->input->get('from')) ? $this->input->get('from') : null;
      $to = !empty($this->input->get('to')) ? $this->input->get('to') : null;
      $status = !empty($this->input->get('status')) ? $this->input->get('status') : null;
      view("scheduled_class/index", compact("batches","batch_id","scheduled_classes","status","from","to"), "Portal | Scheduled Class");
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }

  public function save($id = null)
  {
    
    try {
      $this->http->auth(["get", "post"], "ADMIN");
      $p = $this->http->request->all();
      if (is_post()) {
        
        $this->form_validation->set_rules(
          [
            [
              'field' => 'batch_id',
              'label' => 'Batch',
              'rules' => 'required|numeric|is_exist[batches.id]',
              'errors' => array(
                'is_exist' => '%s not exist',
              )
            ],

            [
              'field' => 'user_id',
              'label' => 'Teacher',
              'rules' => 'required|numeric|is_exist[users.id]',
              'errors' => array(
                'is_exist' => '%s not exist',
              )
            ],

            [
              'field' => 'session_id',
              'label' => 'Session Type',
              'rules' => 'required|numeric|is_exist[session_types.id]',
              'errors' => array(
                'is_exist' => '%s not exist',
              )
            ],
            [
              'field' => 'status',
              'label' => 'Status',
              'rules' => 'required|in_list[NOT_STARTED,STARTED,ENDED,CANCELLED,APPROVED,RESCHEDULED]',
            ],
            [
              'field' => 'start_time',
              'label' => 'Start Time',
              'rules' => 'required',
            ],
            [
              'field' => 'end_time',
              'label' => 'End Time',
              'rules' => 'required',
            ],
         

          ]
        );

        if ($this->form_validation->run() == true) {
          $start_time = date('Y-m-d H:i:s', strtotime($p['start_time']));
          $end_time = date('Y-m-d H:i:s', strtotime($p['end_time']));

          $data = [
            "batch_id" => $p['batch_id'],
            "module_id" => $p['module_id'],
            "user_id" => $p['user_id'],
            "session_id" => $p['session_id'],
            "status" => $p['status'],
            "start_time" => $start_time,
            "end_time" => $end_time,
            "description" => $p['description'],
            "link" => $p['link'],
            "recorded_link" => $p['recorded_link'],
          ];

          if (!is_null($id)) {
            if ($this->scheduled_class_model->update($id, $data)) {

              set_message("success", "Scheduled updated successfully");
            } else {
              set_message("danger", "Scheduled no changes found/failed");
            }
          } else {
            if (($class_id=$this->scheduled_class_model->insert($data))&&(isset($p["availability_id"]))) {
              $data = [
                "class_id" => $class_id,
                "status" =>0,
            ];
            $this->user_availability_model->update($p["availability_id"] , $data);
              $batch = $this->batch_model->get($p['batch_id']);
              $teacher = $this->user_model->get($p['user_id']);
             $batch_student = $this->course_enrollment_model->get_all(null, null, null, null, $p['batch_id']);
         
              $dataToReplace = [
                "BATCH_NAME"=>$batch ->code,
                "TEACHER_NAME" =>$teacher->full_name
              ];

              $content = $this->task_template('CLASS_CREATE', $start_time, $dataToReplace);
              $this->task_model->insert_batch($content);
              //Email sent to user/Student
              //$cc = array();
             foreach ($batch_student as $rows) {
              // $cc[]=$rows->email;
               $this->mailer->mail_template($rows->email, 'schedule-class',$dataToReplace);
              }
               
               //Email sent to user/Student
              set_message("success", "Scheduled created successfully");
            } else {
              set_message("danger", "Scheduled creation failed");
            }
          }
          redirect(base_url('scheduled_class'), 'refresh');
        } else {
          $this->save_view($id);
        }
      } else {
        $this->save_view($id);
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }
  public function delete($id)
  {
    try {
      if ($d = $this->scheduled_class_model->delete($id)) {
        set_message("success", "Scheduled Class deleted successfully");
      } else {
        set_message("danger", "Scheduled Class deleted failed");
      }
      redirect(base_url('scheduled_class'), 'refresh');
    } catch (\Throwable $th) {
      redirect(base_url('scheduled_class'), 'refresh');
    }
  }

  public function get_all()
  {
    try {
      $u = $this->http->auth("get", ["ADMIN", "SUPPORT", "STUDENT", "TEACHER"]);
      if ($u->type == "SUPPORT" || $u->type == "ADMIN") {
        if ($this->input->get("self") == "true") {
          $user_id = $u->id;
          $student_id =!empty($this->input->get('student_id')) ? $this->input->get('student_id') : null;
          $status = !empty($this->input->get('status')) ? $this->input->get('status') : null;
          $from = !empty($this->input->get('from')) ? $this->input->get('from') : null;
          $to = !empty($this->input->get('to')) ? $this->input->get('to') : null;
          $batch_id= !empty($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
        } else {
          $user_id = $this->input->get("user_id");
          $student_id =!empty($this->input->get('student_id')) ? $this->input->get('student_id') : null;
          $status = !empty($this->input->get('status')) ? $this->input->get('status') : null;
          $from = !empty($this->input->get('from')) ? $this->input->get('from') : null;
          $to = !empty($this->input->get('to')) ? $this->input->get('to') : null;
          $batch_id= !empty($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
        }
      }elseif ($u->type == "TEACHER") {
        $user_id = $u->id;
        $student_id =!empty($this->input->get('student_id')) ? $this->input->get('student_id') : null;
        $status = !empty($this->input->get('status')) ? $this->input->get('status') : null;
        $from = !empty($this->input->get('from')) ? $this->input->get('from') : null;
        $to = !empty($this->input->get('to')) ? $this->input->get('to') : null;
        $batch_id= !empty($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
      }else {
        $student_id =$u->id;
        $user_id=null;
        $status = !empty($this->input->get('status')) ? $this->input->get('status') : null;
        $from = !empty($this->input->get('from')) ? $this->input->get('from') : null;
        $to = !empty($this->input->get('to')) ? $this->input->get('to') : null;
        $batch_id= !empty($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
      }
     
    
      if ($d = $this->scheduled_class_model->get_all($status, $from,$to,$student_id,$user_id,$batch_id)) {
        return $this->http->response->create(200, "Scheduled Class fetched successfully", $d);
      } else {
        return $this->http->response->create(203, "Scheduled Class not found");
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }

  public function get($id = null)
  {
    try {
      $this->http->auth(["get"], ["ADMIN","SUPPORT","TEACHER","STUDENT"]);
      if ($d = $this->scheduled_class_model->get($id)) {
        return $this->http->response->create(200, "Module fetched successfully", $d);
      } else {
        return $this->http->response->create(203, "Module  not found");
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }
  //=============================================================
  // GET Tasks Templates AND REPLACE CONTENT VARIABLES
  function task_template($category, $originaltime, $data = [])
  {

    $tasks = $this->task_template_model->get_all(null, $category);
    $content   =   array();
    foreach ($tasks as $key => $row) :

      $tasktitle = $tasks[$key]->title;
      $taskdesc = $tasks[$key]->description;

        foreach($data as $eachkey=>$eachdata) {
          $tasktitle = str_replace("[".$eachkey."]",$eachdata,$tasktitle);
          $taskdesc = str_replace("[".$eachkey."]",$eachdata,$taskdesc);
        }


      $content[] = array(
        'task_title' => $tasktitle,
        'description' => $taskdesc,
        'status' => $tasks[$key]->status,
        'file_name' => $tasks[$key]->file,
        'task_date' => date('Y-m-d H:i:s', strtotime($tasks[$key]->delta_time . 'minutes', strtotime($originaltime)))

      );

      endforeach;
    return $content;
  }
}
