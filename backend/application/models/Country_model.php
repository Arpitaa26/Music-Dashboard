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

class Country_model extends CI_Model
{

  // ------------------------------------------------------------------------

  private $table = "country";

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
 

  public function get($id)
  {
    $this->db->select("*");
    $this->db->from($this->table);
    $this->db->limit(1);
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function get_country( $status = null,$limit = null, $offset = 0)
  {
    $this->db->select("*");
     $this->db->from("{$this->table}");
     $this->db->order_by("country_name", "asc");
   
    if (!is_null($status)) {
      $this->db->where("status", $status);
    }
    if (!empty($limit) && !empty($offset)) {
      $this->db->limit($limit, $offset);
    }
    return $this->db->get()->result();
  }
  public function get_all( $status = null,$country_name=null,$limit = null, $offset = 0)
  {
    $this->db->select("*");
     $this->db->from("{$this->table}");
     $this->db->order_by("country_name", "asc");
   
    if (!is_null($status)) {
      $this->db->where("status", $status);
    }
    if (!empty($country_name)) {
     $this->db->where("country_name", $country_name);
    }
    if (!empty($limit) && !empty($offset)) {
      $this->db->limit($limit, $offset);
    }
    return $this->db->get()->result();
  }
  public function get_filter( $status = null,$country_name='',$limit = null, $offset = 0)
  {
    $this->db->select("*");
     $this->db->from("{$this->table}");
     $this->db->order_by("country_name", "asc");
   
    if (!is_null($status)) {
      $this->db->where("status", $status);
    }
    if (!empty($country_name)) {
     $this->db->where("country_name", $country_name);
    }
    if (!empty($limit) && !empty($offset)) {
      $this->db->limit($limit, $offset);
    }
    $this->db->limit(1);
    return $this->db->get()->row();
  }
 

  public function get_by_name($country_name=null)
  {
     
    $this->db->select("*");
    $this->db->from("{$this->table}");
    if (!empty($country_name)) {
     $this->db->where("country_name", $country_name);
     }else{
         
     $this->db->where("country_name","Germany");
     }
     
     return $this->db->get()->row()->id;
   
}
  // ------------------------------------------------------------------------

}

/* End of file tutorial_model.php */
/* Location: ./application/models/tutorial_model.php */