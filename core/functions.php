<?php

function ip(){
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $ip){
                $ip = trim($ip); // just to be safe

                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                    return $ip;
                }
            }
        }
    }
}


function ip_long(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip=$_SERVER['HTTP_CLIENT_IP'];

    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else{
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    $ip = sprintf("%u", ip2long($ip));
    
    return $ip;
}


function auto_version($file)
{
  if(strpos($file, '/') !== 0 || !file_exists($_SERVER['DOCUMENT_ROOT'] . $file))
    return $file;

  $mtime = filemtime($_SERVER['DOCUMENT_ROOT'] . $file);
  return preg_replace('{\\.([^./]+)$}', ".$mtime.\$1", $file);
}


function g($param, $default = null) {
    global $_GET, $_POST, $_COOKIE;

    //if (isset($_COOKIE[$param])) return $_COOKIE[$param];
    if (isset($_POST[$param])) return $_POST[$param];
    if (isset($_GET[$param])) return $_GET[$param];
    return $default;
}

function gt($param) {
    $val = g($param);
    if ($val === false) return false;
    return trim($val);
}


function get_value(&$var, $default = null)
{
    return (isset($var)) ? $var : $default;
}


function get_string($array, $index, $default = null)
{
    if (isset($array[$index]) && strlen($value = trim($array[$index])) > 0) {
        return $value;
    } else {
        return $default;
    }
}


function get_integer($array, $index, $default = 0)
    //if it exists and is something like 2 or "2", return it as integer by casting
    // if not exists , return 0 instead of null
{
    if (isset($array[$index]) && is_integer_input($array[$index])) {
        return (int)$array[$index];
    } else {
        return $default;
    }
}


function get_array($array, $index, $default = null)
{
    if (isset($array[$index]) && is_array($array[$index])) {
        return $array[$index];
    } else {
        return $default;
    }
}


function utf8entities($s) {
    return htmlentities($s,ENT_COMPAT,'UTF-8');
}


function load_view($view, $data = array())
{
    extract($data);
    require_once PA_VIEW_DIR . $view . '.php';
}


function load_template($template, $data = array())
{
    extract($data);
    require PA_TEMPLATE_DIR . $template . '.php';

    if ($template == 'footer')
        exit;
}


function load_lib($lib)
{
    require_once PA_LIB_DIR . $lib . '.php';

    $obj = new $lib;

    return $obj;
}


function load_model($model)
{
    require_once PA_MODEL_DIR . $model . '.php';

    $obj = new $model;

    return $obj;
}
