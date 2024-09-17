<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Class_reschedule_request_model extends CI_Model
{

  private $table = "class_reschedule_request";
  private $table_users = "users";
  private $table_user_types = "user_types";

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

  public function get_all($status = null, $class_id = null, $user_id = null, $limit = null, $offset = 0)
  {
    $this->db->select("c_re.*,u.email, concat(u.first_name,' ',u.middle_name,' ',u.last_name) as user_fullname, u_type.type as user_type");
    $this->db->from("{$this->table} c_re");
    $this->db->join("{$this->table_users} u", "u.id = c_re.user_id");
    $this->db->join("{$this->table_user_types} u_type", "u_type.id = u.user_type_id");
    if (!is_null($status)) {
      $this->db->where("c_re.status", $status);
    }

    if (!empty($class_id)) {
      $this->db->where("c_re.class_id", $class_id);
    }
    if (!empty($user_id)) {
      $this->db->where("c_re.user_id", $user_id);
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
}
