<?php include_layout_template('header', ["pageTitle" => "Login", "type" => "admin"]); ?>
<div id="content">
	<?php global $username, $password, $message;
	echo output_message($message); ?>
	<form action="<?php echo HOME; ?>login" method="post">
	  <fieldset>
	  	<legend>Login</legend>
	  	<label for="username">Username</label>
	    <input autofocus type="text" name="username" required maxlength="60" placeholder="Username" value="<?php echo htmlentities($username); ?>" />
	    <label for="password">Password</label>
	    <input type="password" name="password" required maxlength="60" placeholder="Password" value="" /></p>

	   <input class="btn btn-info" type="submit" name="submit" value="Login" />
	   </fieldset>
	</form><br />
  New User? <a href="<?php echo HOME; ?>register">Sign Up</a><br /><br />
</div>
<?php include_layout_template('footer'); ?>