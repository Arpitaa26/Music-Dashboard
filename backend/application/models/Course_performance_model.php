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

class Course_performance_model extends CI_Model
{

  // ------------------------------------------------------------------------

  private $table = "course_performance";
  private $table_performance_results= "performance_results";
  private $table_course_levels = "course_levels";
  private $table_users = "users";
  private $table_courses = "courses";
  private $table_modules = "modules";
  private $table_batches = "batches";
  private $table_files= "files";
  
  
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
  public function insert_performance_result($data)
  {
    if ($did = auto_deduct_userid()) {
      $data["created_by"] = $did;
    }
    $this->db->insert($this->table_performance_results, $data);
    return $this->db->insert_id();
  }
  public function update_performance_result($id, $data)
  {
    if ($did = auto_deduct_userid()) {
      $data["updated_by"] = $did;
    }
    $this->db->where("performance_id", $id);
    $this->db->update($this->table_performance_results, $data);
    return $this->db->affected_rows();
  }
  public function insert_batch($data)
  {
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
  public function update_performance($id, $data)
  {
    if ($did = auto_deduct_userid()) {
      $data["updated_by"] = $did;
    }
    $this->db->where("enrollment_id", $id);
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

  public function get_all($status = null,$course_id= null,$course_level_id= null,$batch_id= null,$user_id= null,$teacher_id= null,$limit = null, $offset = 0)
  {
    $this->db->select("cp.*,f.slug, concat(u.first_name,' ',u.middle_name,' ',u.last_name) AS user_fullname,concat(ut.first_name,' ',ut.middle_name,' ',ut.last_name) AS teacher_name,c.short_description,c.description , c.name AS course_name, b.code AS batch_code,cl.level,pr.marks,pr.result_type,pr.certificate_file");
    $this->db->distinct();
    $this->db->from("{$this->table} cp");
    $this->db->join("{$this->table_users} u", "u.id = cp.user_id");
    $this->db->join("{$this->table_courses} c", "c.id = cp.course_id");
    $this->db->join("{$this->table_course_levels} cl", "cl.id=cp.course_level_id");
    $this->db->join("{$this->table_performance_results} pr", "pr.performance_id=cp.id","left");
    $this->db->join("{$this->table_batches} b", "b.id = pr.batch_id","left");
    $this->db->join("{$this->table_modules} m", "m.id = pr.module_id","left");
    $this->db->join("{$this->table_users} ut", "ut.id=pr.user_id","left");
    $this->db->join("{$this->table_files} f", "f.id=pr.file_id","left");
    
    if (!is_null($status)) {
      $this->db->where("cp.status", $status);
    }
    if (!empty($course_id)) {
      $this->db->where("cp.course_id",$course_id);
    }
  
    if (!empty($course_level_id)) {
      $this->db->where("cp.course_level_id",$course_level_id);
    }
    if (!empty($user_id)) {
      $this->db->where("cp.user_id",$user_id);
    }
    if (!empty($batch_id)) {
      $this->db->where("pr.batch_id",$batch_id);
    }
    if (!empty($limit) && !empty($offset)) {
      $this->db->limit($limit, $offset);
    }
    return $this->db->get()->result();
  }
 
  
}

/* End of file course_enrollment_model.php */
/* Location: ./application/models/course_enrollment_model.php */