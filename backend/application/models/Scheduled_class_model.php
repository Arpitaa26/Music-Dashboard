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

class Scheduled_class_model extends CI_Model
{

  // ------------------------------------------------------------------------

  private $table = "scheduled_classes";
  private $table_session_types = "session_types";
  private $table_batches = "batches";
  private $table_modules = "modules";
  private $table_users = "users";
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

  public function get($id)
  {
    $this->db->select("*");
    $this->db->from($this->table);
    $this->db->limit(1);
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function get_all($status = null, $from = null, $to = null, $student_id = null, $user_id = null,$batch_id = null)
  {
    $this->db->select("sc_cls.*,u.email, concat(u.first_name,' ',u.middle_name,' ',u.last_name) as full_name,sc_type.type AS session_type, b.code AS batch_code, m.name AS module_name");
    $this->db->from("{$this->table} sc_cls");
    $this->db->join("{$this->table_session_types} sc_type", "sc_type.id = sc_cls.session_id");
    $this->db->join("{$this->table_batches} b", "b.id = sc_cls.batch_id");
    $this->db->join("{$this->table_modules} m", "m.id = sc_cls.module_id");
    $this->db->join("{$this->table_users} as u", "sc_cls.user_id = u.id");

    if (!empty($student_id)) {
      $this->db->join("{$this->table_courses_enrollment} ce", "ce.batch_id = sc_cls.batch_id");
      $this->db->where("ce.user_id", $student_id);
    }
    if (!empty($batch_id)) {
      $this->db->where("sc_cls.batch_id", $batch_id);
    }
    if (!empty($user_id)) {
      $this->db->where("sc_cls.user_id", $user_id);
    }
    if (!empty($from) && !empty($to)) {
      $this->db->where("sc_cls.start_time >=", $from);
      $this->db->where("sc_cls.start_time <=", date('Y-m-d', strtotime($to . ' +1 day')));
    }
    if (!is_null($status)) {
      $this->db->where("sc_cls.status", $status);
    }
    if (!empty($limit) && !empty($offset)) {
      $this->db->limit($limit, $offset);
    }
    return $this->db->get()->result();
  }

  public function format_task($info = null)
  {

    if (!empty($info)) {
      $template = $info['title'];
      $template = str_replace('[BATCH_NAME]', $info['bach_id'], $template);
      return $template;
    }
  }

  
  public function get_filter($user_id = null,$request_date = null,$previous_date = null,  $status = null)
  {
    
    $this->db->select("*");
    $this->db->from($this->table);
    if (!empty($request_date)) {
      $this->db->where("DATE_FORMAT(`rescheduled_date`,'%Y-%m')", $request_date);
    }
    if (!empty($previous_date)) {
      $this->db->or_where("DATE_FORMAT(`rescheduled_date`,'%Y-%m')", $previous_date);
    }
    if (!empty($user_id)) {
      $this->db->where("user_id", $user_id);
    }
    if (!is_null($status)) {
      $this->db->where("status", $status);
    }
    $this->db->limit(1);
   return $this->db->get()->row();
   // pp($this->db->last_query());
  }
  // ------------------------------------------------------------------------

}

/* End of file Question_type_model.php */
/* Location: ./application/models/Question_type_model.php */