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

class Question extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(["question_model","tutorial_model", "question_option_model","file_model", "course_model", "module_model"]);
  }
  private function save_view($id = null, $data = null)
  {
    $courses = $this->course_model->get_all(1);
    $modules = $this->module_model->get_all(1);
    $tutorials = $this->tutorial_model->get_all(1);
    if ($id != null) {
      view("question/create", compact("courses", "modules","tutorials", "data"), "Portal | Question Edit");
    } else {
      view("question/create", compact("courses", "modules","tutorials", "data"), "Portal | Question Create");
    }
  }

  public function index()
  {
    try {
      $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
      $module_id = is_numeric($this->input->get("module_id")) ? $this->input->get("module_id") : "";
      $tutorial_id = is_numeric($this->input->get("tutorial_id")) ? $this->input->get("tutorial_id") : "";
      $courses = $this->course_model->get_all(1);
      $modules = $this->module_model->get_all(1);
      $tutorials = $this->tutorial_model->get_all(1);
      $this->http->auth(["get"], "ADMIN");
      view("question/index", compact("courses", "modules","tutorials","tutorial_id", "course_id", "module_id"), "Portal | Question");
    } catch (\Throwable $th) {
      //throw $th;
      redirect(base_url('question'), 'refresh');
    }
  }
  public function save($id = null)
  {
    try {
      $this->http->auth(["post","get"], ["ADMIN","TEACHER", "SUPPORT"]);
      $p = $this->http->request->all();
      
      if (is_post()) {
       
        $course_id = $this->input->post('course_id');
        $this->form_validation->set_rules(
          [
            [
              'field' => 'course_id',
              'label' => 'Course',
              'rules' => 'required|numeric|is_exist[modules.course_id]',
              'errors' => array(
                'is_exist' => '%s not exist in this course',
              )
            ],
            [
              'field' => 'module_id',
              'label' => 'Module',
              'rules' => "required|numeric|is_exist_where_in[modules.id.course_id.{$course_id}]",
              'errors' => array(
                'is_exist_where_in' => '%s not exist in this course',
              )
            ],
            [
              'field' => 'type',
              'label' => 'Question Type',
              'rules' => 'required|in_list[INPUT,SINGLE_SELECT,MULTI_SELECT,DATE,FILE]',
            ],
            [
              'field' => 'category',
              'label' => 'Category',
              'rules' => 'required|in_list[COURSE_MODULE,BATCH,BATCH_STUDENT]',
            ],
            [
              'field' => 'name',
              'label' => 'Name',
              'rules' => 'trim|required|alpha_numeric_spaces'
            ],

            [
              'field' => 'marks',
              'label' => 'Marks',
              'rules' => 'trim|required|numeric'
            ],
            [
              'field' => 'q_status',
              'label' => 'Status',
              'rules' => 'required|in_list[0,1]',
              'errors' => array(
                'in_list' => '%s select one of Active/Inactive',
              ),
            ]
          ]
        );

        //TODO BAPAN: if option changes but no change in question - update options

        if ((($p['type'] == 'SINGLE_SELECT') || ($p['type'] == 'MULTI_SELECT'))) {

          if (isset($p['option'])) {
            if (array_sum($p['is_correct']) > 0) {
              foreach ($p['option'] as $key => $row) {

                //TODO BAPAN: Atleast one is_correct should be Yes for Multi select
                //TODO BAPAN: Only one is_correct should be Yes for single select
                $this->form_validation->set_rules(
                  [


                    [
                      'field' => 'option[' . $key . ']',
                      'label' => 'Option',
                      'rules' => 'trim|required|alpha_numeric_spaces'
                    ],
                    [
                      'field' => 'is_correct[' . $key . ']',
                      'label' => 'is_correct',
                      'rules' => 'required|in_list[0,1]'
                    ],

                    [
                      'field' => 'o_status[' . $key . ']',
                      'label' => 'Status',
                      'rules' => 'required|in_list[0,1]',
                      'errors' => array(
                        'in_list' => '%s select one of Active/Inactive',
                      ),
                    ]
                  ]
                );
              }
            } else {
              set_message("danger", " One correct is mandatory");
            }
          } else {
            //TODO BAPAN: throw error that one option is mandatory
          }
        }
        if ($this->form_validation->run() == true) {
         
           
              $category = $this->http->request->get("category");
              $description = $this->http->request->get("description");
              $path="questions/";
              $data = array();
              if(!empty($_FILES['file']['name']))
              {
                
                $result = $this->functions->file_insert($path, 'file', 'image', '9097152');
               
                if($result['status'] == 1){
                  $course_id = $p['course_id'];
                  $module_id = $p['module_id'];
                  $orders = $this->question_model->getorder(1, $course_id, $module_id);
                  $order = $orders + 1;
                  $data = [
                  "course_id" => $course_id,
                  "module_id" => $module_id,
                  "type" => $p['type'],
                  "name" => $p['name'],
                  "order" => $order,
                  "marks" => $p['marks'],
                  "hints" => $p['hints'],
                  "file_name"=> $path.$result['msg'],
                  "category" => $p['category'],
                  "status" => $p['q_status'],
                  ];
                  $data["file_name"]= $path.$result['msg'];
                }else{

                    $course_id = $p['course_id'];
                    $module_id = $p['module_id'];
                    $orders = $this->question_model->getorder(1, $course_id, $module_id);
                    $order = $orders + 1;
                    $data = [
                    "course_id" => $course_id,
                    "module_id" => $module_id,
                    "type" => $p['type'],
                    "name" => $p['name'],
                    "order" => $order,
                    "marks" => $p['marks'],
                    "hints" => $p['hints'],
                    "category" => $p['category'],
                    "status" => $p['q_status'],
                    ];
                }
              
              }
             
          $isSingleSelectError = 0;
          if ($p['type'] == 'SINGLE_SELECT') {
            if (array_sum(array_filter($p['is_correct'], function ($k) {
              return $k == 1;
            })) > 1) {
              set_message("danger", "Only One correct is allowed in Single Select");

              $isSingleSelectError = 1;
            }
          }

          if (!is_null($id)) {

            if ((($p['type'] == 'SINGLE_SELECT') || ($p['type'] == 'MULTI_SELECT'))) {
              if (!empty($p['option'])) {

                if ((array_sum($p['is_correct']) >=1)) {
               
                  if ($isSingleSelectError == 0) {
                    $data = array_map(function ($o_id, $o, $is, $s, $keys) use ($id) {
                      return [
                        "id" => $o_id,
                        "question_id" => $id,
                        "option" => $o,
                        "order" => $keys + 1,
                        "is_correct" => $is,
                        "status" => $s,
                      ];
                    }, $p['option_id'], $p['option'], $p['is_correct'], $p['o_status'], array_keys($p['option']));

                    if ($this->question_option_model->delete_option($id)) {
                      $this->question_option_model->insert_batch($data);
                      set_message("success", "Question And Option updated successfully");
                    }
                  }
                } else {
                  set_message("danger", " One correct is mandatory");
                }
              } else {
                set_message("danger", " One option is mandatory");
              }
            } else {
              $this->question_model->update($id, $data);
              set_message("success", "Question updated successfully");
            }
          } else {

            if ((($p['type'] == 'SINGLE_SELECT') || ($p['type'] == 'MULTI_SELECT'))) {

              if (!empty($p['option'])) {
                if ((array_sum($p['is_correct']) >= 1)) {
                 
                  if ($isSingleSelectError == 0) {
                    $getid = $this->question_model->insert($data);
                    if (!empty($getid)) {
                      $data = array_map(function ($o, $is, $s, $keys) use ($getid) {
                        return [
                          "question_id" => $getid,
                          "option" => $o,
                          "order" => $keys + 1,
                          "is_correct" => $is,
                          "status" => $s,
                        ];
                      }, $p['option'], $p['is_correct'], $p['o_status'], array_keys($p['option']));

                      $this->question_option_model->insert_batch($data);
                      set_message("success", "Question And Option created successfully");
                    }
                  }
                } else {
                  set_message("danger", " One correct is mandatory");
                }
              } else {

                set_message("danger", " One option is mandatory");
              }
            } else {
              $this->question_model->insert($data);
              set_message("success", "Question created successfully");
            }
            // set_message("danger", "Question created failed");
          }
          redirect(base_url('question'), 'refresh');
        } else {
             //if validation error
          $p = $this->http->request->all();

          $course_id = $p['course_id'];
          $module_id = $p['module_id'];
          $orders = $this->question_model->getorder($course_id, $module_id, 1);
          $order = $orders + 1;
          $data = (object) [
            "course_id" => $course_id,
            "module_id" => $module_id,
            "type" => $p['type'],
            "name" => $p['name'],
            "order" => $order,
            "marks" => $p['marks'],
            "hints" => $p['hints'],
            "category" => $p['category'],
            "q_status" => $p['q_status']

          ];
          if ((($p['type'] == 'SINGLE_SELECT') || ($p['type'] == 'MULTI_SELECT')) && (!empty($p['option']))) {

            $question_option = array_map(function ($option, $is_correct, $o_status) {
              return (object)[
                "option" => $option,
                "is_correct" => $is_correct,
                "status" => $o_status
              ];
            }, $p['option'], $p['is_correct'], $p['o_status']);


            $data = (object)[
              "course_id" => $course_id,
              "module_id" => $module_id,
              "type" => $p['type'],
              "name" => $p['name'],
              "order" => $order,
              "marks" => $p['marks'],
              "hints" => $p['hints'],
              "q_status" => $p['q_status'],
              "category" => $p['category'],
              "question_option" => (object)$question_option
            ];

            $this->save_view($id, $data);
          } else {

            $this->save_view($id, $data);
            //  set_message("danger", "Atleast one option create");
          }
        }
      } else {
        if ($id != null) {
          $question = $this->question_model->get($id);
          $question->question_option = $this->question_option_model->get_all(1, $id);
          $this->save_view($id, $question);
        } else {
          $this->save_view();
        }
      }
    } catch (\Throwable $th) {
      redirect(base_url('question'), 'refresh');
    }
  }
  public function delete($id)
  {
    try {
      $this->question_option_model->delete_option($id);
      if ($this->question_model->delete($id)) {
        set_message("success", "Question deleted successfully");
      } else {
        set_message("danger", "Question deleted failed");
      }
      redirect(base_url('question'), 'refresh');
    } catch (\Throwable $th) {
      redirect(base_url('question'), 'refresh');
    }
  }

  public function get_all()
  {
    try {
      $u = $this->http->auth("get", ["ADMIN", "SUPPORT", "STUDENT", "TEACHER"]);
          if ($u->type == "SUPPORT" || $u->type == "ADMIN") {
              if ($this->input->get("self") == "true") {
                $user_id =$u->id;
                $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
                $module_id = is_numeric($this->input->get("module_id")) ? $this->input->get("module_id") : "";
                $tutorial_id = is_numeric($this->input->get("tutorial_id")) ? $this->input->get("tutorial_id") : "";
              } else {
                $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
                $module_id = is_numeric($this->input->get("module_id")) ? $this->input->get("module_id") : "";
                $tutorial_id = is_numeric($this->input->get("tutorial_id")) ? $this->input->get("tutorial_id") : "";
                $user_id = is_numeric($this->input->get("user_id")) ? $this->input->get("user_id") : "";
              }
            }elseif ($u->type == "TEACHER") {
                $user_id = is_numeric($this->input->get("user_id")) ? $this->input->get("user_id") : "";
                $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
                $module_id = is_numeric($this->input->get("module_id")) ? $this->input->get("module_id") : "";
                $tutorial_id = is_numeric($this->input->get("tutorial_id")) ? $this->input->get("tutorial_id") : "";
              } else {
                $user_id =$u->id;
                $course_id = is_numeric($this->input->get("course_id")) ? $this->input->get("course_id") : "";
                $module_id = is_numeric($this->input->get("module_id")) ? $this->input->get("module_id") : "";
                $tutorial_id = is_numeric($this->input->get("tutorial_id")) ? $this->input->get("tutorial_id") : "";
          }
    

      if ($d = $this->question_model->get_all(1, $course_id, $module_id,$user_id,$tutorial_id)) {
        return $this->http->response->create(200, "Questions fetched successfully", $d);
      } else {
        return $this->http->response->create(203, "Questions not found");
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }


  //update orders
  public function updateOrder()
  {
    try {
      $this->http->auth(["post"], "ADMIN");
      $p = $this->http->request->all();

      if (!is_null($p['ids'])) {
        $data = explode(",", $p['ids']);

        if ($d = $this->question_model->updateOrder($data)) {
          return $this->http->response->create(200, "Questions order successfully", $d);
        } else {
          return $this->http->response->create(203, "Questions order failed");
        }
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }
}


/* End of file Question.php */
/* Location: ./application/controllers/question/Question.php */