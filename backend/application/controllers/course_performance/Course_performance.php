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

class Course_performance extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(["batch_model", "course_performance_model","file_model", "module_model", "user_model"]);
  }
  private function save_view($id = null)
  {
    $batch_id = is_numeric($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
    $module_id = is_numeric($this->input->get('module_id')) ? $this->input->get('module_id') : null;
    $user_id = is_numeric($this->input->get('user_id')) ? $this->input->get('user_id') : null;

    $teachers = $this->user_model->get_all("active", 4);
    $batches = $this->batch_model->get_all(1);
    $modules = $this->module_model->get_all(1);
    if ($performance = $this->course_performance_model->get($id)) {
        
      view("course_performance/result_performance", compact("performance","teachers", "batches", "modules", "module_id", "batch_id", "user_id"), "Portal | Course Performance Edit");
    } else {
      view("course_performance/result_performance", compact("performance","teachers", "batches", "modules", "module_id", "batch_id", "user_id"), "Portal | Course Performance Create");
    }
  }

  public function index()
  {
    try {
      $this->http->auth(["get"], "ADMIN");
      view("course_performance/index", null, "Portal | Course Performance");
    } catch (\Throwable $th) {
      //throw $th;
      redirect(base_url('course_performance'), 'refresh');
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
              'label' => 'TEACHER',
              'rules' => 'required|numeric'
            ],
            [
              'field' => 'batch_id',
              'label' => 'Batch',
              'rules' => 'required|numeric'
            ],
            [
              'field' => 'module_id',
              'label' => 'Module',
              'rules' => 'required|numeric'
            ],

            [
              'field' => 'result_type',
              'label' => 'Result Type',
              'rules' => 'required'
            ],
            [
              'field' => 'certificate_file',
              'label' => 'certificate_file',
              'rules' => 'required|in_list[0,1]',
              'errors' => array(
                'in_list' => '%s select one of Active/Inactive',
              ),
            ]
          ]
        );

        if ($this->form_validation->run() == true) {
          $p = $this->http->request->all();

          $path = DOCUMENT_FOLDER . '/certificate_file/';
          $data = array();
          if (!empty($_FILES['certificate_file']['name'])) {
            $result = $this->functions->file_insert($path, 'certificate_file', 'pdf', '9097152'); //type,size
            $data['certificate_file'] = $path . $result['msg'];
            unset($result['msg']);
            $fid = $this->file_model->insert($result);
            $data['file_id'] =$fid;
          } else {

            $data['certificate_file'] = '';
          }

          $data["performance_id"] = $p['performance_id'];
          $data["user_id"] = $p['user_id'];
          $data["batch_id"] = $p['batch_id'];
          $data["module_id"] = $p['module_id'];
          $data["result_type"] = $p['result_type'];
          $data["marks"] = $p['marks'];
          $data["status"] = '1';

          // pp($data);
          if (!is_null($id)) {
            if ($this->course_performance_model->update_performance_result($id, $data)) {
              set_message("success", "Course Performance updated successfully");
            } else {
              set_message("danger", "Course Performance no changes found/failed");
            }
          } else {
            if ($this->course_performance_model->insert_performance_result($data)) {
              set_message("success", "Course Performance created successfully");
            } else {
              set_message("danger", "Course Performance creation failed");
            }
          }
          redirect(base_url('course_performance'), 'refresh');
        } else {
          $this->save_view($id);
        }
      } else {
        $this->save_view($id);
      }
    } catch (\Throwable $th) {
      redirect(base_url('course_performance'), 'refresh');
    }
  }
  public function delete($id)
  {
    try {
      $this->http->auth(["get"], "ADMIN");
      if ($d = $this->course_performance_model->delete($id)) {
        set_message("success", "Course Performance delete successfully");
      } else {
        set_message("danger", "Course Performance delete failed");
      }
      redirect(base_url('course_performance'), 'refresh');
    } catch (\Throwable $th) {
      redirect(base_url('course_performance'), 'refresh');
    }
  }

  public function get($id)
  {
    try {
      $this->http->auth(["get"], ["ADMIN"]);
      if ($data = $this->course_performance_model->get($id)) {
        return $this->http->response->create(200, "Course Performance fetched successfully", $data);
      } else {
        return $this->http->response->create(203, "Course Performance not found");
      }
    } catch (\Throwable $th) {
      //throw $th;
      return $this->http->response->serverError();
    }
  }

  public function get_all()
  {
    try {
      $this->http->auth(["get"], ["ADMIN", "TEACHER", "STUDENT"]);
      $course_id = is_numeric($this->input->get('course_id')) ? $this->input->get('course_id') : null;
      $course_level_id = is_numeric($this->input->get('course_level_id')) ? $this->input->get('course_level_id') : null;
      $batch_id = is_numeric($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
      $student_id = is_numeric($this->input->get('student_id')) ? $this->input->get('student_id') : null;
      $teacher_id = is_numeric($this->input->get('teacher_id')) ? $this->input->get('teacher_id') : null;
      $status = is_numeric($this->input->get('status')) ? $this->input->get('status') : null;

      if ($d = $this->course_performance_model->get_all($status, $course_id, $course_level_id, $batch_id, $student_id, $teacher_id)) {
        return $this->http->response->create(200, "Performance fetched successfully", $d);
      } else {
        return $this->http->response->create(203, "Performance not found");
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }
}
