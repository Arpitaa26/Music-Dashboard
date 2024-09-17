<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Course_teacher_model extends CI_Model
{

  private $table = "courses_teacher";
  private $table_courses = "courses";
  private $table_users = "users";
  private $table_batches = "batches";

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
    // if ($did = auto_deduct_userid()) {
    //   $data["created_by"] = $did;
    // }
    $this->db->insert_batch($this->table, $data);
    return $this->db->affected_rows();
  }

  public function get_filter($batch_id = null, $user_id = null, $status = null)
  {
    
    $this->db->select("c_te.*");
    $this->db->from("{$this->table} c_te");
    $this->db->join("{$this->table_batches} b", "b.course_id=c_te.course_id", "left");
    if (!empty($batch_id)) {
      $this->db->where("b.id", $batch_id);
    }
    if (!empty($user_id)) {
      $this->db->where("c_te.user_id", $user_id);
    }
    if (!is_null($status)) {
      $this->db->where("c_te.status", $status);
    }
    $this->db->limit(1);
    return $this->db->get()->row();
  }
  
  public function get($id)
  {
    $this->db->select("*");
    $this->db->from($this->table);
    $this->db->where("id", $id);
    $this->db->limit(1);
    return $this->db->get()->row();
  }

  public function get_all($status = null,$user_id=null,$course_id=null, $limit = null, $offset = 0)
  {
    $this->db->select("c_t.*, concat(u.first_name,' ',u.middle_name,' ',u.last_name) AS user_fullname, c.name AS course_name");
    $this->db->from("{$this->table} c_t");
    $this->db->join("{$this->table_courses} c", "c.id = c_t.course_id");
    $this->db->join("{$this->table_users} u", "u.id = c_t.user_id");
    if (!is_null($status)) {
      $this->db->where("c_t.status", $status);
    }
    if (!empty($user_id)) {
      $this->db->where("c_t.user_id", $user_id);
    }
    if (!empty($course_id)) {
      $this->db->where("c_t.course_id", $course_id);
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

  public function delete_course($id)
  {
  
    $this->db->where('user_id', $id);
    $this->db->delete($this->table);
    return $this->db->affected_rows();
  }
}
