<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"	>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
  	<title><?php echo $pageTitle; ?></title>
  	<link rel="stylesheet" href="<?php echo STYLESHEETS; ?>main.css">
  	<link rel="stylesheet" href="<?php echo STYLESHEETS; ?>ajax.css">
  	<?php if(isset($type) && $type === "admin") { ?>
  	<link rel="stylesheet" href="<?php echo STYLESHEETS.$type; ?>.css">
  	<?php } ?>
</head>
<body>
<div id="wraper">