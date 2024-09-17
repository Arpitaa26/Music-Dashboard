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

class Home_model extends CI_Model
{

  // ------------------------------------------------------------------------

  private $table = "users";
  private $table_user_types = "user_types";
  private $table_user_attendance = "user_attendance";
  private $table_tasks = "tasks";
  private $table_scheduled_classes = "scheduled_classes";

  public function __construct()
  {
    parent::__construct();
  }

  public function get_admin_all()
  {

    $this->db->select("u.*, ut.id AS user_type_id,ut.type");
    $this->db->from("{$this->table} u");
    $this->db->join("{$this->table_user_types} ut", "ut.id =u.user_type_id");
    $this->db->where('ut.type', 'ADMIN');
    $result = $this->db->get();
    $results = $result->result();
    $total_rows = $result->num_rows();
    return array(
      'total_rows' => $total_rows,
      'result'     => $results,
    );
  }
  // ------------------------------------------------------------------------
  //get order count file by id
  public function get_count($type = null)
  {

    $this->db->select("u.*, ut.id AS user_type_id,ut.type");
    $this->db->from("{$this->table} u");
    $this->db->join("{$this->table_user_types} ut", "ut.id =u.user_type_id");
    if (!empty($type)) {
      $this->db->where('ut.type', $type);
    }
    return $this->db->count_all_results();
  }

  public function get_active($type = null)
  {
    $this->db->select("u.*, ut.id AS user_type_id,ut.type");
    $this->db->from("{$this->table} u");
    $this->db->join("{$this->table_user_types} ut", "ut.id =u.user_type_id");
    $this->db->join("{$this->table_user_attendance} ua", "ua.user_id=u.id");
    if (!empty($type)) {
      $this->db->where('ut.type', $type);
    }
    return $this->db->count_all_results();
  }

  public function get_task_count($status = null, $today = null, $role = null)
  {

    $this->db->select("*");
    $this->db->from("{$this->table_tasks}");
    if (!empty($status)) {
      $this->db->where('status', $status);
    }
    if (!empty($role)) {
      $this->db->where('role', $role);
    }
    if (!empty($today)) {
      $this->db->where("DATE_FORMAT(task_date,'%Y-%m-%d')", $today);
    }
    return $this->db->count_all_results();
  }
  public function get_support_ticket($status = null)
  {

    $this->db->select("*");
    $this->db->from("{$this->table_tasks}");
    if (!is_null($status)) {
      $this->db->where('status', $status);
    }
    return $this->db->count_all_results();
  }

  // ------------------------------------------------------------------------

  function fetch_year()
  {
    $this->db->select("YEAR(created_on) AS year, MONTH(created_on) AS month,DAY(created_on) AS date");
    $this->db->from("{$this->table_user_attendance}");
    $this->db->group_by("created_on");
    $this->db->order_by("created_on", "DESC");
    return $this->db->get()->result();
  }
  function fetch_chart_data($year)
  {

    $this->db->from("{$this->table_user_attendance}");
    $this->db->where('YEAR(created_on)', $year);
    $this->db->order_by('YEAR(created_on)', "ASC");
    return $this->db->get()->result();
  }
  // ------------------------------------------------------------------------
  function fetch_chart_year()
  {
    $this->db->select("YEAR(created_on) AS year, MONTH(created_on) AS month,DAY(created_on) AS date");
    $this->db->from("{$this->table_user_attendance}");
    $this->db->group_by("YEAR(created_on)");
    $this->db->order_by("created_on", "DESC");
    return $this->db->get()->result();
  }
  function fetch_chart_month()
  {

    $this->db->select("COUNT(user_id) as users,YEAR(created_on) AS year,MONTHNAME(created_on) as month_name,DAY(created_on) AS date");
    $this->db->from("{$this->table_user_attendance}");
    $this->db->where('YEAR(created_on)', date('Y'));
    $this->db->group_by("MONTH(created_on)");
    $this->db->order_by("created_on", "DESC");
    $record = $this->db->get()->result();
    $data = [];
    foreach ($record as $row) {
      $data['months'][] = $row->month_name;
      $data['users'][] = (int) $row->users;
    }
    return $data['chart_month_data'] = json_encode($data);
  }
  function fetch_chart_day()
  {
    $this->db->select("COUNT(user_id) as users,DAYNAME(created_on) AS day_name");
    $this->db->from($this->table_user_attendance);
    $this->db->where('YEAR(created_on)', date('Y'));
    // $this->db->where('MONTH(created_on)',date('m'));
    $this->db->group_by('DAYNAME(created_on)');
    $this->db->order_by('created_on', 'DESC');
    $record =  $this->db->get()->result();
    $data = [];
    foreach ($record as $row) {
      $data['months'][] = $row->day_name;
      $data['users'][] = (int) $row->users;
    }
    return $data['chart_day_data'] = json_encode($data);
  }
  function fetch_chart_week()
  {
    $this->db->select("COUNT(user_id) as users,DAY(created_on) AS day_name");
    $this->db->from("{$this->table_user_attendance}");
    $this->db->where('YEAR(created_on)', date('Y'));
    $this->db->where('MONTH(created_on)', date('m'));
    $this->db->group_by("WEEKOFYEAR(created_on)");

    // date(created_at) > (DATE(NOW()) - INTERVAL 7 DAY)
    $this->db->order_by("created_on", "DESC");
    $record =  $this->db->get()->result();
    $data = [];
    foreach ($record as $row) {
      $data['months'][] = $row->day_name;
      $data['users'][] = (int) $row->users;
    }
    return $data['chart_week_data'] = json_encode($data);
  }

