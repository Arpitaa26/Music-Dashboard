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

class Question_option extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(["question_model", "question_option_model"]);
  }
  private function save_view($id = null)
  {
    $question = $this->question_model->get_all(1);
    if ($question_option = $this->question_option_model->get($id)) {
        view("question_option/create", compact("question", "question_option"), "Portal | Question option Edit");
    } else {
      view("question_option/create", compact("question"), "Portal | Question option Create");
    }
    
  }

  public function index()
  {
    try {
      $this->http->auth(["get"], "ADMIN");
      view("question_option/index", null, "Portal | Question option");
      } catch (\Throwable $th) {
          //throw $th;
          redirect(base_url('question_option'), 'refresh');
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
              'field' => 'question',
              'label' => 'Question',
              'rules' => 'required|numeric|is_exist[questions.id]',
              'errors' => array(
                'is_exist' => '%s not exist',
              )
            ],
            [
              'field' => 'option[]',
              'label' => 'Option',
              'rules' => 'trim|required|alpha_numeric_spaces'
            ],
            [
              'field' => 'is_correct[]',
              'label' => 'Correct',
              'rules' => 'required|in_list[0,1]',
              'errors' => array(
                'in_list' => '%s select one of Yes/No',
              ),
            ],
            [
              'field' => 'status[]',
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
          $question_id = $p['question'];

          $data = array_map(function ($o, $is, $s) use ($question_id) {
            return [
              "question_id" => $question_id,
              "option" => $o,
              "is_correct" => $is,
              "status" => $s,
            ];
          }, $p['option'], $p['is_correct'], $p['status']);

          if (!is_null($id)) {
            $data = $data[0];
            if ($this->question_option_model->update($id, $data)) {
              set_message("success", "Question option updated successfully");
            } else {
              set_message("danger", "Question option no changes found/failed");
            }
          } else {
            if ($this->question_option_model->insert_batch($data)) {
              set_message("success", "Question option created successfully");
            } else {
              set_message("danger", "Question option creation failed");
            }
          }
          redirect(base_url('question_option'), 'refresh');
        } else {
          $this->save_view($id);
        }
      } else {
        $this->save_view($id);
      }
    } catch (\Throwable $th) {
      redirect(base_url('question_option'), 'refresh');
    }
  }
  public function delete($id)
  {
    try {
      $this->http->auth(["get"], "ADMIN");
      
      if ($this->question_option_model->delete($id)) {
         set_message("success", "Question option deleted successfully");
      } else {
        set_message("danger", "Question option deleted failed");
      }
      redirect(base_url('question_option'), 'refresh');
    } catch (\Throwable $th) {
      //return $this->http->response->serverError();
      redirect(base_url('question_option'), 'refresh');
    }
  }

  public function get_all()
  {
    try {
      $this->http->auth(["get"],["ADMIN","TEACHER","STUDENT"]);
      if ($d = $this->question_option_model->get_all(1)) {
        return $this->http->response->create(200, "Question option fetched successfully", $d);
      } else {
        return $this->http->response->create(203, "Question option not found");
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }

//update orders
public function updateOption()
{
  try {
    $this->http->auth(["post"], "ADMIN");
    $p = $this->http->request->all();

    if (!is_null($p['ids'])) {
      $data = explode(",", $p['ids']);
      if ($d = $this->question_option_model->updateOrder($data)) {
        return $this->http->response->create(200, "Option orders successfully", $d);
      } else {
        return $this->http->response->create(203, "Option orders failed");
      }
    }
  } catch (\Throwable $th) {
    return $this->http->response->serverError();
  }
}

   

}


/* End of file Question.php */
/* Location: ./application/controllers/question/Question.php */