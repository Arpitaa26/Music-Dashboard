<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Helpers Services_helper
 *
 * This Helpers for ...
 * 
 * @package   CodeIgniter
 * @category  Helpers
 * @author    Monirul Middya
 *
 */

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// ------------------------------------------------------------------------

if (!function_exists('pp')) {
  /**
   * pp - data print with exit
   *  @param any $data -- required
   *  @return mixed
   */
  function pp($data = null)
  {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    exit;
  }
}

if (!function_exists('age_cal')) {
  /**
   * Age calculator
   *  @param string $dob - date of birth
   *  @param string|null $to_date - to date Default current date
   *  @return int
   */
  function age_cal($dob, $to_date = null)
  {
    $today = date("Y-m-d");
    if (strtotime($dob)) {

      if ($to_date != null) {
        $today = strtotime($to_date) ? $to_date : $today;
      }

      $diff = date_diff(date_create($dob), date_create($today));
      return $diff->format('%y');
    }
    return 0;
  }
}

if (!function_exists('array_custom_search')) {
  /**
   * @param string|int|bool $key required -- which key want to find
   * @param string|int|bool $value required -- which property get according to key value match
   * @param string $to_email required
   * @param array $array required -- array of arrays ($object = false) / array of objects ($object = true)
   * @param bool  $object optional -- according to 3rd param value ex : array of arrays ($object = false) / array of objects ($object = true)
   * @return bool
   */

  function array_custom_search($key, $value, $array, $object = false)
  {
    foreach ($array as $d) {
      if ($object == true) {
        if (isset($d->$key) && $d->$key == $value) {
          return $d;
        }
      } else {
        if (isset($d[$key]) && $d[$key] == $value) {
          return $d;
        }
      }
    }
    return false;
  }
}

if (!function_exists('array_find')) {
  /**
   * @author Monirul Middya
   * @since last updated: 32-12-2022
   * arrays or objects data find
   * 
   * @param array|object $data list of data
   * @param calllback_function $callback_fun callback function
   * @return array|object|bool
   */

  function array_find($data, $callback)
  {
    try {
      $_find_d = array_values(array_filter($data, $callback));
      return isset($_find_d[0]) ? $_find_d[0] : false;
    } catch (\Throwable | Exception $th) {
      return false;
    }
  }
}

if (!function_exists('clear_str')) {
  /**
   * Remove special characters with white space (optional)
   * 
   * @param string $string 
   * @param bool $space_remove white space removise or not. Default false
   * @return string
   */
  function clear_str($string, $space_remove = false)
  {
    if ($space_remove == true) {
      $string = str_replace(' ', '', $string); // remove white space
    }

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
  }
}

if (!function_exists('token_encode')) {
  /**
   *  @param string|array $data 
   *  @return string  encrypted text
   */
  function token_encode($data)
  {
    $ci = &get_instance();
    if ($token = $ci->encryption->encrypt(json_encode($data))) {
      return $token;
    } else return false;
  }
}

if (!function_exists('token_decode')) {
  /**
   *  @param string $token encrypted text
   *  @param bool $array default false (object) -- return formate object/array
   *  @return object|array|bool Expected formate/false
   */
  function token_decode($token, $array = false)
  {
    $ci = &get_instance();
    if ($resp = $ci->encryption->decrypt($token)) {
      if ($array == true) {
        return json_decode($resp, true);
      } else return json_decode($resp);
    } else return false;
  }
}

if (!function_exists('jwt_encode')) {
  /**
   *  @param array|object $data
   *  @return string
   */
  function jwt_encode($data)
  {
    try {
      $time = time(); // current timestamp value
      $nbf = $time;
      $exp = $time + 3600;
      $payload = array(
        "iss" => "localhost",
        "aud" => "localhost",
        "iat" => $time, // issued at
        "nbf" => $nbf, //not before in seconds
        "exp" => $exp, // expire time in seconds
        "data" => $data
      );
      return JWT::encode($payload, JWT_KEY, 'HS256');
    } catch (\Throwable $th) {
      return false;
    }
  }
}

