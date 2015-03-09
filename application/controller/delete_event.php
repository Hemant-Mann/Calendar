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

	$eventDate = "";
	$find_event = Event::find_by_field("event_id", $id);
	if($find_event) {
		$event = array_shift($find_event);
		$eventDate = $event->event_start;
		if($event->delete()) {
			$message = "The event was deleted";
			redirect_to(HOME);
		}
	} else {
		$message = "The event could not be removed.";
		redirect_to(HOME);
		
	}
	render('delete_event.php');
?>
