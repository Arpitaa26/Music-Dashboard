<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model File_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    Monirul Middya
 * @return    ...
 *
 */

class File_model extends CI_Model
{

  protected $table = "files";

  public $slug = null;

  public $file_url = null;

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();

    $this->file_url = base_url("file/open/");
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------

  private function slug($filename)
  {
    $slug = pathinfo($filename, PATHINFO_FILENAME);
    while (true) {
      if ($this->get_filter(null, $slug)) {
        $slug .= time();
      } else {
        $this->slug = $slug;
        return $slug;
      }
    }
  }

  // get all rows
  public function get_all($status = null,$user_id=null,$category=null, $limit = null, $offset = 0)
  {
    $this->db->select("*");
    $this->db->from($this->table);
    if (!is_null($status)) {
      $this->db->where("status", $status);
    }
    if (!empty($user_id) ) {
      $this->db->where("created_by", $user_id);
    }
    if (!empty($category) ) {
      $this->db->where("category", $category);
    }
    if (!empty($limit) && is_numeric($offset)) {
      $this->db->limit($limit, $offset);
    }
   
    return $this->db->get()->result();
  }
  //get one row
  public function get($id)
  {
    $this->db->select("*");
    $this->db->from($this->table);
    $this->db->limit(1);
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }
  //get one row
  public function get_filter($id = null, $slug = null)
  {
    $this->db->select("*");
    $this->db->from($this->table);
    $this->db->limit(1);
    if (!empty($id)) {
      $this->db->where("id", $id);
    }
    if (!empty($slug)) {
      $this->db->where("slug", $slug);
    }
    return $this->db->get()->row();
  }
  //insert files
  public function insert($data)
  {
    if ($did = auto_deduct_userid()) {
      $data["created_by"] = $did;
    }
   
    $data["slug"] = $this->slug($data["file_name"]);
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }
  //update files
  public function update($id, $data)
  {
    if ($did = auto_deduct_userid()) {
      $data["updated_by"] = $did;
    }
    $this->db->where('id', $id);
    $this->db->update($this->table, $data);
    return $this->db->affected_rows();
  }
  //delete file

  public function delete($id)
  {
    $this->db->where("id", $id);
    $this->db->delete($this->table);
    return $this->db->affected_rows();
  }
  // ------------------------------------------------------------------------

}

/* End of file File_model.php */
/* Location: ./application/models/File_model.php */