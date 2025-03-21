<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['user_id'])) {
  $_SESSION["err_message"] = "Anda harus login terlebih dahulu!";
  header("Location: ../pages/login.php");
  exit;
}
?>