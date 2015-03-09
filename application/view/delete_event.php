<?php global $message, $eventDate; ?>
<?php $cal = new Calendar("{$eventDate}"); $monthYr = $cal->getMonthYr(); ?>
<?php include_layout_template('header', ["pageTitle" => "Delete Event"]); ?>
<div id="message">
	<?php if($message==="The event was deleted") {
			$complete = "<script type=\"text/javascript\">";
			$complete .= "alert('Your Event was deleted!');";
			$complete .= "</script>";
			echo $complete;
		} else {
			echo output_message($message); 
		} ?>
<form>
<input type="hidden" id="info" data-month="<?php echo $monthYr["month"]; ?>" data-year="<?php echo $monthYr["year"]; ?>">
</form>
<?php include_layout_template('footer'); ?>