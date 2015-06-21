<?php
// load constants
require_once('parameters.php');

// load config file first
require_once(CONFIG.'config.php');

// load basic functions next so that everything after can use them
require_once(SCRIPTS.'functions.php');

// load core objects
require_once(MODEL.'class.session.php');
require_once(MODEL.'class.database.php');
require_once(MODEL.'class.database_object.php');

// load database-related classes
require_once(MODEL.'class.calendar.php');
require_once(MODEL.'class.events.php');
require_once(MODEL.'class.user.php');
?>
