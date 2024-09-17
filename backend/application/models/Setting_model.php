<?php
class Setting_model extends CI_Model
{
	
	private $table = "email_templates";
	private $table_general_settings = "general_settings";
	private $table_template_variables = "email_template_variables";
	private $table_tasks_template = "tasks_template";
	// ------------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
	}

	
	public function insert($data)
	{
	 
	  $this->db->insert($this->table, $data);
	  return $this->db->insert_id();
	}
	public function insert_variables($data)
	{
	 
	  $this->db->insert($this->table_template_variables, $data);
	  return $this->db->insert_id();
	}
	public function update_general_setting($data){
		$this->db->where('id', 1);
		$this->db->update($this->table_general_settings, $data);
		return true;

	}

	//-----------------------------------------------------
	public function get_general_settings(){
		$this->db->where('id', 1);
        $query = $this->db->get($this->table_general_settings);
        return $query->row_array();
	}

	/*--------------------------
	   Email Template Settings
	--------------------------*/

	function get_email_templates()
	{
		return $this->db->get($this->table)->result_array();
	}

	function update_email_template($data,$id)
	{
		$this->db->where('id', $id);
		$this->db->update($this->table, $data);
		return true;
	}

	function get_email_template_content_by_id($id)
	{
		return $this->db->get_where($this->table,array('id' => $id))->row_array();
	}
	function get_email_template_content_by_slug($slug)
	{
		return $this->db->get_where($this->table,array('slug' => $slug))->row_array();
	}

	function get_email_verification()
	{
		return $this->db->get_where($this->table, array('slug' => 'email-verification'))->row_array();
	}

	function get_email_template_variables_by_id($id)
	{
		return $this->db->get_where($this->table_template_variables,array('template_id' => $id))->result_array();
	}
	/*--------------------------
	   Task Template Settings
	--------------------------*/
	public function task_insert($data)
	{
	 
	  $this->db->insert($this->table_tasks_template, $data);
	  return $this->db->insert_id();
	}
	function get_task_template_content_by_id($id)
	{
		return $this->db->get_where($this->table_tasks_template,array('id' => $id))->row_array();
	}
	function get_task_templates()
	{
		return $this->db->get($this->table_tasks_template)->result_array();
	}

	function update_task_template($data,$id)
	{
		$this->db->where('id', $id);
		$this->db->update($this->table_tasks_template, $data);
		return true;
	}

	
}
?>