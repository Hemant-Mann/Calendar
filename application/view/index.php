<?php include_layout_template('header', ["pageTitle" => "Events Calendar", "type" => "admin"]); ?>
<?php global $message, $cal; ?>
<?php $monthYr = $cal->getMonthYr(); ?>
<div id="messages">
</div>
	<div id="goTo">
		<form id="changeDate" action="<?php echo HOME; ?>home" method="get">
		<fieldset>
			<p>Month: 
			<select name="month" id="month">
				<?php for($i=1; $i<13; $i++) { ?>
				<option value="<?php echo $i; ?>" <?php if($i==1) { echo "selected"; } ?>><?php echo $i; ?></option>
				<?php } ?>
			</select>
			Year: <input type="text" autofocus required id="year" name="year" style="display: inline; width: 10%;" />
			<input type="hidden" id="info" data-month="<?php echo $monthYr["month"]; ?>" data-year="<?php echo $monthYr["year"]; ?>">
			<input type="submit" name="submit" value="Go" /></p>
		</fieldset>
		</form>
	</div>
<div id="content">
	<div id="links">
		<?php echo $cal->buildNavigation(); ?>
	</div>
	<div id="calendar">
	<?php echo output_message($message); ?>
	<?php echo $cal->buildCalendar();	?>
	<p><a href="<?php echo HOME; ?>configure-event" id="newEvent" class="admin">+ New Event</a>
	<a href="<?php echo HOME; ?>logout" class="admin">Logout</a></p>
	</div>
</div>
<?php include_layout_template('footer'); ?>