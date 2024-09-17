<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model tutorial_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    Monirul Middya
 * @return    ...
 *
 */

class Tutorial_model extends CI_Model
{

  // ------------------------------------------------------------------------

  private $table = "tutorial";
  private $table_modules = "modules";
  private $table_tutorial_files = "tutorial_files";
  private $table_files = "files";
  private $table_courses_enrollment = "courses_enrollment";
  private $table_users = "users";
  private $table_courses = "courses";
  private $table_course_history= "course_history";
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
  public function insert_tutorial_file($data)
  {
    if ($did = auto_deduct_userid()) {
      $data["created_by"] = $did;
    }
    $this->db->insert_batch($this->table_tutorial_files, $data);
    return $this->db->insert_id();
  }
  public function update_tutorial_file($id,$data)
  {
    if ($did = auto_deduct_userid()) {
      $data["updated_by"] = $did;
    }
    $this->db->where("id", $id);
    $this->db->update($this->table_tutorial_files, $data);
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
  //tuto file
  public function getid($id = null, $status = null)
  {
    $this->db->select("order AS total");
    $this->db->from($this->table_tutorial_files);
    if (!empty($id)) {
      $this->db->where('tutorial_id', $id);
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

  public function get_all( $status = null,$module_id = null,$user_id = null,$course_id= null,$course_level_id= null,$batch_id = null,$limit = null, $offset = 0)
  {
    $this->db->select("t.*, m.name AS module_name,m.id AS module_id,m.course_id,h.status as h_status");
     $this->db->from("{$this->table} t");
     $this->db->join("{$this->table_modules} m", "m.id = t.module_id");
     $this->db->join("{$this->table_courses} c", "c.id =m.course_id");
     $this->db->join("{$this->table_course_history} h", "h.module_id =t.module_id", "left");
     
     $this->db->order_by("`order`", "asc");
     $this->db->group_by("t.id");
    if (!empty($module_id)) {
      $this->db->where("t.module_id", $module_id);
    }
    if (!empty($course_level_id)) {
      $this->db->where("m.course_id", $course_id);
    }
     if (!empty($course_level_id)) {
      $this->db->where("m.course_level_id", $course_level_id);
    }
    if ((!empty($user_id))&&(!empty($batch_id))) {
     $this->db->join("{$this->table_courses_enrollment} c_enroll", "c_enroll.user_id='".$user_id."'");
     $this->db->join("{$this->table_users} u", "u.id = c_enroll.user_id");
     $this->db->where("c_enroll.user_id", $user_id);
     $this->db->where("c_enroll.batch_id", $batch_id);
    }
    if (!is_null($status)) {
      $this->db->where("t.status", $status);
    }
    if (!empty($limit) && !empty($offset)) {
      $this->db->limit($limit, $offset);
    }
    return $this->db->get()->result();
  }
  function updateOrder($data){ 
   
    $count = 1; 
    foreach ($data as $id){ 
    $datas["`order`"] =  $count;
      $this->db->where("id", $id);
     $this->db->update($this->table, $datas);
        $count ++;     
    } 
    return $this->db->affected_rows();
} 
  // ------------------------------------------------------------------------

}

/* End of file tutorial_model.php */
/* Location: ./application/models/tutorial_model.php */