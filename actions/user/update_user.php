<?php
session_start();
include("../../config/database.php");



$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $new_username = trim($_POST['username']);
  $password = trim($_POST['password']);

  if (empty($new_username) || empty($password)) {
    $_SESSION["err_message"] = "Username dan password tidak boleh kosong!";
    header("Location: " . BASE_URL . "/pages/user/dashboard.php");
    exit();
  }

  $sql = "SELECT password FROM users WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if (!$user || !password_verify($password, $user['password'])) {
    $_SESSION["err_message"] = "Password salah!";
    header("Location: " . BASE_URL . "/pages/user/dashboard.php");
    exit();
  }

  // Update username di database
  $sql_update = "UPDATE users SET username = ? WHERE id = ?";
  $stmt = $conn->prepare($sql_update);
  $stmt->bind_param("si", $new_username, $user_id);

  if ($stmt->execute()) {
    $_SESSION['username'] = $new_username;
    $_SESSION['success_message'] = "Username berhasil diperbarui!";
    header("Location: " . BASE_URL . "/pages/user/dashboard.php");
    exit();
  } else {
    $_SESSION["err_message"] = "Gagal update username!";
    header("Location: " . BASE_URL . "/pages/user/dashboard.php");
    exit();
  }
}
?>