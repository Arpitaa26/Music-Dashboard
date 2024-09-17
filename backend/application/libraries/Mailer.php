<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * Libraries Mailer
 *
 * This Libraries for ...
 * 
 * @package		CodeIgniter
 * @category	Libraries
 * @author    Bapan Roy
 * @param     ...
 * @return    ...
 *
 */
class Mailer 
{
   
    private $ci = null;
    
	function __construct()
	{
		$this->ci = &get_instance();
		$this->ci->load->model(["user_model", "setting_model","user_type_model", "user_pronoun_model"]);
	
        
	}
  
	//=============================================================
    // Eamil Templates
    function mail_template($to = '',$slug = '',$mail_data = '')
    {
        $template =$this->ci->db->get_where('tbl_email_templates',array('slug' => $slug))->row_array();
        //$template =  $this->setting_model->get_email_template_content_by_slug($slug);
       
        $body = $template['body'];

        $template_id = $template['id'];

        $data['head'] = $subject = $template['subject'];

        $data['content'] = $this->mail_template_variables($body,$slug,$mail_data);

        $data['title'] = $template['name'];

        $template =  $this->ci->load->view("general_settings/email_templates/email_preview",$data,true);
       //pp($template);
        $this->sendEmail($to,$subject,$template,null,null);

        return true;
    }

    //=============================================================
    // GET Eamil Templates AND REPLACE VARIABLES
    function mail_template_variables($content,$slug,$data = '')
    {

        switch ($slug) {
            case 'login-alert':
                $content = str_replace('{FULLNAME}',$data['fullname'],$content);
                $content = str_replace('{TIMESTAMP}',date('F j, Y H:i:s'),$content);
                return $content;
            break;

            case 'email-verification':
                $content = str_replace('{FULLNAME}',$data['fullname'],$content);
                $content = str_replace('{VERIFICATION_LINK}',$data['fullname'],$content);
                return $content;
            break;

            case 'welcome':
                $content = str_replace('{FULLNAME}',$data['fullname'],$content);
                return $content;
            break;

            case 'forgot-password':
                $content = str_replace('{FULLNAME}',$data['fullname'],$content);
                $content = str_replace('{RESET_LINK}',$data['reset_link'],$content);
                return $content;
            break;

            case 'applicant-task':
                $content = str_replace('{TASK_TITLE}',$data['job_title'],$content);
                return $content;
            break;
            
            case 'reschedule-class':
                $content = str_replace('{FULLNAME}', $data['fullname'], $content);
                return $content;
            break;
            case 'schedule-class':
                $content = str_replace('{FULLNAME}', $data['fullname'], $content);
                return $content;
            break;
            case 'general-notification':
                $content = str_replace('{FULLNAME}', $data['fullname'], $content);
                return $content;
            break;

            case 'candidate-exam':
                $content = str_replace('{TASK_TITLE}',$data['job_title'],$content);
                return $content;
            break;
            
            default:
                # code...
                break;
        }
    }
    
   function sendEmail($to = '', $subject  = '', $body = '', $attachment = '', $cc = '')
    {
   
        $from_email = "achintadey.websofttechs@gmail.com";
        $to_email =$to ;
          //Load email library
          $this->ci->load->library('email');
          $this->ci->email->from($from_email, $subject);
          $this->ci->email->to($to_email);//$to 
          $this->ci->email->subject($subject);//$subject
          
          $this->ci->email->message($body );//$body
          //Send mail
            $this->ci->email->send();
          
         
        }


	

}
?>