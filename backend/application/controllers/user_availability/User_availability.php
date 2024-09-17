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

class User_availability extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(["user_availability_model", "user_model"]);
  }

  public function index()
  {
    try {

      $this->http->auth(["get"], "ADMIN");
      $user_id = is_numeric($this->input->get("user_id")) ? $this->input->get("user_id") : "";
      $availability = $this->user_availability_model->get_all(null, null, null, $user_id);
      view("user_availability/index", compact("availability", "user_id"), "Portal | Batch");
    } catch (\Throwable $th) {
      //throw $th;
      redirect(base_url('User_availability'), 'refresh');
    }
  }
  private function save_view($id = null, $data = null)
  {
    $users = $this->user_model->get_all("active", 4, $id);
    if ($id) {
      if ($users) {

        $teacher = $this->user_availability_model->get_all(null, null, null, $id);
        view("user_availability/create", compact("teacher", "users", "data"), "Portal | Availability Edit");
      } else {
        redirect(base_url('user?user_type_id=4'), 'refresh');
      }
    } else {
      redirect(base_url('user?user_type_id=4'), 'refresh');
    }
  }

  public function save($id = null)
  {

    try {

      if (is_post()) {

        $this->http->auth(["post"], ["TEACHER", "ADMIN"]);
        $p = $this->http->request->all();

        foreach ($p['from'] as $key => $row) {
          $this->form_validation->set_rules([
            [
              'field' => 'from[' . $key . ']',
              'label' => 'From',
              'rules' => 'trim|required',
            ],
            [
              'field' => 'to[' . $key . ']',
              'label' => 'To',
              'rules' => 'trim|required',
            ],
            [
              'field' => 'status[' . $key . ']',
              'label' => 'Status',
              'rules' => 'required|in_list[0,1]',
              'errors' => array(
                'in_list' => '%s select one of Active/Inactive',
              ),
            ],
          ]);
        }
        if ($this->form_validation->run() == TRUE) {
          // $p = $this->http->request->all();
          // $from = date('Y-m-d H:i:s', strtotime($p['from']));
          // $to = date('Y-m-d H:i:s', strtotime($p['to']));

          // $d = [
          //   'user_id' => $user->id,
          //   'from' => $from,
          //   'to' => $to,
          //   'status' => $p['status']
          // ];

          if (!is_null($id)) {
            $d = array_map(function ($f, $t, $s) use ($id) {
              return [
                "user_id" => $id,
                "from" => $f,
                "to" => $t,
                "status" => $s,
              ];
            }, $p['from'], $p['to'], $p['status']);

            if ($id) {
              // $this->user_availability_model->delete_availability($id);
              $this->user_availability_model->insert_batch($d);
              //$this->http->response->create(200, "Use availability has been update successfully");
              redirect(base_url('user?user_type_id=4'), 'refresh');
            } else {
              return $this->http->response->create(203, "Use availability no changes found / failed");
            }
          } else {
            if ($this->user_availability_model->insert($d)) {
              return $this->http->response->create(200, "Use availability has been created successfully");
            } else {
              return $this->http->response->create(203, "Use availability creation failed");
            }
          }
        } else {
          $d = array_map(function ($f, $t, $s) use ($id) {
            return [
              "user_id" => $id,
              "from" => $f,
              "to" => $t,
              "status" => $s,
            ];
          }, $p['from'], $p['to'], $p['status']);
          $this->save_view($id, $d);
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
      $this->http->auth(["post", "get"], ["TEACHER", "ADMIN"]);
      if ($data = $this->user_availability_model->get($id)) {
        return $this->http->response->create(200, "User availability fetched successfully", $data);
      } else {
        return $this->http->response->create(203, "User availability not found of given id");
      }
    } catch (\Throwable $th) {
      //throw $th;
      return $this->http->response->serverError();
    }
  }

  public function get_all()
  {
    try {
      $u = $this->http->auth(["post", "get"], ["ADMIN", "SUPPORT", "STUDENT", "TEACHER"]);

      if ($u->type == "SUPPORT" || $u->type == "ADMIN") {

        if ($this->input->get("self") == "true") {

          $user_id = $u->id;
          $class_id = !empty($this->input->get('class_id')) ? $this->input->get('class_id') : null;
          $order = !empty($this->input->get('order')) ? $this->input->get('order') : 'ASC';
          $from = !empty($this->http->request->get('from')) ? $this->http->request->get('from') : null;
          $to = !empty($this->http->request->get('to')) ? $this->http->request->get('to') : null;
          $status = !empty($this->input->get('status')) ? $this->input->get('status') : null;
        } else {
          $user_id = $this->input->get("user_id");
          $class_id = !empty($this->input->get('class_id')) ? $this->input->get('class_id') : null;
          $order = !empty($this->input->get('order')) ? $this->input->get('order') : 'ASC';
          $from = !empty($this->http->request->get('from')) ? $this->http->request->get('from') : null;
          $to = !empty($this->http->request->get('to')) ? $this->http->request->get('to') : null;
          $status = !empty($this->input->get('status')) ? $this->input->get('status') : null;
        }
      }
      if ($u->type == "TEACHER") {
        $user_id = $u->id;
        $class_id = !empty($this->input->get('class_id')) ? $this->input->get('class_id') : null;
        $order = !empty($this->input->get('order')) ? $this->input->get('order') : 'ASC';
        $from = !empty($this->http->request->get('from')) ? $this->http->request->get('from') : null;
        $to = !empty($this->http->request->get('to')) ? $this->http->request->get('to') : null;
        $status = !empty($this->input->get('status')) ? $this->input->get('status') : null;
      } else {
        $id = $this->input->get('user_id');
        $user_id = isset($id) ? $id : $u->id;
        $class_id = !empty($this->input->get('class_id')) ? $this->input->get('class_id') : null;
        $order = !empty($this->input->get('order')) ? $this->input->get('order') : 'ASC';
        $from = !empty($this->http->request->get('from')) ? $this->http->request->get('from') : null;
        $to = !empty($this->http->request->get('to')) ? $this->http->request->get('to') : null;
        $status = !empty($this->input->get('status')) ? $this->input->get('status') : null;
      }
      if ($data = $this->user_availability_model->get_all($status, $from, $to, $user_id, $class_id, $order)) {
        return $this->http->response->create(200, "User availability fetched successfully",$data);
      } else {
        return $this->http->response->create(203, "User availability not found");
      }
    } catch (\Throwable $th) {
      //throw $th;
      return $this->http->response->serverError();
    }
  }

  public function delete($id)
  {
    try {
      $this->http->auth(["post", "get"], ["ADMIN"]);
      $data = $this->user_availability_model->get($id);
      if ($affected_rows = $this->user_availability_model->delete($id)) {
        set_message("success", "Use availability has been delete successfully");
      } else {
        set_message("danger", "Use availability delete failed");
      }
      redirect(base_url('user_availability/availability/' . $data->user_id), 'refresh');
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }
  public function delete_availability($id)
  {
    try {
      $this->http->auth(["post", "get"], ["ADMIN"]);
      $p = $this->http->request->all();
      $from =$p['from'] ;
      $to =$p['to'] ;
     
      if ($affected_rows = $this->user_availability_model->delete_availability($id,$from,$to)) {
        set_message("success", "Use availability has been delete all successfully");
      } else {
        set_message("danger", "Use availability delete failed");
      }
      redirect(base_url('user_availability/availability/' . $id), 'refresh');
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }



  public function availability()
  {
    try {
      $u = $this->http->auth(["post"], ["TEACHER", "ADMIN"]);
      if ($u->id) {
        $p = $this->http->request->all();
        $avil_data = $p;
        // pp($p);
        $user_id = $u->id;
        $status = 1;
        $setdatetime = array();
        foreach ($p as $day => $times) {

          $firstday = strtotime('next ' . $day);

          foreach ($times as $time) {

            for ($weekcnt = 0; $weekcnt < 16; $weekcnt++) {
              $date = strtotime("+" . (7 * $weekcnt) . "day", $firstday);
              $setdatetime[] = date('Y-m-d', $date) . " " . $time . ":00";
              $from = date('Y-m-d', $date) . " " . $time . ":00";
              // $chk = $this->user_availability_model->get_filter($user_id, (date('Y-m-d', $date) . " " . $time . ":00"));
            }
          }
        }

        $result = array_map(function ($f) use ($user_id, $status) {
          return [
            "user_id" => $user_id,
            "from" => $f,
            "to" => date('Y-m-d H:i:s', strtotime('+40 minutes', strtotime($f))),
            "status" => $status
          ];
        }, $setdatetime);

        $json = json_encode($avil_data);
        $fielddata = array('availability' => $json);
        $chk = $this->user_availability_model->get_filter($user_id, (date('Y-m-d')));
        //pp($result);
        if ($chk == '0') {
          $this->user_availability_model->insert_batch($result);
          $this->user_model->update($user_id, $fielddata);
          return $this->http->response->create(200, "Availability Insert Successfull ", $result);
        } else {
          return $this->http->response->create(203, "Already Exist try after this date ", $result);
        }
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }


  public function create($id = null)
  {
    try {
      $this->http->auth(["get", "post"], ["ADMIN", 'TEACHER']);

      if ($users = $this->user_model->get($id)) {

        $availability = $this->user_availability_model->get_all(null, null, null, $id);
        view("user_availability/index", compact("availability"), "Portal | availability Edit");
      } else {
        view("user_availability/index", null, "Portal | availability Create");
      }
    } catch (\Throwable $th) {
      redirect(base_url('user_availability'), 'refresh');
    }
  }
  public function edit($id = null)
  {
    try {
      $this->http->auth(["get", "post"], ["ADMIN", 'TEACHER']);

      if ($teacher = $this->user_availability_model->get($id)) {
        $users = $this->user_model->get($teacher->user_id);
        $av = json_decode($users->availability);

        if (is_post()) {
          $this->form_validation->set_rules([
            [
              'field' => 'from',
              'label' => 'From',
              'rules' => 'trim|required',
            ],
            [
              'field' => 'to',
              'label' => 'To',
              'rules' => 'trim|required',
            ]

          ]);

          if ($this->form_validation->run() == TRUE) {
            $p = $this->http->request->all();

            $from = date('Y-m-d H:i:s', strtotime($p['from']));

            $d = [
              'user_id' => $teacher->user_id,
              'from' => $from,
              'to' => $p['to']
            ];


            if ($id) {
              if ($this->user_availability_model->insert($d)) {
                //$users = $this->user_model->get($teacher->user_id);

                set_message("success", "Use availability has been created successfully");
              } else {
                return $this->http->response->create(203, "Use availability creation failed");
              }
            }
          }
        }
        view("user_availability/availability1", compact("teacher"), "Portal | availability Edit");
      } else {
        view("user_availability/availability1", null, "Portal | availability Create");
      }
    } catch (\Throwable $th) {
      redirect(base_url('user_availability'), 'refresh');
    }
  }
}
