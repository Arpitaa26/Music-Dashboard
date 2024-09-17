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

class Course_enrollment_model extends CI_Model
{

  // ------------------------------------------------------------------------

  private $table = "courses_enrollment";
  private $table_users = "users";
  private $table_courses = "courses";
  private $table_course_levels = "course_levels";
  private $table_batches = "batches";
  private $table_batch_teacher = "batch_teacher";
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

  public function get_filter($batch_id = null, $user_id = null, $status = null)
  {
    $this->db->select("*");
    $this->db->from($this->table);
    if (!empty($batch_id)) {
      $this->db->where("batch_id", $batch_id);
    }
    if (!empty($user_id)) {
      $this->db->where("user_id", $user_id);
    }
    if (!is_null($status)) {
      $this->db->where("status", $status);
    }
    $this->db->limit(1);
    return $this->db->get()->row();
  }
  public function get($id)
  {
    $this->db->select("*");
    $this->db->from($this->table);
    $this->db->limit(1);
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function get_all($status = null, $user_id = null, $course_id = null, $course_level_id = null, $batch_id = null, $teacher_id = null, $limit = null, $offset = 0)
  {
    $this->db->select("c_enroll.*,u.email, concat(u.first_name,' ',u.middle_name,' ',u.last_name) AS user_fullname,c.short_description,c.description , c.name AS course_name, b.code AS batch_code,cl.level");
    $this->db->distinct();
    $this->db->from("{$this->table} c_enroll");
    $this->db->join("{$this->table_users} u", "u.id = c_enroll.user_id");
    $this->db->join("{$this->table_courses} c", "c.id = c_enroll.course_id");
    $this->db->join("{$this->table_batches} b", "b.id = c_enroll.batch_id", 'left');
    $this->db->join("{$this->table_course_levels} cl", "cl.id=c_enroll.course_level_id");
    if (!is_null($status)) {
      $this->db->where("c_enroll.status", $status);
    }
    if (!empty($course_id)) {
      $this->db->where("c_enroll.course_id", $course_id);
    }
    if (!empty($teacher_id)) {
      $this->db->select("bt.user_id AS teacher_id,bt.batch_id");
      $this->db->join("{$this->table_batch_teacher} bt", "bt.batch_id=c_enroll.batch_id");
      $this->db->where("bt.user_id", $teacher_id);
    }
    if (!empty($course_level_id)) {
      $this->db->where("c_enroll.course_level_id", $course_level_id);
    }
    if (!empty($user_id)) {
      $this->db->where("c_enroll.user_id", $user_id);
    }
    if (!empty($batch_id)) {
      $this->db->where("c_enroll.batch_id", $batch_id);
    }
    if (!empty($limit) && !empty($offset)) {
      $this->db->limit($limit, $offset);
    }
    return $this->db->get()->result();
  }
  public function get_batch_students($status = null, $user_id = null, $course_id = null, $course_level_id = null, $batch_id = null, $teacher_id = null, $limit = null, $offset = 0)
  {
    $this->db->select("c_enroll.*, concat(u.first_name,' ',u.middle_name,' ',u.last_name) AS user_fullname,c.short_description,c.description ,c.name AS course_name, b.code AS batch_code,cl.level");
    $this->db->distinct();
    $this->db->from("{$this->table} c_enroll");
    $this->db->join("{$this->table_users} u", "u.id = c_enroll.user_id");
    $this->db->join("{$this->table_courses} c", "c.id = c_enroll.course_id");
    $this->db->join("{$this->table_batches} b", "b.id = c_enroll.batch_id");
    $this->db->join("{$this->table_course_levels} cl", "cl.id=c_enroll.course_level_id");
    if (!is_null($status)) {
      $this->db->where("c_enroll.status", $status);
    }
    if (!empty($course_id)) {
      $this->db->where("c_enroll.course_id", $course_id);
    }
    if (!empty($teacher_id)) {
      $this->db->select("bt.user_id AS teacher_id,bt.batch_id");
      $this->db->join("{$this->table_batch_teacher} bt", "bt.batch_id=c_enroll.batch_id", 'right');
      $this->db->where("bt.user_id", $teacher_id);
    }
    if (!empty($course_level_id)) {
      $this->db->where("c_enroll.course_level_id", $course_level_id);
    }
    if (!empty($user_id)) {
      $this->db->where("c_enroll.user_id", $user_id);
    }
    if (!empty($batch_id)) {
      $this->db->where("c_enroll.batch_id", $batch_id);
    }
    if (!empty($limit) && !empty($offset)) {
      $this->db->limit($limit, $offset);
    }
    return $this->db->get()->result();
  }
}

/* End of file course_enrollment_model.php */
/* Location: ./application/models/course_enrollment_model.php */