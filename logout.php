<?php
session_start();
session_destroy();
$_SESSION = array();
header("Location: http://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . "/login.php");
