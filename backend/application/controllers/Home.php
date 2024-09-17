<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(["home_model", "task_model","user_attendance_model"]);
	}

	public function index()
	{
		try {
			$today = date("Y-m-d");
			$u = $this->http->auth("get", ["ADMIN", "SUPPORT"]);
			
			$students = $this->home_model->get_count("STUDENT");
			$teachers = $this->home_model->get_count("TEACHER");
			$active_students = $this->home_model->get_active("STUDENT");
			$active_teachers = $this->home_model->get_active("TEACHER");
			$year_list = $this->home_model->fetch_year();
			$incomplete = $this->home_model->get_task_count(0, $today,null);
			$complete = $this->home_model->get_task_count(1, $today,null);
			$tasks = $this->task_model->get_all(0, null, null, $today, null);
			$month_whise= $this->user_attendance_model->get_month_barchart();
			$fetch_chart_month= $this->home_model->fetch_chart_month();
			$day_whise= $this->user_attendance_model->get_day_barchart();
		    $fetch_chart_week= $this->home_model->fetch_chart_week();
			$fetch_chart_day= $this->home_model->fetch_chart_day();
			$get_months_whise= $this->home_model->get_months_whise();
			$get_weeks_whise= $this->home_model->get_weeks_whise();
			$get_days_whise= $this->home_model->get_days_whise();
			$get_years_whise= $this->home_model->get_years_whise();
			$get_last_7_days_data= $this->home_model->get_last_7_days_data();
			$resolved_ticket=$this->home_model->get_support_ticket(0);
			$raised_ticket=$this->home_model->get_support_ticket(null);
			$pending_ticket=$this->home_model->get_support_ticket(1);
			//pp($raised_ticket.'/'.$pending_ticket.'/'.$resolved_ticket);
			//$fetch_chart_year= $this->home_model->fetch_chart_year();
			 view("home", compact("raised_ticket","pending_ticket","resolved_ticket","get_last_7_days_data","get_years_whise","get_months_whise","get_weeks_whise","get_days_whise","month_whise","fetch_chart_month","day_whise","students", "teachers", "active_students", "tasks", "active_teachers", "year_list", "incomplete", "complete"), "");
		} catch (\Throwable $th) {
			return $this->http->response->serverError();
		}
	}
	function fetch_data()
	{
		try {
			if ($this->input->post('year')) {
				$chart_data = $this->home_model->fetch_chart_data($this->input->post('year'));
				$output = [];
				foreach ($chart_data as $key => $row) {
					$output[] = array(
						'classes'  => $row->class_id,
						'batches' => $row->batch_id
					);
				}

				echo json_encode($output);
			}
		} catch (\Throwable $th) {
			return $this->http->response->serverError();
		}
	}
}
