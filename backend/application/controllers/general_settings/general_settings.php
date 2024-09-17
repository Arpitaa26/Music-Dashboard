<?php defined('BASEPATH') OR exit('No direct script access allowed');

class General_settings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('setting_model', 'setting_model');
		
	}

	
	/*--------------------------
	   Email Template Settings
	--------------------------*/
	public function index()
    {
        try {
			$data['title'] = 'Email Templates';
			$data['general_settings'] = $this->setting_model->get_general_settings();
			//pp($data);
            view("general_settings/setting", $data, "Portal | Class rescheduled request");
        } catch (\Throwable $th) {
            redirect(base_url('general_settings'), 'refresh');
        }
    }
    public function add()
    	{
    		$data = array(
    			'application_name' => $this->input->post('application_name'),
    			'email_from' => $this->input->post('email_from'),
    			'admin_email' => $this->input->post('admin_email'),
    			'smtp_host' => $this->input->post('smtp_host'),
    			'smtp_port' => $this->input->post('smtp_port'),
    			'smtp_user' => $this->input->post('smtp_user'),
    			'created_on' => date('Y-m-d : h:m:s'),
    			'updated_on' => date('Y-m-d : h:m:s')
    		);
    
    		$old_logo = $this->input->post('old_logo');
    		$old_favicon = $this->input->post('old_favicon');
    
    		$path="img/";
    
    		if(!empty($_FILES['logo']['name']))
    		{
    			$this->functions->delete_file($old_logo);
    
    			$result = $this->functions->file_insert($path, 'logo', 'image', '9097152');
    			if($result['status'] == 1){
    				$data['logo'] = $path.$result['msg'];
    			}
    			else{
    			
    				redirect(base_url('general_settings'), 'refresh');
    			}
    		}
    
    		// favicon
    		if(!empty($_FILES['favicon']['name']))
    		{
    			$this->functions->delete_file($old_favicon);
    
    			$result = $this->functions->file_insert($path, 'favicon', 'image', '197152');
    			if($result['status'] == 1){
    				$data['favicon'] = $path.$result['msg'];
    			}
    			else{
    			
    				redirect(base_url('general_settings'), 'refresh');
    			}
    		}
    
    		
    		$result = $this->setting_model->update_general_setting($data);
    
    		
    		
    		if($result){
    			
    			redirect(base_url('general_settings'), 'refresh');
    		}
    	}

	// ------------------------------------------------------------
	public function email_templates()
	{
		if($this->input->post()){
			$this->form_validation->set_rules('subject', 'Email Subject', 'trim|required');
			$this->form_validation->set_rules('content', 'Email Body', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}
			else{

				$id = $this->input->post('id');
				
				$data = array(
					'subject' => $this->input->post('subject'),
					'body' => $this->input->post('content'),
					//'created_on' => date('Y-m-d H:i:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->setting_model->update_email_template($data, $id);
				if($result){
					echo "true";
					//redirect(base_url('general_settings'), 'refresh');
				}
			}
		}
		else
		{
			$data['title'] = 'Email Templates';
			$data['templates'] = $this->setting_model->get_email_templates();
			view("general_settings/email_templates/templates_list", $data, "Portal | Email Templates");
			
		}
	}

	
	/*--------------------------
	ADD  Email Template Settings
	--------------------------*/
	

    public function save()
    {
        try {
            $this->http->auth(["post", "get"], ["ADMIN"]);
            $p =  $this->http->request->all();
			
            if (is_post()) {

              
                $this->form_validation->set_rules(
                    [
                        [
                            'field' => 'name',
                            'label' => 'Name',
                            'rules' => "trim|required|alpha_numeric_spaces",
                            
                        ],
                        [
                            'field' => 'subject',
                            'label' => 'Subject',
                            'rules' => "trim|required|alpha_numeric_spaces",
                          
                        ],
                        [
                            'field' => 'slug',
                            'label' => 'Slug',
                            'rules' => "trim|required|alpha_numeric_spaces",
                          
                        ],
                        [
                            'field' => 'email_body',
                            'label' => 'Status',
							'rules' => "trim|required|alpha_numeric_spaces",
                           
                        ]
                    ]
                );

                if ($this->form_validation->run() == TRUE) {

                   

                    $template_data = [
                        "name" => $p["name"],
                        "subject" => $p["subject"],
                        "slug" => $p["slug"],
                        "body" => $p["email_body"],
                    ];

                   
                        if ($template_id=$this->setting_model->insert($template_data)) {
							$variable_data = [
								"template_id" =>$template_id,
								"variable_name" => '{FULLNAME}',
								
							];
							$this->setting_model->insert_variables($variable_data);
                            set_message("success", "Email templates created successfully");
                        } else {
                            set_message("danger", "Email templates creation failed");
                        }
                    

                    redirect(base_url('email_templates'), 'refresh');
                } else {
					$form_errors = $this->form_validation->error_array();
					return $this->http->response->create(203, "Form validation error", $form_errors);
                }
            } 
        } catch (\Throwable $th) {
           redirect(base_url('email_templates'), 'refresh');
         
        }
    }


	// Get Email Template & Related variables via Ajax by ID
	public function get_email_template_content_by_id()
	{
		$id = $this->input->post('template_id');

		$data['template'] = $this->setting_model->get_email_template_content_by_id($id);
		
		$variables = $this->setting_model->get_email_template_variables_by_id($id);

		$data['variables'] = implode(',',array_column($variables, 'variable_name'));

		echo json_encode($data);
	}

	//---------------------------------------------------------------
    //
    public function email_preview()
    {
        if($this->input->post('content'))
        {
            $data['content'] = $this->input->post('content');
            $data['head'] = $this->input->post('head');
            $data['title'] = 'Send Email to Subscribers';
			echo view("general_settings/email_templates/email_preview", $data, "Portal | Email View");
			
        }
    }

	/*--------------------------
	ADD  task Template Settings
	--------------------------*/
	
	// Get Email Template & Related variables via Ajax by ID
	public function get_task_template_content_by_id()
	{
		$id = $this->input->post('template_id');
		$data['template'] = $this->setting_model->get_task_template_content_by_id($id);
		echo json_encode($data);
	}

public function task_preview()
    {
        if($this->input->post('content'))
        {
            $data['content'] = $this->input->post('content');
            $data['head'] = $this->input->post('head');
            $data['title'] = 'Task Template';
			echo view("general_settings/email_templates/task_preview", $data, "Portal | Email View");
        }
    }

	// ------------------------------------------------------------
	public function task_templates()
	{
		if($this->input->post()){
			$this->form_validation->set_rules('title', 'Task title', 'trim|required');
			$this->form_validation->set_rules('description', 'Task Body', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}
			else{

				$id = $this->input->post('id');
				
				$data = array(
					'title' => $this->input->post('title'),
					'description' => $this->input->post('description'),
					'category' => $this->input->post('category'),
					//'created_on' => date('Y-m-d H:i:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->setting_model->update_task_template($data, $id);
				if($result){
					echo "true";
				}
			}
		}
		else
		{
			$data['title'] = 'Task Templates';
			$data['templates'] = $this->setting_model->get_task_templates();
			view("general_settings/email_templates/task_list", $data, "Portal | task Templates");
			
		}
	}
	public function task_save()
    {
        try {
            $this->http->auth(["post", "get"], ["ADMIN"]);
            $p =  $this->http->request->all();
			
            if (is_post()) {

              
                $this->form_validation->set_rules(
                    [
                        [
                            'field' => 'title',
                            'label' => 'Title',
                            'rules' => "trim|required|alpha_numeric_spaces",
                            
                        ],
                       
                        [
                            'field' => 'category',
                            'label' => 'Category',
                            'rules' => "trim|required|alpha_numeric_spaces",
                          
                        ],
                        [
                            'field' => 'description',
                            'label' => 'Description',
							'rules' => "trim|required|alpha_numeric_spaces",
                           
                        ]
                    ]
                );

                if ($this->form_validation->run() == TRUE) {
                    $template_data = [
                        "title" => $p["title"],
                        "category" => $p["category"],
                        "description" => $p["description"],
                    ];
                        if ($this->setting_model->task_insert($template_data)) {
							
                            set_message("success", "Task created successfully");
                        } else {
                            set_message("danger", "Task creation failed");
                        }
                    redirect(base_url('task_templates'), 'refresh');
                } else {
					$form_errors = $this->form_validation->error_array();
					return $this->http->response->create(203, "Form validation error", $form_errors);
                }
            } 
        } catch (\Throwable $th) {
           redirect(base_url('task_templates'), 'refresh');
         
        }
    }



}
