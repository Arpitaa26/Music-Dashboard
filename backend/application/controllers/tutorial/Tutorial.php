<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Controller tutorial
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

class Tutorial extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(["tutorial_model", "course_model", "module_model", "file_model", "tutorial_file_model"]);
  }
  private function save_view($id = null)
  {
    $modules = $this->module_model->get_all(1);
    if ($tutorial = $this->tutorial_model->get($id)) {
      view("tutorial/create", compact("modules", "tutorial"), "Portal | Tutorial Edit");
    } else {
      view("tutorial/create", compact("modules"), "Portal | Tutorial Create");
    }
  }

  public function index()
  {
    try {
      $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
      $module_id = is_numeric($this->input->get("module_id")) ? $this->input->get("module_id") : "";

      $courses = $this->course_model->get_all(1);
      $modules = $this->module_model->get_all(1);
      $this->http->auth(["get"], "ADMIN");
      view("tutorial/index", compact("modules", "courses", "course_id", "module_id"), "Portal | Tutorial");
    } catch (\Throwable $th) {
      //throw $th;
      redirect(base_url('tutorial'), 'refresh');
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
              'field' => 'module_id',
              'label' => 'Module',
              'rules' => 'required|numeric|is_exist[modules.id]',
              'errors' => array(
                'is_exist' => '%s not exist',
              )
            ],
            [
              'field' => 'title',
              'label' => 'Title',
              'rules' => "trim|required|is_unique_custom[tutorial.title.{$id}.id]",
              'errors' => array(
                'is_unique_custom' => '%s already taken',
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

          $data = [
            "title" => $p['title'],
            "module_id" => $p['module_id'],
            "description" => $p['description'],
            "order" => 0,
            "status" => $p['status'],
          ];

          if (!is_null($id)) {
            // if ($this->tutorial_model->update($id, $data)) {
            $this->tutorial_model->update($id, $data);
            if ($p['ids'] > 1) {
              $fileCount = count($p['ids']);
              $order = $this->tutorial_file_model->get_count($id);

              $datats = array();
              for ($i = 0; $i < $fileCount; $i++) {
                $datats[$i] = [
                  "tutorial_id " => $id,
                  "file_id" => $p['ids'][$i],
                  "order" => $order + $i + 1,
                  "status" => $p['status'],
                ];
              }

              $this->tutorial_file_model->insert_batch($datats);
            }
            set_message("success", "Tutorial updated successfully");
            // } else {
            //   set_message("success", "Tutorial updated successfully");
            // }
          } else {
            if ($insertid = $this->tutorial_model->insert($data)) {
              if ($p['ids'] > 0) {

                $fileCount = count($p['ids']);
                $order = $this->tutorial_file_model->get_count($insertid);

                $datas = array();
                for ($i = 0; $i < $fileCount; $i++) {
                  $datas[$i] = [
                    "tutorial_id " => $insertid,
                    "file_id" => $p['ids'][$i],
                    "order" => $order + $i + 1,
                    "status" => $p['status'],
                  ];
                }


                $this->tutorial_file_model->insert_batch($datas);
              }
              set_message("success", "Tutorial created successfully");
            } else {
              set_message("danger", "Tutorial creation failed");
            }
          }
          redirect(base_url('tutorial'), 'refresh');
        } else {
          $this->save_view($id);
        }
      } else {
        $this->save_view($id);
      }
    } catch (\Throwable $th) {
      redirect(base_url('tutorial'), 'refresh');
    }
  }
  public function delete($id = null)
  {
    try {
      $this->http->auth(["get"], "ADMIN");
      if (!is_null($id)) {
        $this->tutorial_file_model->delete_tutorial($id);
        $this->tutorial_model->delete($id);

        set_message("success", "Tutorial delete successfully");
      } else {
        set_message("danger", "Tutorial delete failed");
      }
      redirect(base_url('tutorial'), 'refresh');
    } catch (\Throwable $th) {
      redirect(base_url('tutorial'), 'refresh');
    }
  }

  public function get_all()
  {
    try {
      $u = $this->http->auth("get", ["ADMIN", "SUPPORT", "STUDENT", "TEACHER"]);
      if ($u->type == "SUPPORT" || $u->type == "ADMIN") {
        if ($this->input->get("self") == "true") {

          $user_id = $u->id;
          $batch_id = is_numeric($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
          $module_id = is_numeric($this->input->get('module_id')) ? $this->input->get('module_id') : null;
          $course_id = is_numeric($this->input->get('course_id')) ? $this->input->get('course_id') : null;
          $course_level_id = is_numeric($this->input->get('course_level_id')) ? $this->input->get('course_level_id') : null;
        } else {
          $user_id = is_numeric($this->input->get("user_id")) ? $this->input->get("user_id") : "";
          $batch_id = is_numeric($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
          $module_id = is_numeric($this->input->get('module_id')) ? $this->input->get('module_id') : null;
          $course_id = is_numeric($this->input->get('course_id')) ? $this->input->get('course_id') : null;
          $course_level_id = is_numeric($this->input->get('course_level_id')) ? $this->input->get('course_level_id') : null;
        }
      } elseif ($u->type == "TEACHER") {
        $user_id = $u->id;
        $batch_id = is_numeric($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
        $module_id = is_numeric($this->input->get('module_id')) ? $this->input->get('module_id') : null;
        $course_id = is_numeric($this->input->get('course_id')) ? $this->input->get('course_id') : null;
        $course_level_id = is_numeric($this->input->get('course_level_id')) ? $this->input->get('course_level_id') : null;
      } else {
        $user_id = $u->id;
        $batch_id = is_numeric($this->input->get('batch_id')) ? $this->input->get('batch_id') : null;
        $module_id = is_numeric($this->input->get('module_id')) ? $this->input->get('module_id') : null;
        $course_id = is_numeric($this->input->get('course_id')) ? $this->input->get('course_id') : null;
        $course_level_id = is_numeric($this->input->get('course_level_id')) ? $this->input->get('course_level_id') : null;
      }

      if ($d = $this->tutorial_model->get_all(1, $module_id, $user_id, $course_id , $course_level_id,$batch_id )) {
        return $this->http->response->create(200, "Tutorial fetched successfully", $d);
      } else {
        return $this->http->response->create(203, "Tutorial not found");
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }


  public function get($id = null)
  {
    try {
      $this->http->auth(["get"], ["ADMIN", "SUPPORT", "STUDENT", "TEACHER"]);
      if ($d = $this->tutorial_model->get($id)) {
        return $this->http->response->create(200, "Tutorial fetched successfully", $d);
      } else {
        return $this->http->response->create(203, "Tutorial not found");
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }
  //display files
  public function fetch_gallerys()
  {
    try {
      $u = $this->http->auth("get", ["ADMIN", "SUPPORT", "STUDENT", "TEACHER"]);
      if ($u->type == "SUPPORT" || $u->type == "ADMIN") {
        if ($this->input->get("self") == "true") {

          $user_id = $u->id;
          $module_id = is_numeric($this->input->get('module_id')) ? $this->input->get('module_id') : null;
          $tutorial_id = is_numeric($this->input->get('tutorial_id')) ? $this->input->get('tutorial_id') : null;
        } else {
          $user_id = is_numeric($this->input->get("user_id")) ? $this->input->get("user_id") : "";
          $module_id = is_numeric($this->input->get('module_id')) ? $this->input->get('module_id') : null;
          $tutorial_id = is_numeric($this->input->get('tutorial_id')) ? $this->input->get('tutorial_id') : null;
        }
      } elseif ($u->type == "TEACHER") {
        $user_id = $u->id;
        $module_id = is_numeric($this->input->get('module_id')) ? $this->input->get('module_id') : null;
        $tutorial_id = is_numeric($this->input->get('tutorial_id')) ? $this->input->get('tutorial_id') : null;
      } else {
        $user_id = $u->id;
        $module_id = is_numeric($this->input->get('module_id')) ? $this->input->get('module_id') : null;
        $tutorial_id = is_numeric($this->input->get('tutorial_id')) ? $this->input->get('tutorial_id') : null;
      }

      if ($files = $this->tutorial_file_model->get_files(1, $tutorial_id)) {
        return $this->http->response->create(200, "Tutorial fetched successfully", $files);
      } else {
        return $this->http->response->create(203, "Tutorial not found");
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }
  //update orders
  public function updateOrder()
  {
    // pp (111);
    try {
      $this->http->auth(["post", "get"], "ADMIN");
      $p = $this->http->request->all();

      if (!is_null($p['ids'])) {
        $data = explode(",", $p['ids']);

        if ($d = $this->tutorial_file_model->updateOrder($data)) {
          return $this->http->response->create(200, "Tutorial File Update successfully", $d);
        } else {
          return $this->http->response->create(203, "Tutorial File not found");
        }
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }
  //update orders
  public function tutorialOrder()
  {
    try {
      $this->http->auth(["post", "get"], "ADMIN");
      $p = $this->http->request->all();
      if (!is_null($p['ids'])) {
        $data = explode(",", $p['ids']);
        if ($d = $this->tutorial_model->updateOrder($data)) {
          return $this->http->response->create(200, "Tutorial Order successfully", $d);
        } else {
          return $this->http->response->create(203, "Tutorial Order fail");
        }
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }
  //deleted files
  public function delete_file()
  {
    try {
      $p = $this->http->request->all();
      $this->http->auth(["post"], "ADMIN");
      $t = $p['name'];
      $id = $p['id'];
      $f = str_replace(['"', '[', ']'], '', $t);
      $upload_path = FCPATH . 'documents/TUTORIAL/' . $f;


      if (!is_null($id)) {
        $ids = $this->tutorial_file_model->delete_file($id);
        $ids2 = $this->file_model->delete($id);
        if (!file_exists(FCPATH . $upload_path)) {

          unlink(FCPATH . 'documents/TUTORIAL/' . $f);
        }

        //   set_message("success", "Tutorial delete successfully");
        $this->http->response->create(200, "Deleted file successfully", $ids2 . $ids);
      } else {
        set_message("danger", "Tutorial delete failed");
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }
}
