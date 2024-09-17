<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Question_type_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    Monirul Middya
 * @return    ...
 *
 */

class Question_model extends CI_Model
{

  // ------------------------------------------------------------------------

  private $table = "questions";
  private $table_courses = "courses";
  private $table_modules = "modules";
  private $table_tutorial = "tutorial";
  private $table_courses_enrollment = "courses_enrollment";
  private $table_questions_options="question_options";
  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------

  // ------------------------------------------------------------------------
  public function insert($data)
  {
    if ($did = auto_deduct_userid()) {
      $data["created_by"] = $did;
    }
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }

  public function insert_batch($data)
  {
    if ($did = auto_deduct_userid()) {
      $data["created_by"] = $did;
    }
    $this->db->insert_batch($this->table, $data);
    return $this->db->affected_rows();
  }

  public function delete($id)
  {
    $this->db->where("id", $id);
    $this->db->delete($this->table);
    return $this->db->affected_rows();
  }

  public function update($id, $data)
  {
    if ($did = auto_deduct_userid()) {
      $data["updated_by"] = $did;
    }
    $this->db->where("id", $id);
    $this->db->update($this->table, $data);
    return $this->db->affected_rows();
  }
  //q order
  public function getorder($status = null, $course_id = null, $module_id = null)
  {
    $this->db->select("order AS total");
    $this->db->from($this->table);
    if ((!empty($course_id)) && (!empty($module_id))) {
      $this->db->where('course_id', $course_id);
      $this->db->where('module_id', $module_id);
    }
    if (!is_null($status)) {
      $this->db->where("status", $status);
    }
    return $this->db->count_all_results();
  }


  public function get($id)
  {
    $this->db->select("*");
    $this->db->from($this->table);
    $this->db->limit(1);
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function get_all($status = null, $course_id = null, $module_id = null, $user_id = null, $tutorial_id = null,$limit = null, $offset = 0)
  {

    $this->db->select("q.*,GROUP_CONCAT(q_op.is_correct) as is_correct,GROUP_CONCAT(q_op.id) as option_id,GROUP_CONCAT(q_op.option) as option, c.name as course_name,t.id as tutorial_id,t.title as tutorial_name, m.name as module_name");

    $this->db->from("{$this->table} q");
    $this->db->join("{$this->table_courses} c", "c.id = q.course_id");
    $this->db->join("{$this->table_modules} m", "m.id = q.module_id");
    $this->db->join("{$this->table_tutorial} t", "t.module_id = m.id");
    $this->db->join("{$this->table_questions_options} q_op", " q_op.question_id =q.id");
    $this->db->group_by('q.id');
    $this->db->order_by("`order`", "asc");
    if (!is_null($status)) {
      $this->db->where("q.status", $status);
    }
    if (!empty($user_id)) {
      $this->db->select("ce.user_id");
      $this->db->distinct('ce.course_id');
      $this->db->join("{$this->table_courses_enrollment} ce", "ce.course_id = q.course_id");
      $this->db->where("ce.user_id", $user_id);
    }
    if (!empty($tutorial_id)) {
      $this->db->where("t.id", $tutorial_id);
    }
    if (!empty($course_id)) {
      $this->db->where("q.course_id", $course_id);
    }
    if (!empty($module_id)) {
      $this->db->where("q.module_id", $module_id);
    }
    if (!empty($limit) && !empty($offset)) {
      $this->db->limit($limit, $offset);
    }
    return $this->db->get()->result();
  }


  function updateOrder($data)
  {

    $count = 1;
    foreach ($data as $id) {
      $datas["`order`"] =  $count;
      $this->db->where("id", $id);
      $this->db->update($this->table, $datas);
      $count++;
    }
    return $this->db->affected_rows();
  }
  // ------------------------------------------------------------------------

}

/* End of file Question_type_model.php */
/* Location: ./application/models/Question_type_model.php */