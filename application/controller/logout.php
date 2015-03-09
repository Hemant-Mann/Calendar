<?php require_once $libpath = substr(str_replace('\\', '/', __dir__), 0, -22).'library/initialize.php'; ?>
<?php	
    $session->logout();
    redirect_to(HOME."login");
?>
