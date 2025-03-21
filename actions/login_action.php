<?php
session_start();
include("../config/database.php");






if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Akses tidak sah! CSRF token tidak valid.");
  }

  $username = trim($_POST["username"]);
  $password = trim($_POST["password"]);


  if (empty($username) || empty($password)) {
    $_SESSION["err_message"] = "Username dan Password tidak boleh kosong";
    header('Location: ../pages/login.php');
    exit;
  }

  $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
  if (!$stmt) {
    die("Prepare failed: " . $conn->error);
  }

  $stmt->bind_param('s', $username);
  $stmt->execute();
  $stmt->store_result();


  if ($stmt->num_rows > 0) {
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();

    if (!empty($user_id) && !empty($hashed_password)) {
      if (password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['success_message'] = "Login berhasil, selamat datang!";

        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        setcookie('username', $username, time() + 3600, '/');
        setcookie('user_id', $user_id, time() + 3600, '/');

        $stmt->close();
        $conn->close();

        header('Location: ../pages/dashboard.php');
        exit;
      } else {
        $_SESSION["err_message"] = "Password salah!";
        header('Location: ../pages/login.php');
        exit;
      }
    } else {
      $_SESSION["err_message"] = "Data user tidak ditemukan!";

    }

  } else {
    $_SESSION["err_message"] = "Username tidak ditemukan!";
  }

  $stmt->close();
  $conn->close();

  header('Location: ../pages/login.php');
  exit;

}

?>