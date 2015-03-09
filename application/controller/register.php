<?php require_once $libpath = substr(str_replace('\\', '/', __dir__), 0, -22).'library/initialize.php'; ?>
<?php
if($session->is_logged_in()) {
  redirect_to(HOME);
}
	global $session;
	if(isset($_POST['submit'])) {
		if(($_POST['token'] == $session->get_token())) {
			global $database;
			$name = $_POST["name"];
			$email = $_POST["email"];
			$username = $_POST["username"];
			$password = $database->escape_value($_POST["password"]);
			
			$user = new User;
			
			$user->name = $name;
			$user->email = $email;
			$user->username = $username;
			$hash = $user->password_encrypt($password);
			$user->password = $hash;

			if($_POST["confirmation"] !== $_POST["password"]) {
				$user->errors[] = "Passwords don't match";
			}

			if($user->save()) {
				$message = "You are successfully registered!";
				redirect_to(HOME."login");
			} else {
				$message = "Invalid Submission! Please register again";
			}
		} else {
			$message = join("<br />", $user->errors);
		}	
	} else {
		$email = "";
		$name = "";
		$username = "";
		$password = "";
	}

	render('register.php');
?>
