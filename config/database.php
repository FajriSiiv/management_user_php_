<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

define("DB_USER", "fajri");
define("DB_PASS", "fajri");
define("DB_HOST", "localhost");
define("DB_NAME", "user_management_panel");
define("BASE_URL", "/project-php/admin-panel-user-management");


$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
  die("Disconnected!" . mysqli_connect_error());
}

?>