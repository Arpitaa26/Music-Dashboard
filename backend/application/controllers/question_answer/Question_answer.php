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

class Question_answer extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(["question_model", "tutorial_model", "question_answer_model", "question_option_model", "file_model", "course_model", "module_model"]);
  }

  public function index()
  {
    try {

      $this->http->auth(["post", "get"], ["ADMIN", "TEACHER", "STUDENT"]);
      view("question/answer", null, "Portal | Answer");
    } catch (\Throwable $th) {
      //throw $th;
      redirect(base_url('question_answer'), 'refresh');
    }
  }
  public function save($id = null)
  {
    try {
      $u = $this->http->auth(["post", "get"], ["ADMIN", "TEACHER", "STUDENT"]);
      $p = $this->http->request->all();
      
      if (is_post()) {

        $this->form_validation->set_rules(
          [
            [
              'field' => 'user_id',
              'label' => 'User_id',
              'rules' => "required|numeric",
            ],
            [
              'field' => 'question_id[]',
              'label' => 'Question_ID',
              'rules' => "required|numeric",

            ],
            [
              'field' => 'answer[]',
              'label' => 'Answer',
              'rules' => 'trim|required|alpha_numeric_spaces'
            ],
            [
              'field' => 'is_correct[]',
              'label' => 'Correct',
              'rules' => 'trim|required|alpha_numeric_spaces'
            ],


          ]
        );

        if ($this->form_validation->run() == true) {


          if (!is_null($id)) {
            $user_id = $p['user_id'];
            $course_id = isset($p['course_id'])?$p['course_id']:null;
            $course_level_id =isset($p['course_level_id'])?$p['course_level_id']:null;
            $module_id = isset($p['module_id'])?$p['module_id']:null;
            $tutorial_id = isset($p['tutorial_id'])?$p['tutorial_id']:null;
            $data = array_map(function ($question_id, $ans) use ($user_id,$course_id,$course_level_id,$module_id,$tutorial_id) {
              return [
                "user_id" => $user_id,
                "course_id" => $course_id,
                "course_level_id" => $course_level_id,
                "module_id" => $module_id,
                "tutorial_id" => $tutorial_id,
                "answer" => $ans
              ];
            }, $p['question_id'], $p['answer']);

            $this->question_answer_model->insert_batch($data);
            return $this->http->response->create(200, "Question answer insert successfully");
          } else {
            return $this->http->response->create(203, "User_id not found");
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


  public function delete($id)
  {
    try {
     
      if ($this->question_answer_model->delete($id)) {
        set_message("success", "Question Answer deleted successfully");
      } else {
        set_message("danger", "Question Answer deleted failed");
      }
      redirect(base_url('question_answer'), 'refresh');
    } catch (\Throwable $th) {
      redirect(base_url('question_answer'), 'refresh');
    }
  }

  public function get_all()
  {
    try {
      $u = $this->http->auth("get", ["ADMIN", "SUPPORT", "STUDENT", "TEACHER"]);
      if ($u->type == "SUPPORT" || $u->type == "ADMIN") {
        if ($this->input->get("self") == "true") {
          $user_id = $u->id;
        } else {
          $user_id = is_numeric($this->input->get("user_id")) ? $this->input->get("user_id") : "";
        }
      } elseif ($u->type == "TEACHER") {
        $user_id = is_numeric($this->input->get("user_id")) ? $this->input->get("user_id") : "";
       
      } else {
        $user_id = $u->id;
       
      }
      if ($d = $this->question_answer_model->get_all($user_id)) {
        return $this->http->response->create(200, "Questions Answer fetched successfully", $d);
      } else {
        return $this->http->response->create(203, "Questions Answer not found");
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }
}


/* End of file Question.php */
/* Location: ./application/controllers/question/Question.php */