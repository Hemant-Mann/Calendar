<?php
  function redirect_to( $location = NULL ) {
    if ($location != NULL) {
      header("Location: {$location}");
      exit;
    }
  }

  function output_message($message="") {
    if (!empty($message)) { 
      return "<p class=\"message\">{$message}</p>";
    } else {
      return "";
    }
  }

  function __autoload($class_name) {
  	$class_name = strtolower($class_name);
    $path = MODEL."class.{$class_name}.php";
    if(file_exists($path)) {
      require_once($path);
    } else {
  		die("The file {$class_name}.php could not be found.");
  	}
  }

  function render($file) {
    include(VIEW.$file);
  }

  function include_layout_template($template = "", $data = array()) {
    extract($data);
    include(VIEW.'layouts'.DS.$template.'.php');
  }

  function datetime_to_text($datetime="") {
    $unixdatetime = strtotime($datetime);
    return strftime("%B %d, %Y at %I: %M %p", $unixdatetime);
  }

  function password_check($password, $existing_hash) {
    //existing hash contains format and salt or start
    $hash = crypt($password, $existing_hash);
    if($hash == $existing_hash) {
      return true;
    } else {
      return false;
    }
  }

?>