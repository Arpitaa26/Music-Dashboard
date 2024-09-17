<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Module_model extends CI_Model
{

  private $table = "modules";
  private $table_course_levels = "course_levels";
  private $table_courses = "courses";

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
  public function insert_batch($data)
  {
    // $datas=array();
    if ($did = auto_deduct_userid()) {

      $data = array_map(function ($dt) use ($did) {
        $dt["created_by"] = $did;
        return $dt;
      }, $data);
    }


    $this->db->insert_batch($this->table, $data);
    return $this->db->affected_rows();
  }
  public function get($id)
  {
    $this->db->from($this->table);
    $this->db->limit(1);
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function get_all($status = null, $course_id = null, $course_level_id = null, $limit = null, $offset = 0)
  {
    
    $this->db->select("m.*, c.name as course_name,cl.level as course_level");
    $this->db->distinct('m.course_level_id');
    $this->db->from("{$this->table} m");
    $this->db->join("{$this->table_courses} c", "c.id = m.course_id");
    $this->db->join("{$this->table_course_levels} cl", "cl.id = m.course_level_id");
    
    
    $this->db->order_by("`order`", "asc");
    if (!is_null($status)) {
      $this->db->where("m.status", $status);
    }
    if (!empty($course_id)) {
      $this->db->where("m.course_id", $course_id);
    }
    if (!empty($course_level_id)) {
      $this->db->where("m.course_level_id", $course_level_id);
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
