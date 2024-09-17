<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Task extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(["task_model", "user_model"]);
    }
    private function save_view($id = null)
    {
        $tasks = $this->task_model->get_all(1, null,$id);
        $task_comments = $this->task_model->get_all_comments($id);
        $users = $this->user_model->get_all("ACTIVE");
        if ($task = $this->task_model->get($id)) {
        $task_comments = $this->task_model->get_all_comments($id);
//pp($task_comments);
            view("task/create", compact("task", "users","task_comments"), "Portal |Task Edit");
        } else {
            view("task/create", compact("users"), "Portal |Task Create");
        }
    }

    public function index()
    {
        try {
            $u = $this->http->auth(["get"], ["ADMIN", "SUPPORT", "STUDENT"]);
            $role = $u->type;
            $user_id = is_numeric($this->input->get("user_id")) ? $this->input->get("user_id") : "";
            $tasks = $this->task_model->get_all(null, $user_id);
            $users = $this->user_model->get_all(null, null, $user_id);
            $task_type = ($this->input->get("task_type")) ? $this->input->get("task_type") : "";
            view("task/index", compact("tasks", "users", "user_id", "task_type", "role"), "Portal | Task");
        } catch (\Throwable $th) {
            //throw $th;
            redirect(base_url('task'), 'refresh');
        }
    }
    public function create()
    {
        try {
            if (is_post()) {
                $p = $this->http->request->all();

                $this->form_validation->set_rules(
                    [
                        [
                            'field' => 'task_title',
                            'label' => 'Task',
                            'rules' => 'trim|required|is_unique_custom[tasks.task_title]',
                            'errors' => array(
                                'is_exist' => '%s not exist',
                            ),
                        ],

                        [
                            'field' => 'user_id',
                            'label' => 'Users',
                            'rules' => 'trim|required'
                        ],
                        [
                            'field' => 'task_date',
                            'label' => 'Task Date',
                            'rules' => 'trim|required'
                        ],
                        [
                            'field' => 'task_type',
                            'label' => 'Task Date',
                            'rules' => 'trim|required'
                        ],
                        [
                            'field' => 'status',
                            'label' => 'Status',
                            'rules' => 'required|in_list[0,1,2]',
                            'errors' => array(
                                'in_list' => '%s select one of Completed/Incomplete/InActive',
                            ),
                        ],
                        [
                            'field' => 'description',
                            'label' => 'Description',
                            'rules' => 'trim|required'
                        ]

                    ]
                );

                if ($this->form_validation->run() == true) {

                    $task_type = $p["task_type"] ? $p["task_type"] : 'SUPPORT';
                    $user_id = $p["user_id"] ? $p["user_id"] : null;
                    $d = [
                        "task_title" => $p["task_title"],
                        "user_id" => $user_id,
                        "task_type" => $task_type,
                        "task_date" => $p["task_date"],
                        "description" => $p["description"],
                        "status" => $p["status"],
                    ];

                    if ($this->task_model->insert($d)) {
                        set_message("success", "Task created successfully");
                    }
                    redirect(base_url('create'), 'refresh');
                }
            }
            $user_id = is_numeric($this->input->get("user_id")) ? $this->input->get("user_id") : "";
            $tasks = $this->task_model->get_all(null, $user_id);
            $users = $this->user_model->get_all(null, null, $user_id);
            
            $this->load->view("task", compact("tasks", "users", "user_id"), "Portal | Task");
        } catch (\Throwable $th) {
            //throw $th;
            redirect(base_url('create'), 'refresh');
        }
    }

    public function save($id = null)
    {
        try {

            $u = $this->http->auth(["get", "post"], ["ADMIN", "SUPPORT", "STUDENT"]);

            if (is_post()) {
                $p = $this->http->request->all();

                $this->form_validation->set_rules(
                    [
                        [
                            'field' => 'task_title',
                            'label' => 'Task',
                            'rules' => 'required',
                            'errors' => array(
                                'is_exist' => '%s not exist',
                            ),
                        ],
                        [
                            'field' => 'task_date',
                            'label' => 'task_date',
                            'rules' => 'trim|required'
                        ],

                        [
                            'field' => 'status',
                            'label' => 'Status',
                            'rules' => 'required|in_list[0,1,2]',
                            'errors' => array(
                                'in_list' => '%s select one of Completed/Incomplete/InActive',
                            ),
                        ],
                        [
                            'field' => 'description',
                            'label' => 'Description',
                            'rules' => 'trim|required'
                        ]

                    ]
                );

                if ($this->form_validation->run() == true) {
                    $task_type = isset($p["task_type"]) ? $p["task_type"] : 'SUPPORT';
                    $user_id = isset($p["user_id"]) ? $p["user_id"] : $u->id;
                    $data = [
                        "task_title" => $p["task_title"],
                        "user_id" =>  $user_id,
                        "task_type" => $task_type,
                        "task_date" => $p["task_date"],
                        "description" => $p["description"],
                        "status" => $p["status"],
                        "created_by" => $user_id,
                    ];

                    if (!is_null($id)) {
                     
                       // $data = $data[0];
                        if ($this->task_model->update($id, $data )) {
                            set_message("success", "Task updated successfully");
                        } else {
                            set_message("danger", "Task no changes found/failed");
                        }
                    } else {
                      //  pp($id);
                        if ($this->task_model->insert($data)) {
                            set_message("success", "Task created successfully");
                        } else {
                            set_message("danger", "Task creation failed");
                        }
                    }
                    redirect(base_url('task'), 'refresh');
                } else {
                    $this->save_view($id);
                }
            } else {
                $this->save_view($id);
            }
        } catch (\Throwable $th) {
            redirect(base_url('task'), 'refresh');
        }
    }
    public function task_comments($id = null)
    {
        try {

            $this->http->auth(["get", "post"], ["ADMIN", "SUPPORT", "STUDENT","TEACHER"]);

            if (is_post()) {
                $p = $this->http->request->all();
               
                $this->form_validation->set_rules(
                    [
                        [
                            'field' => 'task_comment',
                            'label' => 'Task',
                            'rules' => 'required',
                            'errors' => array(
                                'is_exist' => '%s not exist',
                            ),
                        ]
                       

                    ]
                );

                if ($this->form_validation->run() == true) {
                    $id=$p["task_id"];
                    // $task_comments = $this->task_model->get_all_comments($id);
                    // //count($task_comments)
                    // if (empty($task_comments)) {
                    //     $status='2';
                    // }else{
                    //     $status='3';
                    // }
                    //    $data['status']=$status;
                        $d = [
                            "task_comment" => $p["task_comment"],
                            "user_id" => $p["user_id"],
                            "task_id" => $p["task_id"],
                            "status" => ""
                        ];
                       
                    if ( $this->task_model->insert_comment($d)) {
                        //$this->task_model->update($id, $data );
                        set_message("success", "Comment created successfully");
                    } else {
                        set_message("danger", "Comment creation failed");
                    }
                   
                    redirect(base_url('task'), 'refresh');
                   // $this->save_view($id);
                } else {
                    $this->save_view($id);
                }
            } else {
                $this->save_view($id);
            }
        } catch (\Throwable $th) {
            redirect(base_url('task'), 'refresh');
        }
    }

    public function get($id = null)
    {
        try {
            $this->http->auth(["get"], ["ADMIN", "SUPPORT" ,"TEACHER","STUDENT"]);
            if ($d = $this->task_model->get($id)) {
                return $this->http->response->create(200, "Task fetched successfully", $d);
            } else {
                return $this->http->response->create(203, "Task  not found");
            }
        } catch (\Throwable $th) {
            return $this->http->response->serverError();
        }
    }

    public function get_all()
    {
        try {
            $u = $this->http->auth("get", ["ADMIN", "SUPPORT", "STUDENT", "TEACHER"]);
            if ($u->type == "SUPPORT" || $u->type == "ADMIN") {
                if ($this->input->get("self") == "true") {
                    $task_id = ($this->input->get("task_id")) ? $this->input->get("task_id") : "";
                    $user_id =NULL;
                    $task_type = ($this->input->get("task_type")) ? $this->input->get("task_type") : "";
                    $status = ($this->input->get("status")) ? $this->input->get("status") : "";
                } else {
                    $task_id = ($this->input->get("task_id")) ? $this->input->get("task_id") : "";
                    $user_id = ($this->input->get("user_id")) ? $this->input->get("user_id") : "";
                    $task_type = ($this->input->get("task_type")) ? $this->input->get("task_type") : "";
                    $status = ($this->input->get("status")) ? $this->input->get("status") : "";
                }
            } else {
                
                $user_id =$u->id;
                $task_id = ($this->input->get("task_id")) ? $this->input->get("task_id") : "";
                $task_type = ($this->input->get("task_type")) ? $this->input->get("task_type") : "";
                $status = ($this->input->get("status")) ? $this->input->get("status") : "";
            }
           
            if ($data = $this->task_model->get_all(null,$user_id, $task_id, null, null, $task_type)) {
                return $this->http->response->create(200, "Task fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Task not found");
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->http->response->serverError();
        }
    }

    public function get_all_comments($task_id=null)
    {
        try {
             $this->http->auth("get", ["ADMIN", "SUPPORT", "STUDENT", "TEACHER"]);
         
            $task_id = ($this->input->get("task_id")) ? $this->input->get("task_id") : "";
          // pp($task_id);
            if ($data = $this->task_model->get_all_comments($task_id)) {
                return $this->http->response->create(200, "Task Comments fetched successfully", $data);
            } else {
                return $this->http->response->create(203, "Task Comments not found");
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->http->response->serverError();
        }
    }
    public function status()
    {
        try {
            $this->http->auth(["get"], ["ADMIN", "SUPPORT"]);
            $status = ($this->input->get("status")) ? $this->input->get("status") : "";
            $id = ($this->input->get("id")) ? $this->input->get("id") : "";
            if ($id) {
                
                if($status=='1'){$data['status']=0;}else{$data['status']=1;}
                //pp($data.$id);
                $this->task_model->update($id,$data);
                set_message("success", "Task status successfully");
            } else {
                set_message("danger", "Task status failed");
            }
            redirect(base_url('task'), 'refresh');
        } catch (\Throwable $th) {
            redirect(base_url('task'), 'refresh');
        }
    }
    public function delete($id)
    {
        try {
            $this->http->auth(["get"], ["ADMIN", "SUPPORT"]);
            if ($this->task_model->delete($id)) {
                set_message("success", "Task deleted successfully");
            } else {
                set_message("danger", "Task delete failed");
            }
            redirect(base_url('task'), 'refresh');
        } catch (\Throwable $th) {
            redirect(base_url('task'), 'refresh');
        }
    }
}
