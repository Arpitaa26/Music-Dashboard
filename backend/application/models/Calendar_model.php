<?php

class Calendar_model extends CI_Model
{
private $table = "calendar_events";
private $table_scheduled_classes = "scheduled_classes";
private $table_user_availability = "user_availability";
private $table_users= "users";
    public function __construct()
    {
        parent::__construct();
       
    }

   public function get_events($start=null, $end=null)
{
  
// $this->db->select('*');
// $this->db->from('tbl_calendar_events');
// $this->db->where('start_date >=', $start);
// $this->db->where('end_date =',$end);
// $query = $this->db->get();
// return $result = $query->result();
  return $this->db->where("start_date>=", $start)->where("end_date<=", $end)->get("tbl_calendar_events")->result();
  
}
   public function get_class($start=null, $end=null)
{
  
$this->db->select('*');
$this->db->from('tbl_scheduled_classes');
//$this->db->where('start_time >=', $start);
//$this->db->where('end_time =',$end);
$query = $this->db->get();
return $query->result();
 // return $this->db->where("start_time>=", $start)->where("end_time<=", $end)->get("tbl_scheduled_classes")->result();
  
}
public function get_availability($start=null, $end=null)
{
  
$this->db->select("av.*,concat(u.first_name,' ',u.middle_name,' ',u.last_name) AS user_fullname");
$this->db->from("{$this->table_user_availability} as av");
$this->db->join("{$this->table_users} as u", "av.user_id = u.id");
//$this->db->where('start_time >=', $start);
//$this->db->where('end_time =',$end);
$query = $this->db->get();
return $query->result();
 
}

public function add_event($data)
{
    $this->db->insert("tbl_calendar_events", $data);
}

public function get_event($id)
{
    return $this->db->where("ID", $id)->get("tbl_calendar_events");
}

public function update_event($id, $data)
{
    $this->db->where("ID", $id)->update("tbl_calendar_events", $data);
}

public function delete_event($id)
{
    $this->db->where("ID", $id)->delete("tbl_calendar_events");
}
}
