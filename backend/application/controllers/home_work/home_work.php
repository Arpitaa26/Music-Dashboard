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

class Home_work extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(["batch_model", "course_level_model", "scheduled_class_model", "home_work_model", "course_model"]);
  }

  public function save($id = null)
  {
    try {
      $user = $this->http->auth(["post"], ["ADMIN", "TEACHER", "STUDENT"]);
      $p = $this->http->request->all();

      if (is_post()) {
        $p = $this->http->request->all();

        $this->form_validation->set_rules(
          [
            [
              'field' => 'description',
              'label' => 'Description',
              'rules' => 'required',
              'errors' => array(
                'is_exist' => '%s not exist',
              ),
            ]


          ]
        );

        if ($this->form_validation->run() == true) {

          $d = [
            "batch_id" => $p["batch_id"],
            "class_id" => $p["class_id"],
            "user_id" => $p["user_id"],
            "question_id" => $p["question_id"],
            "file_id" => $p["file_id"],
            "due_date" => $p["due_date"],
            "status" => $p["status"],
            "description" => $p["description"]
          ];
          if (!is_null($id)) {
            if ($this->home_work_model->update($id, $data)) {
              set_message("success", "HomeWork updated successfully");
            } else {
              set_message("danger", "HomeWork no changes found/failed");
            }
          } else {
            if ($this->home_work_model->insert($d)) {
              set_message("success", "HomeWork created successfully");
            } else {
              set_message("danger", "HomeWork creation failed");
            }
          }
          redirect(base_url('home_work/home_work'), 'refresh');
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
  public function get($id)
  {
    try {
      $this->http->auth(["get"], ["ADMIN"]);
      if ($data = $this->home_work_model->get($id)) {
        return $this->http->response->create(200, "HomeWork fetched successfully", $data);
      } else {
        return $this->http->response->create(203, "HomeWork not found");
      }
    } catch (\Throwable $th) {
      //throw $th;
      return $this->http->response->serverError();
    }
  }

  public function update_homework($class_id = null)
  {
    try {
      $this->http->auth(["post", "get"], ["ADMIN", "TEACHER", "STUDENT"]);
      $p = $this->http->request->all();

      if (is_post()) {
          $class = $this->scheduled_class_model->get($class_id);

    if ($class->status == "STARTED") {
                
        if (isset($p["home_work"])) {
          $data = [
            "home_work" => $p["home_work"],
          ];
        } else {
          $data = [
            "teacher_note" => $p["teacher_note"],
          ];
        }
        if (!is_null($class_id)) {
          if ($this->scheduled_class_model->update($class_id, $data)) {
            return $this->http->response->create(200, "Scheduled HomeWork/class note updated successfully");
          } else {
            return $this->http->response->create(203, "Scheduled HomeWork/class_note changes found/failed");
          }
        }
       }else{
           return $this->http->response->create(203, "Class Not Started/failed");
       }
      }
    } catch (\Throwable $th) {
      //throw $th;
      return $this->http->response->serverError();
    }
  }
  public function get_all()
  {

    try {
      $this->http->auth(["get"], ["ADMIN", "STUDENT", "TEACHER"]);
      $course_id = is_numeric($this->input->get('course_id')) ? $this->input->get('course_id') : null;
      $course_level_id = is_numeric($this->input->get('course_level_id')) ? $this->input->get('course_level_id') : null;

      if ($d = $this->home_work_model->get_all(1, $course_id, $course_level_id)) {
        return $this->http->response->create(200, "HomeWork fetched successfully", $d);
      } else {
        return $this->http->response->create(203, "HomeWork not found");
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }
}
