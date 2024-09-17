<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Batch_teacher_model extends CI_Model
{

  private $table = "batch_teacher";
  private $table_modules = "modules";
  private $table_batches = "batches";
  private $table_users = "users";

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

  public function get_all($status = null, $batch_id = null,$user_id = null,  $limit = null, $offset = 0)
  {

    $this->db->select("bt.*, m.name AS module_name, b.code AS batch_code, concat(u.first_name,' ',u.middle_name,' ',u.last_name) AS user_fullname");
    $this->db->from("{$this->table} bt");
    $this->db->join("{$this->table_modules} m", "m.id = bt.module_id");
    $this->db->join("{$this->table_batches} b", "b.id = bt.batch_id");
    $this->db->join("{$this->table_users} u", "u.id = bt.user_id");
    if (!is_null($status)) {
      $this->db->where("bt.status", $status);
    }
    if (!empty($batch_id)) {
      $this->db->where("bt.batch_id", $batch_id);
    }
    
    if (!empty($user_id)) {
      $this->db->where("bt.user_id", $user_id);
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
  public function delete_batch($id)
  {
   
     $this->db->where('batch_id', $id);
    $this->db->delete($this->table);
    return $this->db->affected_rows();
  }
}
