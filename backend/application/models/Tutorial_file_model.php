<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Tutorial_file_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    Monirul Middya
 * @return    ...
 *
 */

class Tutorial_file_model extends CI_Model
{

  // ------------------------------------------------------------------------

  private $table = "tutorial_files";
  private $table_tutorial = "tutorial";
  private $table_modules = "modules";
  private $table_files = "files";
 
  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------

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
    return $this->db->insert_id();
  }

  public function delete($id)
  {
    $this->db->where("id", $id);
    $this->db->delete($this->table);
    return $this->db->affected_rows();
  }

  public function delete_tutorial($id)
  {
    $this->db->where("tutorial_id", $id);
    $this->db->delete($this->table);
    return $this->db->affected_rows();
  }
  public function delete_file($id)
  {
    $this->db->where("file_id", $id);
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
  //get order count file by id
  public function get_count($id = null, $status = null)
  {
    $this->db->select("order AS total");
    $this->db->from($this->table);
    if (!empty($id)) {
      $this->db->where('tutorial_id', $id);
    }
    if (!is_null($status)) {
      $this->db->where("status", $status);
    }
    return $this->db->count_all_results();
  }

  public function get_all( $status = null,$tutorial_id = null,$limit = null, $offset = 0)
  {
    $this->db->select("tf.*, t.title AS title_name, t.description AS description,t.id as tutorial_id");
    $this->db->from("{$this->table} tf");
    $this->db->join("{$this->table_tutorial} t", "t.tutorial_id = tf.tutorial_id");
    if(!empty($tutorial_id)){
      $this->db->where("tf.tutorial_id", $tutorial_id);
    }
    if (!is_null($status)) {
      $this->db->where("tf.status", $status);
    }
    if (!empty($limit) && !empty($offset)) {
      $this->db->limit($limit, $offset);
    }
    return $this->db->get()->result();
   
  }

  public function get_files( $status = null,$tutorial_id = null)
  {
    $this->db->select("t.*, tf.tutorial_id , tf.file_id,f.id,f.file_name,f.original_name,f.slug");
    $this->db->from("{$this->table} tf");
    $this->db->join("{$this->table_tutorial} t", "t.id = tf.tutorial_id");
    $this->db->join("{$this->table_files} f", "f.id = tf.file_id");
    $this->db->order_by("tf.`order`", "asc");
    if(!empty($tutorial_id)){
      $this->db->where("tf.tutorial_id", $tutorial_id);
    }
    if (!is_null($status)) {
      $this->db->where("tf.status", $status);
    }
    return $this->db->get()->result();
  }

  function updateOrder($data){ 
    $count = 1; 
   
    foreach ($data as $id){ 

    $datas["`order`"] =  $count;
   // pp ($datas);
      $this->db->where("file_id", $id);
      $this->db->update($this->table, $datas);
      $count ++;     
    } 
    return $this->db->affected_rows();
 } 
  // ------------------------------------------------------------------------

}

/* End of file batch_model.php */
/* Location: ./application/models/batch_model.php */