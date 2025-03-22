<?php
include("../config/database.php");
session_start();


session_unset();
session_destroy();


header("Location:" . BASE_URL . "/pages/login.php");
exit;
?>