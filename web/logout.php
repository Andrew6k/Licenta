<?php
include("server.php");

session_destroy();
unset($_SESSION['username']);
header('location: login.php');

?>