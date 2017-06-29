<?php
session_start();
$_SESSION['auth'] = array();
session_destroy();
header('Location: index.php');
?>