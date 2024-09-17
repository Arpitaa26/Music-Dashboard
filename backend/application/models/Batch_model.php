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

class Batch_model extends CI_Model
{

  // ------------------------------------------------------------------------

  private $table = "batches";
  private $table_courses = "courses";
  private $table_course_levels= "course_levels";

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

  // public function insert_batch($data)
  // {
  //   $this->db->insert_batch($this->table, $data);
  //   return $this->db->affected_rows();
  // }

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
  public function batch_count($course_id,$course_level_id)
  {
  
    $this->db->select('*');
    $this->db->where('course_id',$course_id);
    $this->db->where('course_level_id',$course_level_id);
    return $this->db->count_all_results($this->table);  
  }
  public function get($id)
  {
 
    $this->db->from($this->table);
    $this->db->limit(1);
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function get_all($status = null, $course_id = null, $course_level_id = null, $batch_id = null, $limit = null, $offset = 0)
  {
    $this->db->select("b.*, c.name AS course_name,cl.level");
    $this->db->from("{$this->table} b");
    $this->db->join("{$this->table_courses} c", "c.id = b.course_id");
    $this->db->join("{$this->table_course_levels} cl", "cl.id = b.course_level_id");
    $this->db->order_by("`order`", "asc");
    if (!empty($course_id)) {
      $this->db->where("b.course_id", $course_id);
    }
    if (!empty($course_level_id)) {
      $this->db->where("b.course_level_id", $course_level_id);
    }
    if (!empty($batch_id)) {
      $this->db->where("b.id", $batch_id);
    }

    if (!empty($limit) && !empty($offset)) {
      $this->db->limit($limit, $offset);
    }

    if (!is_null($status)) {
      $this->db->where("b.status", $status);
    }
    return $this->db->get()->result();
  }


  
  function updateOrder($data)
  {
    //pp($data );
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

/* End of file batch_model.php */
/* Location: ./application/models/batch_model.php */