if (!function_exists('jwt_decode')) {
  /**
   *  @param string $token
   *  @return mixed
   */
  function jwt_decode($token)
  {
    try {
      return JWT::decode($token, new Key(JWT_KEY, 'HS256'));
    } catch (\Throwable $th) {
      return false;
    }
  }
}

if (!function_exists('auth')) {
  /**
   *  @param string $token
   *  @return mixed
   */
  function auth($token)
  {
    try {
      $ci = &get_instance();
      return JWT::decode($token, new Key(JWT_KEY, 'HS256'));
    } catch (\Throwable $th) {
      return false;
    }
  }
}

if (!function_exists('GetBase64Contents')) {
  /**
   *  @param string $file_path 
   *  @return base64_encode
   */
  function GetBase64Contents($file_path)
  {
    // returns base64 encoded file data

    if (file_exists($file_path)) {
      $fp = fopen($file_path, "r");
      $file_content = fread($fp, filesize($file_path));
      fclose($fp);

      return base64_encode($file_content);
    }
  }
}

if (!function_exists('is_post')) {

  /**
   * If the method of request is POST return true else false.
   * 
   *  @return bool  */
  function is_post()
  {
    return (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST')  ? true : false;
  }
}

if (!function_exists('is_get')) {

  /**
   * If the method of request is GET return true else false.
   * 
   *  @return bool  */
  function is_get()
  {
    return (strtoupper($_SERVER['REQUEST_METHOD']) === 'GET')  ? true : false;
  }
}

if (!function_exists('is_method')) {

  /**
   * method of request check
   * 
   *  @return bool  */
  function is_method($method = "GET", $return = false)
  {
    if ($method == "POST") {
      return is_post();
    } elseif ($method == "GET") {
      return is_get();
    }
    $request = strtoupper($_SERVER['REQUEST_METHOD']);

    if ($request === strtoupper($method)) {
      if ($return) {
        return true;
      }
    } else {
      $request_uri = $_SERVER['REQUEST_URI'];
      echo resp_message(false, 203, "{$request} request not allowed for given uri '{$request_uri}'");
      exit;
    }
  }
}

if (!function_exists('input_print')) {

  /**
   * To print database inside a input field use this.
   * It will escape values such as ', " or other entities.
   * 
   *  @return mixed  */
  function input_print($str)
  {

    return htmlentities($str);
  }
}

if (!function_exists('set_custom_header')) {
  /**
   * It will setup custom header
   * 
   * @param mixed $custom_header to set css or any other thing to the header
   * @return void It will set value only nothing will be return.
   */
  function set_custom_header($file)
  {
    $str = '';
    $ci = &get_instance();
    $custom_header  = $ci->config->item('custom_header');

    if (empty($file)) {
      return;
    }

    if (is_array($file)) {
      if (!is_array($file) && count($file) <= 0) {
        return;
      }
      foreach ($file as $item) {
        $custom_header[] = $item;
      }
      $ci->config->set_item('custom_header', $custom_header);
    } else {
      $str = $file;
      $custom_header[] = $str;
      $ci->config->set_item('custom_header', $custom_header);
    }
  }
}

if (!function_exists('get_custom_header')) {
  /**
   * It will get customer header if set up.
   * 
   *  @return void|string  */
  function get_custom_header()
  {
    $str = '';
    $ci = &get_instance();
    $custom_header  = $ci->config->item('custom_header');


    if (!is_array($custom_header)) {
      return;
    }

    foreach ($custom_header as $item) {
      $str .= $item . " ";
    }

    return $str;
  }
}

if (!function_exists('set_custom_footer')) {
  /**
   * It will setup custom footer
   * 
   * @param mixed $custom_footer to set js or any other thing to the footer
   * @return void It will set value only nothing will be return.
   */
  function set_custom_footer($file)
  {
    $str = '';
    $ci = &get_instance();
    $custom_footer  = $ci->config->item('custom_footer');

    if (empty($file)) {
      return;
    }

    if (is_array($file)) {
      if (!is_array($file) && count($file) <= 0) {
        return;
      }
      foreach ($file as $item) {
        $custom_footer[] = $item;
      }
      $ci->config->set_item('custom_footer', $custom_footer);
    } else {
      $str = $file;
      $custom_footer[] = $str;
      $ci->config->set_item('custom_footer', $custom_footer);
    }
  }
}

if (!function_exists('get_custom_footer')) {
  /**
   * It will get customer footer if set up.
   * 
   *  @return void|string  */
  function get_custom_footer()
  {
    $str = '';
    $ci = &get_instance();
    $custom_footer  = $ci->config->item('custom_footer');

    if (!is_array($custom_footer)) {
      return;
    }

    foreach ($custom_footer as $item) {
      $str .= $item . "";
    }

    return $str;
  }
}

if (!function_exists('cUrlRequest')) {
  /**
   * @param string $url
   * @param string $method default "GET"
   * @param array $headers
   * @param array $body
   * 
   * @return mixed
   * 
   */
  function cUrlRequest($url, $method = "GET", $headers = [], $body = [])
  {
    $ch = curl_init();

    $url = $method == "GET" && $body ? sprintf("%s?%s", $url, http_build_query($body))  : $url;
    $additional = $method != "GET" ? [CURLOPT_POSTFIELDS => json_encode($body)] : [];

    curl_setopt_array($ch, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 120,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_FOLLOWLOCATION => 0,
      CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => $method,
      CURLOPT_HTTPHEADER =>  $headers
    ) + $additional);

    $response = curl_exec($ch);
    $err = curl_error($ch);

    curl_close($ch);

    if ($err) {
      return $response;
    } else {
      return $response;
    }
  }
}

