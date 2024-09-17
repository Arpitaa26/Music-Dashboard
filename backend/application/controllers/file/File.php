<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Controller File
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller Rest
 * @author    Monirul Middya
 * @param     ...
 * @return    ...
 *
 */

class File extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(["file_model"]);
  }

  //display data
  private function file_view($id = null)
  {
    $files = $this->file_model->get_all(1);
    if ($file = $this->file_model->get($id)) {
      view("file/create", compact("file", "files"), "Portal | file Edit");
    } else {
      view("file/create", compact("files"), "Portal | file Create");
    }
  }

  //display table
  public function index()
  {
    try {
      $category = ($this->input->get("category")) ? $this->input->get("category") : "";
     $u= $this->http->auth(["get"], "ADMIN");
     $user_id=$u->id;
      view("file/index", compact("category","user_id"), "Portal | file");
    } catch (\Throwable $th) {
      //throw $th;
      redirect(base_url('file'), 'refresh');
    }
  }

  //save and update file
  public function file_save($id = null)
  {
    set_message("info", "Not avaiable for now");
    redirect(base_url('file'), 'refresh');
    try {
      $this->http->auth(["get", "post"], "ADMIN");
      if (is_post()) {
        $this->form_validation->set_rules(
          [
            [
              'field' => 'category',
              'label' => 'Category',
              'rules' => 'trim|required|in_list[TUTORIAL,PROFILE_PIC,HOMEWORK,COURSE_MATERIAL,COURSE_HOMEWORK,AUDIO_ARCHIVE]',
              'errors' => array(
                'in_list' => '%s select one of TUTORIAL/PROFILE_PIC/HOMEWORK',
              )
            ],

          ]
        );

        if ($this->form_validation->run() == true) {
          $p = $this->http->request->all();
          $exploded = explode('.', $_FILES['file_name']['name']);
          $file_ext = strtolower(end($exploded));
    
          if (!is_null($id)) {
            $filename = $p['file_edit'];
          } else {
            $image_name = md5(uniqid(rand(), true));
            $filename = $image_name . '.' . $file_ext;
          }

          $base_path = FCPATH . DOCUMENT_FOLDER . '/' . $p['category'] . '/';
          $path = $p['category'] . '/';
          // pp($filename);
          if (!file_exists($base_path)) mkdir($base_path, 0755, true);

          if ($_FILES["file_name"]['size'] != 0) {

            $config = array(
              "allowed_types" => ['pdf', 'doc', 'txt', 'png', 'jpg', 'jpeg','gif', 'zip','MP4','MOV','WMV','AVI','MKV','webp'],
              "upload_path" => $base_path,
              "overwrite" => true,
              "file_name" => $filename,

              'max_size' => '200000'
            );
            //pp(  $config);
            //$this->upload->initialize($config);
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file_name')) {
              $dataInfo = array('upload_data' => $this->upload->data());
              $min_type = $dataInfo['file_type'];
              set_message("success", $dataInfo);
            } else {
              $error = array('error' => $this->upload->display_errors());
              // pp($error);
              set_message("danger", "File no changes found/failed");
            }
          }
          //slug
          $number = uniqid();
          $varray = str_split($number);
          $len = sizeof($varray);
          $otp = array_slice($varray, $len - 5, $len);
          $otp = implode(",", $otp);
          $otp = str_replace(',', '', $otp);
          //slug
          $slug = $p['category'] . '_' . $otp;
          $data = [
            "slug" => $slug,
            "file_name" => $filename,
            "category" => $p['category'],
            "mime_type" =>  $min_type,
            "path" =>  $path . $filename,
            "status" => $p['status'],
          ];

          if (!is_null($id)) {
            if ($this->file_model->update($id, $data)) {
              set_message("success", "File updated successfully");
            } else {
              set_message("danger", "File no changes found/failed");
            }
          } else {
            if ($this->file_model->insert($data)) {
              set_message("success", "File created successfully");
            } else {
              set_message("danger", "File creation failed");
            }
          }
          redirect(base_url('file'), 'refresh');
        } else {
          $this->file_view($id);
        }
      } else {
        $this->file_view($id);
      }
    } catch (\Throwable $th) {
      redirect(base_url('file'), 'refresh');
    }
  }

  public function single_save()
  {
    try {
      //$d=$this->http->session_get("first_name");
      //pp($d);
      $u=$this->http->auth(["post","get"], ["ADMIN", "STUDENT", "TEACHER", "SUPPORT"]);
      
      $p = $this->http->request->all();
      $category = $this->http->request->get("category");
      $description = $this->http->request->get("description");
      $this->form_validation->set_rules(
        [
          [
            'field' => 'category',
            'label' => 'Category',
            'rules' => 'trim|required|in_list[TUTORIAL,PROFILE_PIC,HOMEWORK,COURSE_MATERIAL,COURSE_HOMEWORK,AUDIO_ARCHIVE]',
            'errors' => array(
            'in_list' => '%s select one of TUTORIAL/PROFILE_PIC/HOMEWORK/COURSE_MATERIAL/COURSE_HOMEWORK/AUDIO_ARCHIVE',
            )
          ]
        ]
      );
     
      if ($this->form_validation->run() == true) {

        $upload_path =  DOCUMENT_FOLDER . "/{$category}/";
        if (!file_exists(FCPATH . $upload_path)) {
          mkdir(FCPATH . $upload_path, 0777, true);
        }

        $config = [
          'upload_path' => FCPATH . $upload_path,
          'encrypt_name' => true,
        ];
       
        switch ($category) {
          case 'PROFILE_PIC':
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = '5000';
            break;
          case 'HOMEWORK':
            $config['allowed_types'] = 'jpg|jpeg|png|gif|txt|pdf';
            $config['max_size'] = '5000';
            break;
          case 'COURSE_HOMEWORK':
            $config['allowed_types'] = 'jpg|jpeg|png|gif|txt|pdf';
            $config['max_size'] = '5000';
            break;
          case 'COURSE_MATERIAL':
            $config['allowed_types'] = 'jpg|jpeg|png|gif|txt|pdf';
            $config['max_size'] = '5000';
            break;
          case 'TUTORIAL':
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|mp3|MP4|MOV|WMV|AVI|MKV|webp';
            $config['max_size'] = '50000';
            break;
          case 'AUDIO_ARCHIVE':
            $config['allowed_types'] = 'mp3|MP4|MOV|WMV|AVI|MKV';
            $config['max_size'] = '50000';
            break;
          default:
            return $this->http->response->create(203, "Can't upload file now for given category");
            break;
        }

        $this->load->library('upload', $config);
       
        if ($this->upload->do_upload('file')) {
          $d = $this->upload->data();
          
          $data = [
            "file_name" => $d["file_name"],
            "category" => $category,
            "description" => $description,
            "mime_type" => $d["file_type"],
            "path" => $upload_path . $d["file_name"],
            "original_name"=>$d["orig_name"],
            "status" => '1'
          ];
          
          if ($fid = $this->file_model->insert($data)) {
            $link = $this->file_model->file_url . $this->file_model->slug;
            return $this->http->response->create(200, "File uploded successfully", [
              "id" => $fid,
              "link" => $link,
            ]);
          } else {
            return $this->http->response->create(203, "File uploading failed");
          }
        } else {
          $error = array('error' => strip_tags($this->upload->display_errors()));
          return $this->http->response->create(203, "File validation error", $error);
        }
      } else {
        return $this->http->response->create(203, "Form validation error", $this->form_validation->error_array());
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }

  public function open($slug)
  {
    if ($f = $this->file_model->get_filter(null, $slug)) {
      ($f->status == "1") or die("file is inactive");
      $fpath = FCPATH . $f->path;
      $file = fopen($fpath, "r") or die("Unable to open file!");
      header("Content-Type: {$f->mime_type}");
      header('Content-Length: ' . filesize($fpath));
      echo file_get_contents($fpath);
      fclose($file);
    }
  }

  function viewfile($slug)
  {

    if ($token = $this->input->get('api-key')) {
      $d = $this->http->get_token($token);
    } else {
      $u = $this->http->auth(["post", "get"], ["ADMIN", "STUDENT", "TEACHER", "SUPPORT"]);
    }
    if ($f = $this->file_model->get_filter(null, $slug)) {
      $fname = $f->file_name;
      $fpath = FCPATH . $f->path;
      $tofile = realpath($fpath);
      header('Content-Type: application/pdf');
      readfile($tofile);
    }
  }
  function download($slug)
  {
    if ($token = $this->input->get('api-key')) {
      $d = $this->http->get_token($token);
    } else {
      $u = $this->http->auth(["post", "get"], ["ADMIN", "STUDENT", "TEACHER", "SUPPORT"]);
    }
     if ($f = $this->file_model->get_filter(null, $slug)) {
      $fpath = FCPATH . $f->path;
      $this->load->helper('download');
      $data = file_get_contents($fpath);
      $name = 'RESUME.pdf'; // custom file name for your download

      force_download($f->file_name, $data);
     }
      //force_download($file_name, NULL); will get the file name for you
}
  //delete file
  public function delete($id)
  {
    try {
      $this->http->auth(["get"], "ADMIN");
      if ($d = $this->file_model->delete($id)) {
        set_message("success", "File delete successfully");
      } else {
        set_message("danger", "File delete failed");
      }
      redirect(base_url('file'), 'refresh');
    } catch (\Throwable $th) {
      redirect(base_url('file'), 'refresh');
    }
  }

  public function get($id = null)
  {
      try {
          $this->http->auth(["get"], ["ADMIN", "SUPPORT", "STUDENT"]);
          if ($d = $this->file_model->get($id)) {
              return $this->http->response->create(200, "File fetched successfully", $d);
          } else {
              return $this->http->response->create(203, "File  not found");
          }
      } catch (\Throwable $th) {
          return $this->http->response->serverError();
      }
  }
  //get data
  public function get_all()
  {
  
    try {
      $u = $this->http->auth("get", ["ADMIN", "SUPPORT", "STUDENT", "TEACHER"]);
      if ($u->type == "STUDENT" || $u->type == "TEACHER") {
          if ($this->input->get("self") == "true") {
           
            $user_id = $u->id;
          } else {
              
              $user_id = $u->id;
          }
      } else {
        $user_id =null;
        
      }
      
      //pp($user_id);
      $category = ($this->input->get("category")) ? $this->input->get("category") : "";
      if ($d = $this->file_model->get_all(null,$user_id,$category)) {
        return $this->http->response->create(200, "File fetched successfully", $d);
      } else {
        return $this->http->response->create(203, "File not found");
      }
    } catch (\Throwable $th) {
      return $this->http->response->serverError();
    }
  }
}
