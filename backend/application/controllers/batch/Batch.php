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

class Batch extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(["batch_model","course_level_model", "course_model"]);
  }
  private function save_view($id = null)
  {
    
    $courses = $this->course_model->get_all(1);
    $course_levels = $this->course_level_model->get_all(1);
    if ($batch = $this->batch_model->get($id)) {
      view("batch/create", compact("courses","course_levels", "batch"), "Portal | Batch Edit");
    } else {
      view("batch/create", compact("courses","course_levels"), "Portal | Batch Create");
    }
  }

  public function index()
  {
    try {
      $this->http->auth(["get"], "ADMIN");
      view("batch/index", null, "Portal | Batch");
    } catch (\Throwable $th) {
      //throw $th;
      redirect(base_url('batch'), 'refresh');
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
              'field' => 'course_id',
              'label' => 'Course',
              'rules' => 'required|numeric|is_exist[courses.id]',
              'errors' => array(
                'is_exist' => '%s not exist',
              )
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
              'field' => 'no_of_students_allowed',
              'label' => 'Student Number',
              'rules' => 'required|numeric'
            ],
            [
              'field' => 'start_date',
              'label' => 'Start date',
              'rules' => 'required|valid_date',
              'errors' => array(
                'valid_date' => '%s is not a valid date format',
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

        if ($this->form_validation->run() == true) {
          $p = $this->http->request->all();
          $timestamp = strtotime($p['start_date']);
          $new_date = date('Y-m-d', $timestamp);
          $batch_code=$this->autogenerate($p['course_id'],$p['course_level_id']);
          $data = [
            "code" =>$batch_code,
            "course_id" => $p['course_id'],
            "course_level_id" => $p['course_level_id'],
            "description" => $p['description'],
            "start_date" => $new_date,
            "no_of_students_allowed" => $p['no_of_students_allowed'],
            "status" => $p['status'],
          ];

          if (!is_null($id)) {
            if ($this->batch_model->update($id, $data)) {
              set_message("success", "Batch updated successfully");
            } else {
              set_message("danger", "Batch no changes found/failed");
            }
          } else {
            if ($this->batch_model->insert($data)) {
              set_message("success", "Batch created successfully");
            } else {
              set_message("danger", "Batch creation failed");
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
  public function delete($id)
  {
    try {
      $this->http->auth(["get"], "ADMIN");
      if ($d = $this->batch_model->delete($id)) {
        set_message("success", "Batch delete successfully");
      } else {
        set_message("danger", "Batch delete failed");
      }
      redirect(base_url('batch'), 'refresh');
    } catch (\Throwable $th) {
      redirect(base_url('batch'), 'refresh');
    }
  }

  public function get($id)
  {
      try {
          $this->http->auth(["get"], ["ADMIN"]);
          if ($data = $this->batch_model->get($id)) {
              return $this->http->response->create(200, "Batch fetched successfully", $data);
          } else {
              return $this->http->response->create(203, "Batch not found");
          }
      } catch (\Throwable $th) {
          //throw $th;
          return $this->http->response->serverError();
      }
  }

  public function get_all()
  {
    try {
      $this->http->auth(["get"], "ADMIN");
      $course_id = is_numeric($this->input->get('course_id')) ? $this->input->get('course_id') : null;
      $course_level_id = is_numeric($this->input->get('course_level_id')) ? $this->input->get('course_level_id') : null;
     
      if ($d = $this->batch_model->get_all(1,$course_id,$course_level_id)) {
        return $this->http->response->create(200, "Batch fetched successfully", $d);
      } else {
        return $this->http->response->create(203, "Batch not found");
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }


function autogenerate($course_id,$course_level_id) {

  $course = $this->course_model->get($course_id);
  $course_level = $this->course_level_model->get($course_level_id);
  $number=$this->batch_model->batch_count($course_id,$course_level_id);
  $level = explode(" ",$course_level->level);
  $course = explode(" ",$course->name);
  $levels = "";
  $courses = "";
  foreach ($level as $l) {
    $levels .= mb_substr($l, 0, 1);
   
  }
  foreach ($course as $c) {
    $courses .= mb_substr($c, 0, 1);
   
  }
  return strtoupper($courses.$levels.($number+1));
  }

  //update orders
  public function updateOrder()
  {
    try {
      $this->http->auth(["post"], ["ADMIN", "SUPPORT"]);
      $p = $this->http->request->all();
      if (!is_null($p['ids'])) {
        $data = explode(",", $p['ids']);
        if ($d =$this->batch_model->updateOrder($data)) {
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