if (!function_exists('view')) {
  /**
   *  @param string $token
   *  @return mixed
   */
  function view($body_view_path = null, $bdata = [], $title = "Portal")
  {
    try {
      $ci = &get_instance();
      $ci->load->view("layout/header", ['title' => $title,'Logo' =>Logo ,'HF_title' => HF_title]);
      if (!is_null($body_view_path)) {
        $ci->load->view($body_view_path, $bdata);
      }
      $ci->load->view("layout/footer", ['Version' =>Version ,'HF_title' => HF_title]);
    } catch (\Throwable $th) {
      return false;
    }
  }
}

// form error modify
if (!function_exists('set_form_error')) {
  /**
   * form error show
   * Note: return string when error found else not
   * 
   * @author Monirul Middya
   * @since last updated: 16-01-2023
   * 
   * @param string $field field name
   * @param bool $error_bs_element if true error element html return else ' is-invalid ' string return
   * 
   * @return void
   */
  function set_form_error($field = "", $error_bs_element = true)
  {
    if ($error = form_error($field)) {
      if ($error_bs_element) {
        return "<div class='invalid-feedback'>
              {$error}
              </div>";
      } else {
        return " is-invalid ";
      }
    } else return "";
  }
}

if (!function_exists('set_message')) {
  /**
   * set message for ci flashdata
   * 
   * @author Monirul Middya
   * 
   * @param string $type bs alet class end part like :- (success,danger,info,warning)
   * @param string $message if you want
   * 
   * @return void
   */
  function set_message($type = "info", $message = "")
  {
    $ci = &get_instance();
    $ci->session->set_flashdata('type', $type);
    $ci->session->set_flashdata('message', $message);
  }
}

if (!function_exists('get_message')) {
  /**
   * bs alert message of ci flashdata
   * 
   * @author Monirul Middya
   * 
   * @return string
   */
  function get_message()
  {
    $ci = &get_instance();
    $type = $ci->session->flashdata('type');
    $message = $ci->session->flashdata('message');
    if ($type && $message) {
      return "<div class='alert alert-{$type}' role='alert'>{$message}</div>";
    } else return "";
  }
}

if (!function_exists('auto_deduct_userid')) {
  /**
   * get user id of current session or system user 
   * 
   * @author Monirul Middya
   * 
   * @return string
   */
  function auto_deduct_userid()
  {
    $ci = &get_instance();
    // pp($_SESSION);
    if ($suid = $ci->http->session_get("id")) {
      return $suid;
    } else {
      $ci->load->model("user_model");
      if ($u = $ci->user_model->get_by_username("system")) {
        return $u->id;
      } else return 0;
    }
  }
}

// ------------------------------------------------------------------------

/* End of file Services_helper.php */
/* Location: ./application/helpers/Services_helper.php */