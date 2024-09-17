<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Libraries MY_Form_validation
 *
 * This Libraries for ...
 * 
 * @package		CodeIgniter
 * @category	Libraries
 * @author    Monirul Middya
 * @param     ...
 * @return    ...
 *
 */

class MY_Form_validation extends CI_Form_validation
{

  // ------------------------------------------------------------------------

  /**
   * @var object CI_Controller
   */
  public $ci;

  public function __construct()
  {
    parent::__construct();
    $this->ci = &get_instance();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------

  /**
   * Is Unique
   *
   * Check if the input value doesn't already exist
   * in the specified database field.
   *
   * @param	string	$str
   * @param	string	$field
   * @return	bool
   * Ex . rules : is_unique_custom[table_name.column.{$except_value}.except_column]
   */
  public function is_unique_custom($str, $field)
  {
    sscanf($field, '%[^.].%[^.].%[^.].%[^.]', $table, $field, $unique_value, $unique_column);

    $where = array($field => $str);
    if (!empty($unique_value) && !empty($unique_column)) {
      $where = array_merge($where, ["{$unique_column} !=" => $unique_value]);
    }
    return ($this->ci->db->limit(1)->get_where($table, $where)->num_rows() === 0);
  }

  
  /**
   * Is Unique
   *
   * Check if the input value doesn't already exist
   * in the specified database field.
   *
   * @param	string	$str
   * @param	string	$field
   * @return	bool
   * Ex . rules : is_unique_custom_multi[table_name.column.{$except_value}.except_column]
   */
  public function is_unique_custom_multi($str, $field)
  {
    sscanf($field, '%[^.].%[^.].%[^.].%[^.]', $table, $field, $except_column, $except_value);
    
    $where = array("{$field} !=" => $str);
    if (!empty($except_value) && !empty($except_column)) {
      $except_value_arr = explode("::",$except_value);
      $except_column_arr = explode("::",$except_column);
     
      foreach($except_column_arr as $key=>$each_column) {
        $where = array_merge($where, ["{$each_column} =" => $except_value_arr[$key]]);
       
      }
    }
   
    $chk = $this->ci->db->limit(1)->get_where($table, $where)->num_rows();

    return ($chk === 0);
  }

  /**
   * Is Exist Record
   *
   * Check if the input value exist or not
   * in the specified database field.
   *
   * @param	string	$str
   * @param	string	$field
   * @return	bool
   * Ex . rules : is_exist[table_name.column]
   */
  public function is_exist($str, $field)
  {
    sscanf($field, '%[^.].%[^.]', $table, $field);
    $where = array($field => $str);
    return ($this->ci->db->limit(1)->get_where($table, $where)->num_rows() > 0);
  }
  /**
   * 
   * Check if the input value valid or not
   *
   * @param	string	$date
   * @return	bool
   * Ex . rules : valid_date[mm/dd/yyyy]
   */
  function valid_date($date)
  {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    if (($d && $d->format('Y-m-d') === $date) === FALSE) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

  // public function valid_datetime($datetime)
  // {
  //   $dt = DateTime::createFromFormat('Y-m-d\TH:i:s', $datetime);
  //   pp($dt);
  //   if ($dt && $dt->format('Y-m-d\TH:i:s') === $datetime) {
  //     return true;
  //   } else {

  //     return false;
  //   }
  //}

  
  /**
   * Is Exist Record
   *
   * Check if the input value exist or not
   * in the specified database field.
   * 
   * @param	string	$str
   * @param	string	$field
   * @return	bool
   * Ex . rules : is_exist_where_in[table_name.column]
   */
  public function is_exist_where_in($str, $field)
  {
    try {
      $pts = explode(".", $field);
      $table = $pts[0];
      unset($pts[0]);
      $column = $pts[1];
      unset($pts[1]);
      $whr_in_column = $pts[2];
      unset($pts[2]);
      $where = array($column => $str);
     
      return ($this->ci->db->limit(1)->where($where)->where_in($whr_in_column, $pts)->get($table)->num_rows() > 0);
    } catch (\Throwable $th) {
      //throw $th;
      return false;
    }
  }

  /**
   * Field require when another field value exist
   *
   * @param	string	$str
   * @param	string	$field
   * @return	bool
   * Ex . rules : required_when_equal[another_field_name]
   */

  public function required_when_equal($str, $field)
  {
    try {
      sscanf($field, '%[^.].%[^.]', $post_name, $value);
      if ($_POST[$post_name] && ($_POST[$post_name] == $value)) {
        return $str != "" ? true : false;
      } else {
        return true;
      }
    } catch (\Throwable | Exception | ParseError $e) {
      return false;
    }
  }

  /**
   * Field array value required
   *
   * @param	string	$str
   * @param	string	$field
   * @return	bool
   * Ex . rules : required_array[field_name[]]
   */

  public function required_array($str, $field)
  {
    try {
      sscanf($field, '%[^.].%[^.]', $post_name, $value);
      $post = $this->input->post($post_name);
      if (is_array($post)) {
        return array_reduce($post, function ($s, $v) {
          if ($s === false) {
            return false;
          } else {
            return $v != "" ? true : false;
          }
        }, null);
      } else {
        return false;
      }
    } catch (\Throwable | Exception | ParseError $e) {
      return false;
    }
  }

  // ------------------------------------------------------------------------
}

/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */