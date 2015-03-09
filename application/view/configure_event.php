<?php global $title, $start, $end, $desc, $message, $session, $monthYr;
		if(isset($_GET['id'])) {
			global $oldEvent;
			$url = "configure-event?id=".$_GET['id'];
			$pageTitle = "Update Event";
		} else {
			$url = "configure-event";
			$pageTitle = "New Event";
			} ?>
<?php if(empty($monthYr)) { $monthYr = [ 'month' => "", "year" => ""]; } ?>
<?php include_layout_template('header', ["pageTitle" => $pageTitle, "type" => "admin"]); ?>
<div id="message">
	<?php if($message==="Event was saved") {
			$complete = "<script type=\"text/javascript\">";
			$complete .= "alert('Your Event was saved!');";
			$complete .= "</script>";
			echo $complete;
		} else {
			echo output_message($message); 
		} ?>
</div>
<div id="content">
<form id="form" action="<?php echo HOME.$url; ?>" method="post">
	<fieldset>
		<legend><?php echo $pageTitle; ?></legend>
		<label for="event_title">Event Title</label>
		<input type="text" name="title" required id="event_title" value="<?php echo $title; ?>" />
		
		<label for="event_start">Start Time</label>(Year-Month-Day 24-Hr:Min:sec)
		<input type="text" name="start" required id="event_start" value="<?php echo $start; ?>" />
		
		<label for="event_end">End Time</label>
		<input type="text" name="end" required id="event_end" value="<?php echo $end; ?>" />
		
		<label for="event_description">Event Description</label>
		<textarea name="desc" id="event_description"><?php echo $desc; ?></textarea>
		<?php if(isset($oldEvent)) { ?>	
		<input type="hidden" name="event_id" value="<?php echo $oldEvent->event_id; ?>" />
		<?php } ?>
		<input type="hidden" name="token" value="<?php echo $session->set_token(); ?>" />
		<input type="hidden" id="info" data-month="<?php echo $monthYr["month"]; ?>" data-year="<?php echo $monthYr["year"]; ?>" value="">
		<input type="submit" name="submit" value="<?php echo $pageTitle; ?>" />
		OR <a href="<?php echo HOME; ?>" id="cancel">Cancel</a>
	</fieldset>
</form>
</div>
<?php include_layout_template('footer'); ?>