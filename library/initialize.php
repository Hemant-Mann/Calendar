<?php
// load constants
require_once('parameters.php');

// load config file first
require_once(CONFIG.DS.'config.php');

// load basic functions next so that everything after can use them
require_once(SCRIPTS.DS.'functions.php');

// load core objects
require_once(MODEL.DS.'class.session.php');
require_once(MODEL.DS.'class.database.php');
require_once(MODEL.DS.'class.database_object.php');

// load database-related classes
require_once(MODEL.DS.'class.calendar.php');
require_once(MODEL.DS.'class.events.php');
require_once(MODEL.DS.'class.user.php');
?>
