<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Course_history_model extends CI_Model
{

  private $table = "course_history`";
  private $table_teacher = "batch_teacher";
  private $table_modules = "modules";
  private $table_batches = "batches";
  private $table_users = "users";
  private $table_courses = "courses";
  private $table_course_levels = "course_levels";
  private $table_courses_enrollment = "courses_enrollment";

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

  public function get_all($status = null,$user_id = null, $module_id = null, $batch_id = null,$course_id= null,$course_level_id= null, $limit = null, $offset = 0)
  {

    $this->db->select("ch.*, m.name AS module_name, b.code AS batch_code,c.name as course_name,cl.level as course_level, concat(u.first_name,' ',u.middle_name,' ',u.last_name) AS user_fullname");
    $this->db->from("{$this->table} ch");
    $this->db->join("{$this->table_modules} m", "m.id = ch.module_id");
    $this->db->join("{$this->table_batches} b", "b.id = ch.batch_id");
    $this->db->join("{$this->table_users} u", "u.id = ch.user_id");
   //  $this->db->join("{$this->table_courses_enrollment} c_enroll", "c_enroll.course_id =m.course_id");
    $this->db->join("{$this->table_courses} c", "c.id = m.course_id");
   $this->db->join("{$this->table_course_levels} cl", "cl.id = m.course_level_id");
    if (!is_null($status)) {
      $this->db->where("ch.status", $status);
    }
    if (!empty($course_id)) {
      $this->db->where("m.course_id", $course_id);
    }
    if (!empty($course_id)) {
      $this->db->where("m.course_level_id", $course_level_id);
    }
    if (!empty($module_id)) {
      $this->db->where("ch.module_id", $module_id);
    }
    if (!empty($batch_id)) {
      $this->db->where("ch.batch_id", $batch_id);
    }
    if (!empty($user_id)) {
      $this->db->where("ch.user_id", $user_id);
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
  public function update_batch($data)
  {
   
    $this->db->update($this->table, $data,'batch_id');
    return $this->db->affected_rows();
  }
  public function filter_by_batch($batch_id)
  {
    $this->db->from($this->table);
    $this->db->where('batch_id', $batch_id);
    $query= $this->db->get();
    if ($query->num_rows() > 0)
        {
        return $query->result(); 
        }else{
          return false;
        }
  }
  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete($this->table);
    return $this->db->affected_rows();
  }
  public function delete_batch($id)
  {
   
     $this->db->where('batch_id', $id);
    $this->db->delete($this->table);
    return $this->db->affected_rows();
  }
}
