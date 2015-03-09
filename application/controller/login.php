<?php require_once $libpath = substr(str_replace('\\', '/', __dir__), 0, -22).'library/initialize.php'; ?>
<?php 
if($session->is_logged_in()) {
  redirect_to(HOME);
}

if (isset($_POST['submit'])) { 
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  
  // Check database to see if username/password exist.
	$found_user = User::authenticate($username, $password);
	
  if ($found_user) {
    $session->login($found_user);
    redirect_to(HOME);
  } else {
    // username/password combo was not found in the database
    $message = "Username/password combination incorrect.";
  }
  
} else { 
  // Form has not been submitted.
  $username = "";
  $password = "";
  $message = "";
}
render('login.php');
?>