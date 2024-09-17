<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Course_level_model extends CI_Model
{

  private $table = "course_levels";

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }
  public function insert($data)
  {
    if ($did = auto_deduct_userid()) {
      $data["created_by"] = $did;
    }
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }
  public function get($id)
  {
    $this->db->from($this->table);
    $this->db->limit(1);
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function get_all($status = null, $course_level_id = null, $limit = null, $offset = 0)
  {
    $this->db->select("*");
    $this->db->from($this->table);
    $this->db->order_by("`order`");
    if (!is_null($status)) {
      $this->db->where("status", $status);
    }
    if (!empty($course_level_id)) {
      $this->db->where("id", $course_level_id);
    }
    if (!empty($limit) && !empty($offset)) {
      $this->db->limit($limit, $offset);
    }
    return $this->db->get()->result();
  }

  public function update($id, $data)
  {
    if ($did = auto_deduct_userid()) {
      $data["updated_by"] = $did;
    }
    $this->db->where('id', $id);
    $this->db->update($this->table, $data);
    return $this->db->affected_rows();
  }

  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete($this->table);
    return $this->db->affected_rows();
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
}
