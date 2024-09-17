<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model User_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    Monirul Middya
 * @param     ...
 * @return    ...
 *
 */

class User_model extends CI_Model
{

  // ------------------------------------------------------------------------

  private $table = "users";
  private $table_user_pronouns = "user_pronouns";
  private $table_user_types = "user_types";

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function get_by_username($user_name)
  {
    $this->db->select("u.*, concat(u.first_name,' ',u.middle_name,' ',u.last_name) as full_name, ut.type, up.pronoun");
    $this->db->from("{$this->table} u");
    $this->db->join("{$this->table_user_types} ut", "ut.id = u.user_type_id");
    $this->db->join("{$this->table_user_pronouns} up", "up.id = u.user_pronoun_id");
    $this->db->limit(1);
    $this->db->where("u.username", $user_name);
    $this->db->or_where('u.email',$user_name);
    return $this->db->get()->row();
  }

  public function insert($data)
  {
    if ($did = auto_deduct_userid()) {
      $data["created_by"] = $did;
    }
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
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
  public function get_by_email($email)
  {
    $this->db->select("u.*, concat(u.first_name,' ',u.middle_name,' ',u.last_name) as full_name, ut.type, up.pronoun");
    $this->db->from("{$this->table} u");
    $this->db->join("{$this->table_user_types} ut", "ut.id = u.user_type_id");
    $this->db->join("{$this->table_user_pronouns} up", "up.id = u.user_pronoun_id");
    $this->db->limit(1);
    $this->db->where("u.email", $email);
    $result=$this->db->get()->row();
    
    return $result;
  }
  public function get_by_token($token)
  {
    $this->db->select("u.*, concat(u.first_name,' ',u.middle_name,' ',u.last_name) as full_name, ut.type, up.pronoun");
    $this->db->from("{$this->table} u");
    $this->db->join("{$this->table_user_types} ut", "ut.id = u.user_type_id");
    $this->db->join("{$this->table_user_pronouns} up", "up.id = u.user_pronoun_id");
    $this->db->limit(1);
    $this->db->where("u.otp", $token);
    $result=$this->db->get()->row();
    
    return $result;
  }
  public function get($id)
  {
    $this->db->select("u.*, concat(u.first_name,' ',u.middle_name,' ',u.last_name) as full_name, ut.type, up.pronoun");
    $this->db->from("{$this->table} u");
    $this->db->join("{$this->table_user_types} ut", "ut.id = u.user_type_id");
    $this->db->join("{$this->table_user_pronouns} up", "up.id = u.user_pronoun_id");
    $this->db->limit(1);
    $this->db->where("u.id", $id);
    $result=$this->db->get()->row();
    
    return $result;
  }

  public function get_all($status = null, $user_type_id = null,$user_id=null, $limit = null, $offset = 0)
  {
    $this->db->select("u.*, concat(u.first_name,' ',u.middle_name,' ',u.last_name) as full_name, ut.type, up.pronoun");
    $this->db->from("{$this->table} u");
    $this->db->join("{$this->table_user_types} ut", "ut.id = u.user_type_id");
    $this->db->join("{$this->table_user_pronouns} up", "up.id = u.user_pronoun_id");
    if (!is_null($status)) {
      $this->db->where("u.status", $status);
    }
    if (!empty($user_type_id)) {
      $this->db->where("u.user_type_id", $user_type_id);
    }
    if (!empty($user_id)) {
      $this->db->where("u.id",$user_id);
    }
    if (!empty($limit) && !empty($offset)) {
      $this->db->limit($limit, $offset);
    }
    return $this->db->get()->result();
  }
  public function delete($id)
  {
    $this->db->where("id", $id);
    $this->db->delete($this->table);
    return $this->db->affected_rows();
  }

  // ------------------------------------------------------------------------

}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */