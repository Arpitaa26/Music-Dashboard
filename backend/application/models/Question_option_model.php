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

class Question_option_model extends CI_Model
{

  // ------------------------------------------------------------------------

  private $table = "question_options";
  private $table_questions = "questions";

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
    /*if ($did = auto_deduct_userid()) {
      $data["created_by"] = $did;
    }
    pp($data);*/
    $this->db->insert_batch($this->table, $data);
    return $this->db->affected_rows();
  }

  public function delete($id)
  {
    $this->db->where("id", $id);
    $this->db->delete($this->table);
    return $this->db->affected_rows();
  }

  public function delete_option($id)
  {
    $this->db->where("question_id", $id);
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


  public function get($id)
  {
    $this->db->select("*");
    $this->db->from($this->table);
    $this->db->limit(1);
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function get_all( $status = null,$question_id=null,$limit = null, $offset = 0)
  {
    $this->db->select("q_op.*, q.name AS question_name");
    $this->db->from("{$this->table} q_op");
    $this->db->join("{$this->table_questions} q", "q.id = q_op.question_id");
    $this->db->order_by("`order`", "asc");
    if (!is_null($status)) {
      $this->db->where("q_op.status", $status);
    }
    if (!is_null($question_id)) {
      $this->db->where("q_op.question_id", $question_id);
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
    //  $this->db->where("question_id", $question_id);
      $this->db->update($this->table, $datas);
      $count++;
    }
    return $this->db->affected_rows();
  }
  // ------------------------------------------------------------------------

}

/* End of file Question_type_model.php */
/* Location: ./application/models/Question_type_model.php */