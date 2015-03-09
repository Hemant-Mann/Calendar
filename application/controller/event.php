<?php require_once $libpath = substr(str_replace('\\', '/', __dir__), 0, -22).'library/initialize.php'; ?>
<?php if (!$session->is_logged_in()) { redirect_to(HOME."login"); }
	if(isset($_GET['id'])) {
		$id = preg_replace('/[^0-9]/', '', $_GET['id']);
		
		if(empty($id)) {
		redirect_to(HOME);
		}
	} else {
		redirect_to(HOME);
	}

	render("event.php");
?>