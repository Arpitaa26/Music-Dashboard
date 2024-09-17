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

class User_availability_model extends CI_Model
{

  // ------------------------------------------------------------------------

  private $table = "user_availability";
  private $table_users = "users";
  private $table_courses_teacher = "courses_teacher";
  private $table_courses_enrollment = "courses_enrollment";
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
    if ($did = auto_deduct_userid()) {

      $data = array_map(function ($dt) use ($did) {
        $dt["created_by"] = $did;
        return $dt;
      }, $data);
    }
    $this->db->insert_batch($this->table, $data);
    return $this->db->affected_rows();
  }
  public function delete($id)
  {
    $this->db->where("id", $id);
    $this->db->delete($this->table);
    return $this->db->affected_rows();
  }
  public function delete_availability($id,$from,$to)
  {
    if (!empty($from)&&!empty($to)) {
    $this->db->where("user_id", $id);
    $this->db->where("DATE_FORMAT(`from`,'%Y-%m-%d')>=", $from);
    $this->db->where("DATE_FORMAT(`from`,'%Y-%m-%d') <=", $to);
    $this->db->delete($this->table);
    return $this->db->affected_rows();
    }
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

  
  public function update_by_params($key_values,$data)
  {
    if ($did = auto_deduct_userid()) {
      $data["updated_by"] = $did;
    }
   
    foreach($key_values  as $params=>$values){
 
     $this->db->where($params, $values);
   }
    
    $this->db->update($this->table, $data);
    return $this->db->affected_rows();
  }
 public function get_filter( $user_id = null, $from = null)
  {
    $this->db->select("*");
    $this->db->from($this->table);
    $this->db->group_by("DATE_FORMAT(`from`,'%Y-%m-%d')");
    if (!empty($from)) {
     // pp($user_id);
      $this->db->where("DATE_FORMAT(`from`,'%Y-%m-%d') >=", $from);
    }
    if (!empty($user_id)) {
      $this->db->where("user_id", $user_id);
    }
    
    return $this->db->count_all_results();
  }
  public function get_all($status = null, $from = null, $to = null,$user_id = null,$class_id = null,$order=null,$limit = null, $offset = 0)
  {
    $this->db->select("a.*, concat(u.first_name,' ',u.middle_name,' ',u.last_name) as user_fullname");
    $this->db->from("{$this->table} a");
    $this->db->join("{$this->table_users} u", "u.id = a.user_id");
   // $this->db->join("{$this->table_courses_teacher} ct", "ct.user_id = a.user_id");
      $this->db->order_by("a.from",$order);
    if (!is_null($status)) {
      $this->db->where("a.status", $status);
    }
    if (!empty($class_id)) {
      $this->db->where("a.class_id", $class_id);
    }
    if (!empty($user_id)) {
      $this->db->where("a.user_id", $user_id);
    }
    if (!empty($from)) {
      $this->db->where("a.from <=", $to);
    }
    if (!empty($to)) {
      $this->db->where("a.to >=", $from);
    }
    if (!empty($limit) && !empty($offset)) {
      $this->db->limit($limit, $offset);
    }
    return $this->db->get()->result();
  }

  // ------------------------------------------------------------------------

}

/* End of file Question_type_model.php */
/* Location: ./application/models/Question_type_model.php */