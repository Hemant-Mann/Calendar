<?php require_once $libpath = substr(str_replace('\\', '/', __dir__), 0, -22).'library/initialize.php'; ?>
<?php if (!$session->is_logged_in()) { redirect_to(HOME."login"); }
	// Event is updated or a new event is added
	if(isset($_POST['submit']) || isset($_GET['id'])) {
		// Form is not submitted user just came to the page
		if(isset($_GET['id'])) {
			$id = preg_replace('/[^0-9]/', '', $_GET['id']);
			
			// find event for the given id
			$findEvent = Event::find_by_field("event_id", $id, ["limit" => 1]);
			if($findEvent) {
				$oldEvent = array_shift($findEvent);
				
				// fetch the details from the event object returned from db
				$title = $oldEvent->event_title;
				$start = $oldEvent->event_start;
				$end = $oldEvent->event_end;
				$desc = $oldEvent->event_desc;
			} else {
				redirect_to(HOME);
			}
	  	}

	  	// when form is submitted
		if(isset($_POST['submit'])) {
			if(($_POST['token'] == $session->get_token())) {
				if(isset($_POST['event_id'])) {
					$id = $_POST['event_id'];
				}
				
				$title = $_POST['title'];
				$start = $_POST['start'];
				$end = $_POST['end'];
				$desc = $_POST['desc'];

				$event = new Event();
				if(!empty($id)) {
					$event->event_id = $id;
				}
				$event->user_id = $_SESSION['user_id']; 
				$event->event_title = $title;
				$event->event_start = $start;
				$event->event_end = $end;
				$event->event_desc = $desc;

				$cal = ""; $monthYr = "";
				if($event->save()) {
					$cal = new Calendar("{$event->event_start}");
					$monthYr = $cal->getMonthYr();
					$message = "Event was saved";
				} else {
					$cal = new Calendar();
					$monthYr = $cal->getMonthYr();
					$message = join("<br />", $event->errors);
				}
			} else {
				$message = "Invalid Request!";
			}	
		}

	  // A new event page is requested	  
	} else {
		$title = "";
		$start = "";
		$end = "";
		$desc = "";
		$message = "";
		$monthYr = "";
	}
	render('configure_event.php');
?>