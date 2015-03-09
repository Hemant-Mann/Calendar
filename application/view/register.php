<?php include_layout_template('header', ["pageTitle" => "Register", "type" => "admin"]); ?>
<div id="message">
	<?php global $name, $email, $username, $password, $message, $session;
	if($message==="You are successfully registered!") {
		$complete = "<script type=\"text/javascript\">";
		$complete .= "alert('You are registered! Please login to continue!');";
		$complete .= "</script>";
		echo $complete;
	}
	else {
		echo output_message($message);
		}	
	?>
</div>
<div id="content">
	<form id="registerForm" action="<?php echo HOME; ?>register" method="post">
		<fieldset>
			<legend>New User</legend>
			<label for="name">Name (Full Name)</label>
				<input autofocus id="name" type="text" required maxlength="80" name="name" value="<?php echo htmlentities($name); ?>" />
			
			<label for="email">Email</label>
				<input id="email" type="email" maxlength="200" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="email" value="<?php echo htmlentities($email); ?>" />
			
			<label for="username">Username</label>
				<input id="username" type="text" maxlength="60" required name="username" value="<?php echo htmlentities($username); ?>" />
				(Please select any Username of your choice)
			
			<label for="password">Password</label> (Minimum length = 8 characters)
				<input id="password" type="password" required pattern=".{8,}" name="password" value="<?php echo htmlentities($password); ?>" />
			
			<label for="confirmation">Re-Type Password</label>
				<input id="confirmation" type="password" maxlength="30" required name="confirmation" value="" />
			
			<input type="hidden" name="token" value="<?php echo $session->set_token(); ?>" />
			<input type="submit" id="submit" name="submit" value="Sign Up" />
		</fieldset>
	</form>

	<br />
  Old User? <a href="<?php echo HOME; ?>login" class="admin">Login</a>
</div><!-- End Page Content -->
<?php include_layout_template('footer'); ?>
