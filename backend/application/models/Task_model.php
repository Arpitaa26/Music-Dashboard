<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Task_model extends CI_Model
{

  private $table = "tasks";
  private $table_task_comments= "task_comments";
  private $table_users= "users";
  // ------------------------------------------------------------------------

    public function __construct()
    {
      parent::__construct();
    }
  // ------------------------------------------------------------------------
    public function insert($data)
    {
    
      $this->db->insert($this->table, $data);
      return $this->db->insert_id();
    }
  // ------------------------------------------------------------------------

  public function insert_comment($data)
  {
  
    $this->db->insert($this->table_task_comments, $data);
    return $this->db->insert_id();
  }
  // ------------------------------------------------------------------------
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
// ------------------------------------------------------------------------
  public function get($id)
  {
    $this->db->from($this->table);
    $this->db->limit(1);
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }
// ------------------------------------------------------------------------
  public function get_all($status = null,$user_id=null,$task_id=null,$today=null,$role=null,$task_type=null, $limit = null, $offset = 0)
  {
  
    $this->db->select("t.*,concat(u.first_name,' ',u.middle_name,' ',u.last_name) as full_name");
    $this->db->from("{$this->table} t");
    $this->db->join("{$this->table_users} u", "u.id =t.user_id","left");
    if (!is_null($status)) {
      $this->db->where("t.status", $status);
    }
    if (!empty($task_id)) {
      $this->db->where("t.id", $task_id);
    
    }
    if (!empty($role)) {
      $this->db->where("t.role", $role);
    }
    if (!empty($user_id)&& empty($task_id)) {
      $this->db->where("t.created_by", $user_id);
      $this->db->or_where("t.user_id", $user_id);
    }
    if (!empty($task_type)) {
      $this->db->where("t.task_type", $task_type);
    
    }
    if (!empty($today)) {
      $this->db->where("DATE_FORMAT(t.task_date,'%Y-%m-%d')", $today);
    }
   
    if (!empty($limit) && !empty($offset)) {
      $this->db->limit($limit, $offset);
    }
  
    return $this->db->get()->result();
  }

  public function get_all_comments($task_id=null, $limit = null, $offset = 0)
  {
  
    $this->db->select("tc.*, u.id as user_id,concat(u.first_name,' ',u.middle_name,' ',u.last_name) as full_name");
    $this->db->from("{$this->table_task_comments} tc");
    $this->db->join("{$this->table} t", "t.id =tc.task_id");
    $this->db->join("{$this->table_users} u", "u.id =tc.user_id");
    if (!empty($task_id)) {
      $this->db->where("tc.task_id", $task_id);
    }
    if (!empty($limit) && !empty($offset)) {
      $this->db->limit($limit, $offset);
    }
    return $this->db->get()->result();
  }
// ------------------------------------------------------------------------
  public function update($id, $data)
  {
    if ($did = auto_deduct_userid()) {
      $data["updated_by"] = $did;
    }
//pp($id);
    $this->db->where('id', $id);
    $this->db->update($this->table, $data);
    return $this->db->affected_rows();
  }
// ------------------------------------------------------------------------

  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete($this->table);
    return $this->db->affected_rows();
  }


  // ------------------------------------------------------------------------
}