  public function get_years_whise()
  {
    $this->db->select("COUNT(user_id) as users,YEAR(start_time) as years");
    $this->db->from("{$this->table_scheduled_classes}");
    $this->db->where('YEAR(start_time)', date('Y'));
    $this->db->where('status', 'STARTED');
    $this->db->group_by("YEAR(start_time)");
    $record = $this->db->get()->result();
    $data = [];
    foreach ($record as $row) {
      $data['years'][] = $row->years;
      $data['users'][] = (int) $row->users;
    }
    return $data['chart_month_data'] = json_encode($data);
  }
  public function get_months_whise()
  {
    $this->db->select("COUNT(user_id) as users,MONTHNAME(start_time) as month_name");
    $this->db->from("{$this->table_scheduled_classes}");
    $this->db->where('YEAR(start_time)', date('Y'));
    $this->db->where('status', 'STARTED');
    $this->db->group_by("YEAR(start_time),MONTH(start_time)");
    $record = $this->db->get()->result();
    $data = [];
    foreach ($record as $row) {
      $data['months'][] = $row->month_name;
      $data['users'][] = (int) $row->users;
    }
    return $data['chart_month_data'] = json_encode($data);
  }
  public function get_weeks_whise()
  {
    $this->db->select("COUNT(user_id) as users,DAYNAME(start_time) as day_name");
    $this->db->from("{$this->table_scheduled_classes}");
    $this->db->where('date(start_time)>=', '(DATE(NOW()) - INTERVAL 7 DAY)');
    $this->db->where('YEAR(start_time)', date('Y'));
    $this->db->where('status', 'STARTED');
    //$this->db->where('MONTH(created_on)', date('%m'));
    $this->db->group_by("DAYNAME(start_time)");
    $record = $this->db->get()->result();
    // $monday = strtotime('next Monday -1 week');
    // $monday = date('w', $monday)==date('w') ? strtotime(date("Y-m-d",$monday)." +7 days") : $monday;
    // $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
    $data = [];
    foreach ($record as $row) {
      $data['days'][] = $row->day_name;
      $data['users'][] = (int) $row->users;
    }
    return $data['chart_month_data'] = json_encode($data);
  }
  public function get_days_whise()
  {
    $this->db->select("COUNT(user_id) as users,DAYNAME(start_time) as day_name");
    $this->db->from("{$this->table_scheduled_classes}");
    //$this->db->where('MONTH(created_on)', date('m'));
    $this->db->where('status', 'STARTED');
    $this->db->where('YEAR(start_time)', date('Y'));
    $this->db->where('MONTH(start_time)', date('m'));
    $this->db->where('DAY(start_time)', date('d'));
    $this->db->group_by("DAYNAME(start_time)");
    $record = $this->db->get()->result();
    $data = [];
    foreach ($record as $row) {
      $data['days'][] = $row->day_name;
      $data['users'][] = (int) $row->users;
    }
    return $data['chart_month_data'] = json_encode($data);
  }
  public function get_last_7_days_data()
  {
    $chart_data = [];
    for ($i = 6; $i >= 0; $i--) { // Fetch data for the last 7 days
      $date = date('Y-m-d', strtotime("-$i days"));
      //$daten = date('Y-m-d', strtotime("-$i dayname"));
      $data = $this->db->select('COUNT(user_id) as users,DAYNAME(start_time) as day_name')

        ->where('DATE(start_time)', $date)
        ->where('status', 'STARTED')
        ->get($this->table_scheduled_classes)
        ->row();
      $chart_data['days'][] = date('d-m-Y', strtotime($date));
      $chart_data['daysname'][] = date('D', strtotime($date));
      $chart_data['users'][] = ($data) ? (int)$data->users : 0;
    }
    return json_encode($chart_data);
  }
}

/* End of file batch_model.php */
/* Location: ./application/models/batch_model.php */