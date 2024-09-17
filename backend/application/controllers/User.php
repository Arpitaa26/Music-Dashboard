<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Controller User
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller REST
 * @author    Monirul Middya
 * @return    ...
 *
 */

class User extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(["user_model", "file_model", "setting_model", "user_type_model", "user_pronoun_model"]);
  }


  /**
   * Action: view
   * 
   * @param array $requestData
   */
  private function save_view($id = null)
  {
    $user_types = $this->user_type_model->get_all(1);
    $user_pronouns = $this->user_pronoun_model->get_all(1);
    $user = $this->user_model->get($id);
    if ($id) {
      view("user/create", compact("user_types", "user_pronouns", "user"), "Portal | User Edit");
    } else {
      view("user/create", compact("user_types", "user_pronouns", "user"), "Portal | User Create");
    }
  }

  public function index()
  {
    try {
      $user_type_id = is_numeric($this->input->get("user_type_id")) ? $this->input->get("user_type_id") : "";
      $user_types = $this->user_type_model->get_all(1);
      $this->http->auth(["get"], "ADMIN");
      view("user/index", compact("user_types", "user_type_id"), "Portal | User");
    } catch (\Throwable $th) {
      redirect(base_url('user'), 'refresh');
    }
  }

  //=============================================================
  // Eamil Templates
  function mail_template($to = '', $slug = '', $mail_data = '')
  {

    $template =  $this->setting_model->get_email_template_content_by_slug($slug);

    $body = $template['body'];

    $template_id = $template['id'];

    $data['head'] = $subject = $template['subject'];

    $data['content'] = $this->mail_template_variables($body, $slug, $mail_data);

    $data['title'] = $template['name'];
    $template = $this->load->view("general_settings/email_templates/email_preview", $data, true);

    $this->send_mail($to, $subject, $template, null, null);
    //$this->sendEmail($to, $subject, $template,null,null);
    $this->send_mail($to, $subject, $template);

    return true;
  }

  //=============================================================
  // GET Eamil Templates AND REPLACE VARIABLES
  function mail_template_variables($content, $slug, $data = '')
  {

    switch ($slug) {
      case 'login-alert':
        $content = str_replace('{FULLNAME}',  $data['fullname'], $content);
        $content = str_replace('{TIMESTAMP}', date('F j, Y H:i:s'), $content);
        return $content;
        break;

      case 'email-verification':
        $content = str_replace('{TIMESTAMP}', date('F j, Y H:i:s'), $content);
        $content = str_replace('{VERIFICATION_LINK}', $data['fullname'], 'LINK HERE');
        return $content;
        break;

      case 'welcome':
        $content = str_replace('{FULLNAME}', $data['fullname'], $content);
        return $content;
        break;

      case 'forget-password':
        $content = str_replace('{FULLNAME}', $data['fullname'], $content);
        $content = str_replace('{RESET_LINK}', $data['reset_link'], $content);
        return $content;
        break;

      case 'applicant-applied':
        $content = str_replace('{TASK_TITLE}', $data['task_title'], $content);
        return $content;
        break;

      case 'Exam':
        $content = str_replace('{TASK_TITLE}', $data['task_title'], $content);
        return $content;
        break;

      case 'general-notification':
        $content = str_replace('{CONTENT}', $data['content'], $content);
        return $content;
        break;

      case 'candidate-rigister':
        $content = str_replace('{TASK_TITLE}', $data['task_title'], $content);
        return $content;
        break;

      default:
        # code...
        break;
    }
  }

  //=============================================================
  // VERIFICATION EMAIL
  // type - TEACHER / STUDENT , ID - USER ID 
  function send_verification_email($id, $type = '')
  {

    $u = $this->http->auth(["post", "get"], ["ADMIN", "STUDENT", "TEACHER", "SUPPORT"]);
    if ($u->$type == 'STUDENT' || $u->$type == '') {
      $user = $this->CI->db->get_where('tbl_users', array('id' => $id))->row_array();
    }

    $token = $user['token'];

    if ($type == 'TEACHER')
      $varification_link = base_url('verify/' . $token);

    if ($type == 'STUDENT' || $type == '')
      $varification_link = base_url('verify/' . $token);


    // Get Email Template
    $temp =  $this->setting_model->get_email_verification();

    $to = $user['email'];

    $data['content'] = str_replace('{VERIFICATION_LINK}', $varification_link, $temp['body']);

    $data['head'] = $temp['subject'];

    $data['title'] = $temp['name'];

    $template =  view("general_settings/email_templates/email_preview", $data, "Portal | Email View");

    $this->send_mail($to, $temp['subject'], $template);

    return true;
  }

  public function send_mail($to = null, $subject  = null, $body = null, $attachment = null, $cc = null)
  {
    try {
      //  $u = $this->http->auth(["post", "get"], ["ADMIN", "STUDENT", "TEACHER", "SUPPORT"]);
      $user = $this->setting_model->get_by_email($to);

      $id = $user->id;

      $p = $this->http->request->all();
      if ($user->email == $p['email']) {
        $from_email = "bapanroy280@gmail.com";
        $to_email = $p['email'];

        $otp = rand(1000, 9999);

        $tdata = [
          'otp' => $otp,
        ];

        if (!is_null($id)) {
          $user = $this->user_model->get($id);
          // PP($user);
          $this->user_model->update($id, $tdata);
          //$this->mail_template($user_email,'forget-password',$mail_data);

          //Load email library
          $this->load->library('email');
          $this->email->from($from_email, 'svp'); //general_settings
          $this->email->to($to_email); //$to 
          $this->email->subject('Send Email'); //$subject
          $message = "<p>This email has been sent as a request to reset our password</p>";
          $message .= "Please click on the password reset link 
                        <br><a href='" . base_url('user/forgot_password?token=') . $otp . "'>Reset 
                        Password</a>";

          $this->email->message($message); //$body
          if ($cc != '') {
            $this->email->cc($cc);
          }

          if ($attachment != '') {
            $this->email->attach(base_url() . "your_file_path" . $attachment);
          }
          //Send mail
          if ($this->email->send()) {
            return $this->http->response->create(200, "Congragulation Email Send Successfully.");
          } else {
            return $this->http->response->create(203, "You have encountered an error.");
          }
        }
      }
      // $this->load->view('contact_email_form');
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }
  /**
   * user register method for internal user
   * @param array $d user data
   * @param int $id default null for update user data
   * @return bool
   */
  private function register($d, $id = null)
  {

    $ip = $_SERVER['REMOTE_ADDR'];
    $data = [
      "user_type_id" => $d["user_type_id"],
      "user_pronoun_id" => $d["user_pronoun_id"],
      "first_name" => $d["first_name"],
      "last_name" => $d["last_name"],
      "username" => $d["username"],
      "email" => $d["email"],
      "phone_no" => $d["phone_no"],
      "profile_file" => $d["profile_file"],
      "dob" => date("Y-m-d", strtotime($d["dob"])),
      "ip" => $ip,
      "status" => $d["status"]

    ];

    if (isset($d["middle_name"])) {
      $data["middle_name"] = $d["middle_name"];
    }
    if (isset($d["city"])) {
      $data["city"] = $d["city"];
    }
    if (isset($d["city"])) {
      $data["city"] = $d["city"];
    }
    if (isset($d["state"])) {
      $data["state"] = $d["state"];
    }
    if (isset($d["country"])) {
      $data["country"] = $d["country"];
    }
    if (isset($d["postal_code"])) {
      $data["postal_code"] = $d["postal_code"];
    }
    if (isset($d["address"])) {
      $data["address"] = $d["address"];
    }
    if (isset($d["password"])) {
      $data["password"] = password_hash($d["password"], PASSWORD_BCRYPT);
    }

    if (!is_null($id)) {
      return $this->user_model->update($id, $data);
    } else {
      return $this->user_model->insert($data);
    }
  }
  public function account_details($id = null)
  {

    try {
      $u = $this->http->auth(["post", "get"], ["ADMIN", "STUDENT", "TEACHER", "SUPPORT"]);

      $p = $this->http->request->all();

      $category = $this->http->request->get("category");
      $description = $this->http->request->get("description");
      $this->form_validation->set_rules(
        [
          [
            'field' => 'category',
            'label' => 'Category',
            'rules' => 'trim|required|in_list[PROFILE_PIC,RESUME]',
            'errors' => array(
              'in_list' => '%s select one of PROFILE_PIC/RESUME',
            )
          ]
        ]
      );

      if ($this->form_validation->run() == true) {

        // $exploded = explode('.', $_FILES['file_name']['name']);
        // $file_ext = strtolower(end($exploded));


        // $file_name = md5(uniqid(rand(), true));
        // $filename = $file_name . '.' . $file_ext;


        $upload_path =  DOCUMENT_FOLDER . "/{$category}/";
        if (!file_exists(FCPATH . $upload_path)) {
          mkdir(FCPATH . $upload_path, 0777, true);
        }

        $config = [
          'upload_path' => FCPATH . $upload_path,
          'encrypt_name' => true,
          //"file_name" => $filename,
        ];


        switch ($category) {
          case 'PROFILE_PIC':
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = '5000';
            break;
          case 'RESUME':
            $config['allowed_types'] = 'jpg|jpeg|png|gif|txt|pdf';
            $config['max_size'] = '5000';
            break;

          default:
            return $this->http->response->create(203, "Can't upload file now for given category");
            break;
        }

        $this->load->library('upload', $config);
        $d = array();
        foreach ($_FILES as $field_name => $file_info) {

          if ($this->upload->do_upload($field_name)) {
            // if (file_exists(FCPATH . $upload_path . $filename)) {
            //   unlink(FCPATH . $upload_path . $filename);
            // }

            $d = $this->upload->data();

            $file_data = [
              "file_name" => $d["file_name"],
              "category" => $category,
              "description" => $description,
              "mime_type" => $d["file_type"],
              // "file_ext"=>$d["file_ext"],
              "original_name" => $d["orig_name"],
              "path" => $upload_path . $d["file_name"],
              "status" => '1'
            ];

            $fid = $this->file_model->insert($file_data);
            $link = $this->file_model->slug;
            $file_ext = $d["file_ext"];
          } else {

            $error = array('error' => $this->upload->display_errors());
            //pp($error);
            $fid = null;
            $link = null;
            $file_ext = null;
          }
        }
        //pp($d);
        $data = [
          "date_of_joining" => $p["date_of_joining"],
          "achivements" => $p["achivements"],
          "concerts" => $p["concerts"],
          "date_of_training_period" => $p["date_of_training_period"],
          "date_of_contract_Academy" => $p["date_of_contract_Academy"],
          "date_of_contract_teacher" => $p["date_of_contract_teacher"],
          "link" => $link,
          "file_ext" => $file_ext,
          "file_id" => $fid
        ];

        //  $this->mail_template($u->email, 'forget-password', $data);
        $json = json_encode($data);

        $fielddata = array('other_details' => $json);
        if (!is_null($id)) {
          $this->user_model->update($id, $fielddata);
          // set_message("success", "User created successfully");
          // redirect(base_url('user/save/'.$id), 'refresh');
          $this->http->response->create(200, "User Details update successfully");
        }
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }
  public function performance($id = null)
  {

    try {
      $u = $this->http->auth(["post", "get"], ["ADMIN", "STUDENT", "TEACHER", "SUPPORT"]);

      $p = $this->http->request->all();
      // COOKIE AND CUTNIP
      $data = [
        "renewals_concerns_cookie" => $p["renewals_concerns_cookie"],
        "renewals_concerns_cutnip" => $p["renewals_concerns_cutnip"],
        "virtual_background_consistencies_cookie" => $p["virtual_background_consistencies_cookie"],
        "virtual_background_consistencies_cutnip" => $p["virtual_background_consistencies_cutnip"],
        "attendance_reschedule_cookie" => $p["attendance_reschedule_cookie"],
        "attendance_reschedule_cutnip" => $p["attendance_reschedule_cutnip"],
        "disciplinary_compliances_cookie" => $p["disciplinary_compliances_cookie"],
        "disciplinary_compliances_cutnip" => $p["disciplinary_compliances_cutnip"],
        "punctuality_cutnip" => $p["punctuality_cutnip"],
        "punctuality_cookie" => $p["punctuality_cookie"],

      ];

      //  $this->mail_template($u->email, 'forget-password', $data);
      $json = json_encode($data);

      $fielddata = array('performance' => $json);
      if (!is_null($id)) {
        $this->user_model->update($id, $fielddata);

        //$this->http->response->create(200, "User performance update successfully", $data);
      }
      set_message("success", "User created successfully");
      redirect(base_url('user/save/' . $id), 'refresh');
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }

  public function api_register()
  {
    try {
      $p = $this->http->request->all();
      $this->form_validation->set_rules(
        [
          [
            'field' => 'first_name',
            'label' => 'First Name',
            'rules' => 'trim|required',
          ],
          [
            'field' => 'last_name',
            'label' => 'Last Name',
            'rules' => 'trim|required',
          ],
          [
            'field' => 'user_type_id',
            'label' => 'User type',
            'rules' => 'trim|required|is_exist_where_in[user_types.id.type.STUDENT.TEACHER]',
            'errors' => array(
              'is_exist_where_in' => '%s not exist',
            ),
          ],
          [
            'field' => 'user_pronoun_id',
            'label' => 'User pronoun',
            'rules' => 'trim|required|is_exist[user_pronouns.id]',
            'errors' => array(
              'is_exist' => '%s not exist',
            ),
          ],
          [
            'field' => 'username',
            'label' => 'Username',
            'rules' => "trim|required|is_unique[users.username]|regex_match[/^[A-Za-z0-9()\/_]+$/]",
            'errors' => array(
              'is_unique' => '%s already taken',
            ),
          ],
          [
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email|is_unique[users.email]',
            'errors' => array(
              'is_unique' => '%s already taken',
            ),
          ],
          [
            'field' => 'phone_no',
            'label' => 'Phone No',
            'rules' => 'trim|required|is_unique[users.email]',
            'errors' => array(
              'is_unique' => '%s already taken',
            ),
          ],
          [
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required',
          ],

        ]
      );

      if ($this->form_validation->run() == TRUE) {
        $p["status"] = "inactive";
        $upload_path = DOCUMENT_FOLDER . '/profile_file/';
        if (!empty($_FILES['profile_file']['name'])) {
          $result = $this->functions->file_insert($upload_path, 'profile_file', 'image', '9097152'); //type,size
          $p['profile_file'] = FCPATH . $upload_path . $result['msg'];
        } else {

          $p['profile_file'] = 'ff';
        }

        if ($this->register($p)) {
          //Email sent to user/Student
          $data = [
            "fullname" => $p['first_name'] . ' ' . $p['last_name'],
          ];
          $this->mailer->mail_template($p['email'], 'welcome', $data);
          //Email sent to user/Student
          return $this->http->response->create(200, "User Registered successfully");
        } else {
          return $this->http->response->create(203, "User Registration failed");
        }
      } else {
        $form_errors = $this->form_validation->error_array();
        return $this->http->response->create(203, "Form validation error", $form_errors);
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }

  public function web_register($id = null)
  {
    try {
      $u = $this->http->auth(["get", "post"], ["ADMIN", "SUPPORT"]);
      if (is_post()) {
        $p = $this->http->request->all();
        $upload_path = DOCUMENT_FOLDER . '/profile_file/';

        if (!empty($_FILES['profile_file']['name'])) {
          $result = $this->functions->file_insert($upload_path, 'profile_file', 'image', '9097152'); //type,size
          $p['profile_file'] = FCPATH . $upload_path . $result['msg'];
        } else {

          $p['profile_file'] = '';
        }
        $ut_rext = ".SUPPORT";
        if ($u->type == "ADMIN") {
          $ut_rext .= ".ADMIN";
        }

        $update_flag = false;
        $pwd_rule = "";
        $cpwd_rule = "";
        if (!empty($id)) {
          if ($this->user_model->get($id)) {
            $update_flag = true;
          } else {
            set_message("danger", "Given user not exist");
            redirect(base_url('user'), 'refresh');
          }
          $uname_rule = "|is_unique_custom[users.username.{$id}.id]";
          $email_rule = "|is_unique_custom[users.email.{$id}.id]";
          $phone_no_rule = "|is_unique_custom[users.phone_no.{$id}.id]";
          if (isset($p["password"]) && !empty($p["password"])) {
            $pwd_rule = "|required";
            $cpwd_rule = "|required|matches[password]";
          }
        } else {
          $pwd_rule = "|required";
          $cpwd_rule = "|required|matches[password]";
          $uname_rule = "|is_unique[users.username]";
          $email_rule = "|is_unique[users.email]";
          $phone_no_rule = "|is_unique[users.phone_no]";
        }

        $this->form_validation->set_rules(
          [
            [
              'field' => 'first_name',
              'label' => 'First Name',
              'rules' => 'trim|required',
            ],
            [
              'field' => 'last_name',
              'label' => 'Last Name',
              'rules' => 'trim|required',
            ],
            [
              'field' => 'user_type_id',
              'label' => 'User type',
              'rules' => "trim|required|is_exist_where_in[user_types.id.type.STUDENT.TEACHER{$ut_rext}]",
              'errors' => array(
                'is_exist_where_in' => '%s not exist',
              ),
            ],
            [
              'field' => 'user_pronoun_id',
              'label' => 'User pronoun',
              'rules' => 'trim|required|is_exist[user_pronouns.id]',
              'errors' => array(
                'is_exist' => '%s not exist',
              ),
            ],
            [
              'field' => 'username',
              'label' => 'Username',
              'rules' => "trim|required|regex_match[/^[A-Za-z0-9()\/_]+$/]{$uname_rule}",
              'errors' => array(
                'is_unique' => '%s already taken',
                'is_unique_custom' => '%s already taken',
              ),
            ],
            [
              'field' => 'email',
              'label' => 'Email',
              'rules' => "trim|required|valid_email{$email_rule}",
              'errors' => array(
                'is_unique' => '%s already taken',
                'is_unique_custom' => '%s already taken',
              ),
            ],
            [
              'field' => 'phone_no',
              'label' => 'Phone No',
              'rules' => "trim|required{$phone_no_rule}",
              'errors' => array(
                'is_unique' => '%s already taken',
                'is_unique_custom' => '%s already taken',
              ),
            ],

            [
              'field' => 'status',
              'label' => 'Status',
              'rules' => 'trim|required|in_list[pending,active,inactive,blocked,banned]',
              'errors' => array(
                'in_list' => '%s select one of Pending/Active/inactive/Blocked/Banned',
              ),
            ],
            [
              'field' => 'password',
              'label' => 'Password',
              'rules' => "trim{$pwd_rule}",
            ],
            [
              'field' => 'cpassword',
              'label' => 'Confirm Password',
              'rules' => "trim{$cpwd_rule}",
            ]
          ]
        );

        if ($this->form_validation->run() == TRUE) {

          if ($this->register($p, $id)) {
            if ($update_flag) {
              set_message("success", "User update successfully");
            } else {
              //Email sent to user/Student
              $data = [
                "fullname" => $p['first_name'] . ' ' . $p['last_name'],
              ];
              $this->mailer->mail_template($p['email'], 'welcome', $data);
              //Email sent to user/Student
              set_message("success", "User created successfully");
            }
          } else {
            if ($update_flag) {
              set_message("danger", "User no changes found/failed");
            } else {
              set_message("danger", "User creation failed");
            }
          }
          // redirect(base_url('user'), 'refresh');
        } else {
          $this->save_view($id);
        }
      } else {
        $this->save_view($id);
      }
    } catch (\Throwable $th) {
      // redirect(base_url('user'), 'refresh');
    }
  }


  private function login_mtc($username, $password)
  {
    if ($user = $this->user_model->get_by_username($username)) {

      $ip = $_SERVER['REMOTE_ADDR'];
      if (password_verify($password, $user->password) === true) {
        $status = isset($user->status) ? $user->status : "";
        if ($status == 'active') {
          $this->user_model->update($user->id, [
            "last_login" => date("Y-m-d H:i:s"),
            "ip" => $ip,
          ]);

          return [
            'id' => $user->id,
            'ip' => $ip,
            'user_type_id' => $user->user_type_id,
            'user_pronoun_id' => $user->user_pronoun_id,
            'username' => $user->username,
            'email' => $user->email,
            'phone_no' => $user->phone_no,
            'pronoun' => $user->pronoun,
            'first_name' => $user->first_name,
            'full_name' => $user->full_name,
            'type' => $user->type,
            'referal_code' => $user->referal_code,
            'no_of_referals' => $user->no_of_referals,
            'status' => $user->status,
          ];
        } else {
          //set_message("danger", "You are not Active");
          return $this->http->response->create(203, "You are not Active", $status);
        }
      } else {
        return "Username or password are not matched";
      }
    } else {
      return "Username or password are not matched";
    }
  }

  public function api_login()
  {
    try {
      $data =  $this->http->request->all();


      $this->form_validation->set_rules([
        [
          'field' => 'username',
          'label' => 'Username',
          'rules' => 'trim|required',
        ],
        [
          'field' => 'password',
          'label' => 'Password',
          'rules' => 'trim|required',
        ],
      ]);

      if ($this->form_validation->run() == TRUE) {
        $lresp = $this->login_mtc($data["username"], $data["password"]);
        $user = $this->user_model->get_by_username($data["username"]);
        $status = isset($user->status) ? $user->status : "";
        if (is_array($lresp)) {
          if ($status == 'active') {
            $token = $this->http->jwt_encode($lresp);
            $this->http->response->create(200, "User has been loggedIn successfully", ['api-key' => $token]);
          } else {
            return $this->http->response->create(203, "You are not Active");
          }
        } else {
          return $this->http->response->create(401, $lresp);
        }
      } else {
        $form_errors = $this->form_validation->error_array();
        return $this->http->response->create(203, "Form validation error", $form_errors);
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError($th->getMessage());
    }
  }

  public function session_login()
  {
    try {
      if (is_post()) {
        $this->form_validation->set_rules(
          [
            [
              'field' => 'username',
              'label' => 'Username',
              'rules' => "trim|required",
            ],
            [
              'field' => 'password',
              'label' => 'Password',
              'rules' => "trim|required",
            ]
          ]
        );

        if ($this->form_validation->run()) {

          $data =  $this->http->request->all();
          $user = $this->user_model->get_by_username($data["username"]);
          $lresp = $this->login_mtc($data["username"], $data["password"]);
          if (isset($user->status) == 'active') {
            if (is_array($lresp)) {
              $this->session->set_userdata('logged_in', (object)$lresp);
              $last_url = base_url();
              redirect($last_url, 'refresh');
            } else {
              set_message("danger", $lresp);
              redirect(base_url('login'), 'refresh');
            }
          } else {
            set_message("danger", "You are not Active");
          }
        }
      }
      $this->load->view("auth/login", ['title' => "Portal | Login"]);
    } catch (\Throwable $th) {
      redirect(base_url('login'), 'refresh');
    }
  }

  public function session_logout()
  {
    $this->session->sess_destroy();
    redirect(base_url("login"));
  }

  public function get()
  {
    try {
      $u = $this->http->auth("get", ["ADMIN", "SUPPORT", "STUDENT", "TEACHER"]);
      if ($u->type == "SUPPORT" || $u->type == "ADMIN") {
        if ($this->input->get("self") == "true") {
          $id = $u->id;
        } else {
          $id = $this->input->get("id");
        }
      } else {
        $id = $u->id;
      }
      if ($user = $this->user_model->get($id)) {
        unset($user->password);
        return $this->http->response->create(200, "user fetched", $user);
      } else {
        return $this->http->response->create(203, "User data not available");
      }
    } catch (\Throwable $th) {
      //throw $th;
      return $this->http->response->serverError($th->getMessage());
    }
  }

  public function get_all()
  {
    try {

      $this->http->auth(["get"], "ADMIN");
      $limit = is_numeric($this->input->get("limit")) ? $this->input->get("limit") : null;
      $offset = is_numeric($this->input->get("offset")) ? $this->input->get("offset") : null;
      $user_type_id = is_numeric($this->input->get("user_type_id")) ? $this->input->get("user_type_id") : "";
      $user_id = is_numeric($this->input->get("user_id")) ? $this->input->get("user_id") : "";

      if ($data = $this->user_model->get_all(null, $user_type_id, $user_id, $limit, $offset)) {
        return $this->http->response->create(200, "Users fetched successfully", $data);
      } else {
        return $this->http->response->create(203, "Users not found");
      }
    } catch (\Throwable $th) {
      //throw $th;
      return $this->http->response->serverError();
    }
  }

  public function delete($id)
  {
    try {
      $this->http->auth(["get", "post"], "ADMIN");
      if ($d = $this->user_model->delete($id)) {
        set_message("success", "User delete successfully");
      } else {
        set_message("danger", "User delete failed");
      }
      redirect(base_url('user'), 'refresh');
    } catch (\Throwable $th) {
      redirect(base_url('user'), 'refresh');
    }
  }

  public function user_type_get_all()
  {
    try {
      $data = $this->user_type_model->get_all(1);
      return $this->http->response->create(200, "Data fetched successfully", $data);
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }

  public function user_pronoun_get_all()
  {
    try {
      $data = $this->user_pronoun_model->get_all(1);
      return $this->http->response->create(200, "Data fetched successfully", $data);
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }
  public function forgot_password()
  {
    try {

      $p = $this->http->request->all();

      if ((isset($p['email'])) && (isset($_POST))) {
        if ($user = $this->user_model->get_by_email($p['email'])) {
          $id = $user->id;
          if ($user->email == isset($p['email'])) {
            $otp = rand(1000, 9999);
            $tdata = [
              'otp' => $otp,
            ];
            if ($this->user_model->update($user->id, $tdata)) {
              //Email sent to user/Student
              $URL = forgot_url; //'https://svp.websofttechs.com/portal/update_password/';
              $message = "<p>This email has been sent as a request to reset our password</p>";
              $message .= "Please click on the password reset link 
                <br><a href='" . $URL . $id . '/' . $otp . "'>Reset 
                Password</a>";
              $data = [
                "fullname" => $user->full_name,
                "reset_link" => $message,

              ];
              $this->mailer->mail_template($user->email, 'forgot-password', $data);
              //Email sent to user/Student
              if ($user = $this->user_model->get_by_token($otp)) {
                unset($user->password);
                $id = $user->id;
                // $link = "'" . base_url() . 'api/user/update_password/'.$id.'/' . $otp . "'";

                // $data = [
                //   "link" => $link,
                //   "id" => $id
                // ];
                echo '<div class="alert alert-danger">Email sent successfull</div>';
                // $this->http->response->create(200, "Email sent successfully");
              } else {
                echo '<div class="alert alert-danger">User data not available</div>';
              }
            }
          }
        } else {
          echo '<div class="alert alert-danger">User email Enter</div>';
        }

        $this->load->view("auth/forgot_password", ['title' => "Portal | Login"]);
      } else {

        $this->load->view("auth/forgot_password", ['title' => "Portal | Login"]);
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }

  public function update_password()
  {
    try {

      $p = $this->http->request->all();

      $user = $this->user_model->get_by_token($p['token']);
      if (isset($user->id)) {
        if (($user->otp == $p["token"]) && ($user->id == $p["user_id"])) {

          if (isset($p["password"]) && !empty($p["password"])) {
            $pwd_rule = "|required";
            $cpwd_rule = "|required|matches[password]";
          }
          $this->form_validation->set_rules(
            [

              [
                'field' => 'password',
                'label' => 'Password',
                'rules' => "trim{$pwd_rule}",
              ],
              [
                'field' => 'cpassword',
                'label' => 'Confirm Password',
                'rules' => "trim{$cpwd_rule}",
              ]
            ]
          );

          if ($this->form_validation->run() == TRUE) {

            if ($user = $this->user_model->get_by_token($p['token'])) {
              if (!is_null($user->id)) {
                $data["password"] = password_hash($p["password"], PASSWORD_BCRYPT);
                $data["otp"] = '';
                $d = $this->user_model->update($user->id, $data);
                return $this->http->response->create(200, "Update Password Successfully");
              }
            }
          } else {
            $form_errors = $this->form_validation->error_array();
            return $this->http->response->create(203, "Form validation error", $form_errors);
          }
        } else {
          return $this->http->response->create(203, "User id and token not match");
        }
      } else {
        return $this->http->response->create(203, "User id and token not match");
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }
}


/* End of file User.php */
/* Location: ./application/controllers/User.php */
