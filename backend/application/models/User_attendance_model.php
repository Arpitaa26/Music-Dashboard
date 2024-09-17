<?php
defined('BASEPATH') or exit('No direct script access allowed');


class User_attendance_model extends CI_Model
{
  private $table = "user_attendance";
  private $table_users = "users";
  private $table_classes = "scheduled_classes";
  private $table_batches = "batches";
  private $table_courses= "courses";
  private $table_courses_enrollment = "courses_enrollment";

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

  public function get_filter($class_id = null, $user_id = null, $status = null)
  {

    $this->db->select("*");
    $this->db->from($this->table);
    if (!empty($class_id)) {
      $this->db->where("class_id", $class_id);
    }
    if (!empty($user_id)) {
      $this->db->where("user_id", $user_id);
    }
    if (!empty($status)) {
      $this->db->where("status", $status);
    }
    $this->db->limit(1);
    return $this->db->get()->row();
  //pp($this->db->get_compiled_select());
  }
  public function get_filter_batch($class_id = null, $batch_id = null, $status = null)
  {

    $this->db->select("*");
    $this->db->from($this->table);
    if (!empty($class_id)) {
      $this->db->where("class_id", $class_id);
    }
    if (!empty($batch_id)) {
      $this->db->where("batch_id", $batch_id);
    }
    if (!empty($status)) {
      $this->db->where("status", $status);
    }
    $this->db->limit(1);
    return $this->db->get()->row();
 
  }
  public function get($id)
  {
    $this->db->select("*");
    $this->db->from($this->table);
    $this->db->where("id", $id);
    $this->db->limit(1);
    return $this->db->get()->row();
  }

  public function get_all($status = null, $class_id=null,$batch_id=null,$user_id=null,$from=null,$to=null,$limit = null, $offset = 0)
  {
    $this->db->select("att.*, concat(u.first_name,' ',u.middle_name,' ',u.last_name) as user_full_name, b.code AS batch_code, 
                          c.start_time AS class_start_time, c.end_time AS class_end_time");
    $this->db->from("{$this->table} as att");
    $this->db->join("{$this->table_users} as u", "att.user_id = u.id");
    $this->db->join("{$this->table_batches} as b", "att.batch_id = b.id");
    $this->db->join("{$this->table_classes} as c", "att.class_id = c.id");
    $this->db->join("{$this->table_courses} crs", "crs.id = b.course_id");
    if (!is_null($status)) {
      $this->db->where("att.status", $status);
    }
    if (!empty($class_id)) {
      $this->db->where("att.class_id", $class_id);
    }
    if (!empty($batch_id)) {
      $this->db->where("att.batch_id", $batch_id);
    }
    if (!empty($user_id)) {
      $this->db->where("att.user_id", $user_id);
    }
    if (!empty($from)) {
      $this->db->where("DATE_FORMAT(att.created_on, '%Y-%m-%d') <= ", $to);
    }
    if (!empty($to)) {
      $this->db->where("DATE_FORMAT(att.created_on, '%Y-%m-%d') >=", $from);
    }
    if (!empty($limit) && !empty($offset)) {
      $this->db->limit($limit, $offset);
    }
    return $this->db->get()->result();
  }

  
  public function get_attendance($status = null, $class_id=null,$batch_id=null,$user_id=null,$from=null,$to=null,$limit = null, $offset = 0)
  {
   
    $this->db->select("att.*, concat(u.first_name,' ',u.middle_name,' ',u.last_name) as user_full_name, b.code AS batch_code, 
                          c.start_time AS class_start_time, c.end_time AS class_end_time");
    $this->db->from("{$this->table} as att");
    $this->db->join("{$this->table_users} as u", "att.user_id = u.id");
    $this->db->join("{$this->table_batches} as b", "att.batch_id = b.id");
    $this->db->join("{$this->table_classes} as c", "att.class_id = c.id");
    $this->db->join("{$this->table_courses} crs", "crs.id = b.course_id");
    $this->db->where('YEAR(att.created_on)', date('Y'));
    $this->db->group_by("YEAR(att.created_on),MONTH(att.created_on)");
    if (!is_null($status)) {
      $this->db->where("att.status", $status);
    }
    if (!empty($class_id)) {
      $this->db->where("att.class_id", $class_id);
    }
    if (!empty($batch_id)) {
      $this->db->where("att.batch_id", $batch_id);
    }
    if (!empty($user_id)) {
      $this->db->where("att.user_id", $user_id);
    }
    if (!empty($from)) {
      $this->db->where("a.created_on <", $to);
    }
    if (!empty($to)) {
      $this->db->where("a.created_on >", $from);
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
  
  public function update_batch($batch_id, $data)
  {
    if ($did = auto_deduct_userid()) {
      $data["updated_by"] = $did;
    }
   
    $this->db->where('batch_id', $batch_id);
    $this->db->update($this->table, $data);
    return $this->db->affected_rows();
  }
  
  // public function delete($id)
  // {
  //   $this->db->where('id', $id);
  //   $this->db->delete($this->table);
  //   return $this->db->affected_rows();
  // }

  public function left($class_id, $user_id)
  {
    $this->db->set("left_on", 'CURRENT_TIMESTAMP', FALSE);
    $this->db->where('class_id', $class_id);
    $this->db->where('user_id', $user_id);
    $this->db->update($this->table);
    return $this->db->affected_rows();
  }

  public function feedback($class_id, $user_id, $feedback = null)
  {
    $this->db->set("feedback", $feedback);
    $this->db->where('class_id', $class_id);
    $this->db->where('user_id', $user_id);
    $this->db->update($this->table);
    return $this->db->affected_rows();
  }
  public function get_month_barchart(){
    $this->db->select("COUNT(user_id) as users,COUNT(class_id) as class,COUNT(batch_id) as batch,MONTHNAME(created_on) as month_name");
    $this->db->from("{$this->table}");
    $this->db->where('YEAR(created_on)', date('Y'));
    $this->db->group_by("YEAR(created_on),MONTH(created_on)");
    $record= $this->db->get()->result();
	  $data = [];
			foreach($record as $row) {
				$data['months'][] = $row->month_name;
				$data['users'][] = (int) $row->users;
				$data['batches'][] = (int) $row->batch;
				$data['classes'][] = (int) $row->class;
			}
			 return $data['chart_month_data'] = json_encode($data);
   }
   public function get_day_barchart(){
    $this->db->select("COUNT(user_id) as users,COUNT(class_id) as class,COUNT(batch_id) as batch,DAYNAME(created_on) as day_name");
    $this->db->from("{$this->table}");
    $this->db->where('YEAR(created_on)', date('Y'));
    $this->db->group_by("YEAR(created_on),DAY(created_on)");
    $record= $this->db->get()->result();
    $data = [];
	 
			foreach($record as $row) {
				$data['days'][] = $row->day_name;
				$data['users'][] = (int) $row->users;
				$data['batches'][] = (int) $row->batch;
				$data['classes'][] = (int) $row->class;
			}
			return $data['chart_day_data'] = json_encode($data);

   }
}
