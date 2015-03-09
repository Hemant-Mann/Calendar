<?php include_layout_template('header', ["pageTitle" => "Event", "type" => "admin"]); ?>
<?php $cal = new Calendar(); ?>
<div id="content">
	<div id="eventInfo">
		<?php 
			global $id;
			$isEvent = $cal->displayEvent($id);
			echo $isEvent ? $cal->displayEvent($id) : "<center>No event for the given id</center><br />"; 
		 ?>
		 <?php if($isEvent) { ?>

		<center>
			<a href="<?php echo HOME; ?>configure-event?id=<?php echo $id; ?>" id="editEvent" class="admin">Edit</a>
			<a href="<?php echo HOME; ?>delete-event?id=<?php echo $id; ?>" id="deleteEvent" class="admin">Delete</a>
		</center>
		<?php } ?>
	</div>
<br />
<a href="<?php echo HOME; ?>">&laquo; Back to the calendar</a>
</div><!-- end #content -->
<?php include_layout_template('footer'); ?>