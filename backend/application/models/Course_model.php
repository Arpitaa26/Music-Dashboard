<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Course_model extends CI_Model
{

  private $table = "courses";
  private $table_course_levels = "course_levels";
  private $table_country_pricing = "country_pricing";
  private $table_session_types = "session_types";
  private $table_country = "country";

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

  public function update($id, $data)
  {
    if ($did = auto_deduct_userid()) {
      $data["updated_by"] = $did;
    }
    $this->db->where('id', $id);
    $this->db->update($this->table, $data);
    return $this->db->affected_rows();
  }
  
  public function get_all($status = null, $course_id = null, $limit = null, $offset = 0)
  {
    $this->db->select("*");
    $this->db->from($this->table);
   
    if (!is_null($status)) {
      $this->db->where('status', $status);
    }
    if (!empty($course_id)) {
      $this->db->where('id', $course_id);
    }
    if (!empty($limit) && !empty($offset)) {
      $this->db->limit($limit, $offset);
    }
    return $this->db->get()->result();
  }
  public function get_course_price($status = null,$country_id = null, $course_id = null, $limit = null, $offset = 0)
  {
    $this->db->select("cp.*,cl.level,c.name,c.description,c.short_description,c.code,st.type,cc.country_name,cp.cost_per_class as price");
    $this->db->from("{$this->table_country_pricing} cp");
    $this->db->join("{$this->table_country} cc", "cc.id=cp.country_id");
    $this->db->join("{$this->table} c", "c.id=cp.course_id");
    $this->db->join("{$this->table_course_levels} cl", "cl.id=cp.course_level_id");
    $this->db->join("{$this->table_session_types} st", "st.id=cp.session_type_id");
    
    if (!is_null($status)) {
      $this->db->where('cp.status', $status);
    }
    if (!empty($course_id)) {
      $this->db->where('cp.id', $course_id);
    }
    if (!empty($country_id)) {
      $this->db->where('cp.country_id', $country_id);
    }
    if (!empty($limit) && !empty($offset)) {
      $this->db->limit($limit, $offset);
    }
    return $this->db->get()->result();
  }

  public function get($id)
  {
    $this->db->from($this->table);
    $this->db->limit(1);
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }
  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete($this->table);
    return $this->db->affected_rows();
  }
}
