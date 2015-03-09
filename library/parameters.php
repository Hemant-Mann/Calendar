<?php

// Define Directory Separator
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

// Site Root
defined('SITE_ROOT') ? null : 
	define('SITE_ROOT', DS.'wamp'.DS.'www'.DS.'calendar');

define('APPLICATION', SITE_ROOT.DS.'application');
define('MODEL', APPLICATION.DS.'model');
define('VIEW', APPLICATION.DS.'view');

define('CONFIG', SITE_ROOT.DS.'config');
define('SCRIPTS', SITE_ROOT.DS.'scripts');

/**
 * For URL rewriting
 * The root directory of domain i.e. 'localhost' is '/'
 * Project is in the folder 'calendar'
 * So root of project is /calendar/
*/
define('HOME', '/'.'calendar/');
define('ASSETS', '/calendar/assets/');
define('STYLESHEETS', ASSETS.'css/');
define('JAVASCRIPTS', ASSETS.'js/');

?>