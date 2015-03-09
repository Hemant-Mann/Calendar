<?php require_once $libpath = substr(str_replace('\\', '/', __dir__), 0, -22).'library/initialize.php'; ?>
<?php if (!$session->is_logged_in()) { redirect_to(HOME."login"); } ?>
<?php
 if(isset($_GET['month']) && isset($_GET['year'])) {
 	$month = preg_replace('/[^0-9]/', '', $_GET['month']);
 	$year = preg_replace('/[^0-9]/', '', $_GET['year']);

 	global $database;
 	$month = $database->escape_value($month);
 	$year = $database->escape_value($year);
 	$cal = new Calendar("{$year}-{$month}-02 00:00:00");
 }
 else {
	$cal = new Calendar();  	
 }
 
 echo $cal->buildCalendar();
?>
<p><a href="<?php echo HOME; ?>configure-event" id="newEvent" class="admin">+ New Event</a>
<a href="<?php echo HOME; ?>logout" class="admin">Logout</a></p>