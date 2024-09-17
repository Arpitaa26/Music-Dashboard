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

class Course_history extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(["batch_model", "course_enrollment_model", "course_level_model", "user_attendance_model", "scheduled_class_model", "module_model", "user_model", "course_history_model", "course_model"]);
  }

  public function index()
  {
    try {
      $this->http->auth(["get"], ["ADMIN", "SUPPORT", "STUDENT"]);
      $module_id = is_numeric($this->input->get('module_id')) ? $this->input->get('module_id') : null;
      $user_id = is_numeric($this->input->get('user_id')) ? $this->input->get('user_id') : null;
      $batch_id = is_numeric($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
      $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
      $course_level_id = is_numeric($this->input->get("course_level_id")) ? $this->input->get("course_level_id") : "";
      $course_levels = $this->course_level_model->get_all(1);
      $courses = $this->course_model->get_all(1);
      $batches = $this->batch_model->get_all(1);
      $modules = $this->module_model->get_all(1);
      $users = $this->user_model->get_all("active", 5);
      view("course_history/index", compact("course_levels", "courses", "batches", "modules", "users", "course_id", "course_level_id", "batch_id", "user_id", "module_id"), "Portal | course_history");
    } catch (\Throwable $th) {
      //throw $th;
      redirect(base_url('course_history'), 'refresh');
    }
  }
  //insert course_history
  public function complete_tutorial($class_id)
  {
    try {

      $p = $this->http->request->all();
      $user = $this->http->auth(["post", "get"], ["TEACHER"]);
      $class = $this->scheduled_class_model->get($class_id);

      if ($class->status == "STARTED") {
        if (empty($class->actual_end_time) && ($user->type == "TEACHER")) {

          $batch_student = $this->course_enrollment_model->get_all(null, null, null, null, $class->batch_id);
          $data = [];
          foreach ($batch_student as $student) {
            $data[] = [
              'user_id' => $student->user_id,
              'course_id' => $student->course_id,
              'course_level_id' => $student->course_level_id,
              'category' => $student->category,
              'batch_id' => $class->batch_id,
              'module_id' => $class->module_id,
              'tutorial_id' => $p['tutorial_id'],
              'status' => 1
            ];
          }
          if ($this->course_history_model->insert_batch($data)) //batch insert course_history`
          {
            return $this->http->response->create(200, "Insert Course History");
          }
        }
      } else {
        return $this->http->response->create(203, "Given class not STARTED");
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }


  public function module_complete($batch_id, $status)
  {
    try {
      $this->http->auth(["post", "get"], ["ADMIN", "TEACHER"]);
      if ($d = $this->course_history_model->filter_by_batch($batch_id)) {

        if ($status == 'proccess') {

          $status = '0';
        } elseif ($status == 'complete') {
          $status = '-1';
        } else {
          $status = '1';
        }
        foreach ($d as $id) {
          $data = ['status' => $status];
          $this->course_history_model->update($id->id, $data);
        }

        //$this->course_history_model->update_batch($data);
        set_message("success", "Course module complete update successfully");
      } else {
        set_message("danger", "Course module complete update failed");
      }
      redirect(base_url('course_history'), 'refresh');
    } catch (\Throwable $th) {
      redirect(base_url('course_history'), 'refresh');
    }
  }

  public function delete($id)
  {
    try {
      $this->http->auth(["get"], "ADMIN");
      if ($d = $this->course_history_model->delete($id)) {
        set_message("success", "Course History delete successfully");
      } else {
        set_message("danger", "Course History delete failed");
      }
      redirect(base_url('course_history'), 'refresh');
    } catch (\Throwable $th) {
      redirect(base_url('course_history'), 'refresh');
    }
  }

  public function get($id)
  {
    try {
      $this->http->auth(["get"], ["ADMIN", "STUDENT", "TEACHER"]);
      if ($data = $this->course_history_model->get($id)) {
        return $this->http->response->create(200, "Course History fetched successfully", $data);
      } else {
        return $this->http->response->create(203, "Course History not found");
      }
    } catch (\Throwable $th) {
      //throw $th;
      return $this->http->response->serverError();
    }
  }

  public function get_all()
  {
    try {
      $u = $this->http->auth(["get"], ["ADMIN", "STUDENT", "TEACHER"]);
      if ($u->type == "SUPPORT" || $u->type == "ADMIN") {
        if ($this->input->get("self") == "true") {
          $module_id = is_numeric($this->input->get('module_id')) ? $this->input->get('module_id') : null;
          $user_id = is_numeric($this->input->get('user_id')) ? $this->input->get('user_id') : null;
          $batch_id = is_numeric($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
          $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
          $course_level_id = is_numeric($this->input->get("course_level_id")) ? $this->input->get("course_level_id") : "";
        } else {
          $module_id = is_numeric($this->input->get('module_id')) ? $this->input->get('module_id') : null;
          $user_id = is_numeric($this->input->get('user_id')) ? $this->input->get('user_id') : null;
          $batch_id = is_numeric($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
          $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
          $course_level_id = is_numeric($this->input->get("course_level_id")) ? $this->input->get("course_level_id") : "";
        }
      } elseif ($u->type == "TEACHER") {
        $module_id = is_numeric($this->input->get('module_id')) ? $this->input->get('module_id') : null;
        $user_id = is_numeric($this->input->get('user_id')) ? $this->input->get('user_id') : null;
        $batch_id = is_numeric($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
        $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
        $course_level_id = is_numeric($this->input->get("course_level_id")) ? $this->input->get("course_level_id") : "";
      } else {
        $user_id = $u->id;
        $module_id = is_numeric($this->input->get('module_id')) ? $this->input->get('module_id') : null;
        $batch_id = is_numeric($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
        $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
        $course_level_id = is_numeric($this->input->get("course_level_id")) ? $this->input->get("course_level_id") : "";
      }

      if ($d = $this->course_history_model->get_all(null, $user_id, $module_id, $batch_id, $course_id, $course_level_id)) {
        return $this->http->response->create(200, "Course History fetched successfully", $d);
      } else {
        return $this->http->response->create(203, "Course History not found");
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }
}
