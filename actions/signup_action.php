<?php
session_start();
include("../config/database.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $username = trim($_POST["username"]);
  $password = trim($_POST["password"]);

  if (empty($username) || empty($password)) {
    $_SESSION["err_message"] = "Username dan Password tidak boleh kosong";
    header('Location: ../pages/signup.php');
    exit;
  }


  $stmt = $conn->prepare('SELECT id FROM users WHERE username = ?');
  $stmt->bind_param('s', $username);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $_SESSION['err_message'] = "Username sudah digunakan, silakan pilih yang lain!";
    header("Location: ../pages/signup.php");
    exit;
  }

  $stmt->close();
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
  $stmt->bind_param("ss", $username, $hashed_password);

  if ($stmt->execute()) {
    header('Location: ../pages/signup.php');
  } else {
    $_SESSION["err_message"] = "Terjadi kesalahan, coba lagi!";
    header('Location: ../pages/signup.php');
  }

  $stmt->close();
  $conn->close();
  exit;

}


?>