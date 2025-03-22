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
    header("Location:" . BASE_URL . "/pages/login.php");
    exit;
  }

  $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
  if (!$stmt) {
    die("Prepare failed: " . $conn->error);
  }

  $stmt->bind_param('s', $username);
  $stmt->execute();
  $stmt->store_result();


  if ($stmt->num_rows > 0) {
    $stmt->bind_result($user_id, $hashed_password, $role);
    $stmt->fetch();

    if (!empty($user_id) && !empty($hashed_password)) {
      if (password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        setcookie('username', $username, time() + 3600, '/');
        setcookie('user_id', $user_id, time() + 3600, '/');
        setcookie('role', $role, time() + 3600, '/');

        $_SESSION['success_message'] = "Login berhasil, selamat datang!";


        $stmt->close();
        $conn->close();

        if ($role === 'user') {
          header("Location:" . BASE_URL . "/pages/user/dashboard.php");
        } elseif ($role === "user") {
          header("Location:" . BASE_URL . "/pages/admin/dashboard.php");
        } else {
          header("Location:" . BASE_URL . "/pages/login.php");
          $_SESSION["err_message"] = "Kamu tidak memiliki role";
        }


        exit;
      } else {
        $_SESSION["err_message"] = "Password salah!";
        header("Location:" . BASE_URL . "/pages/login.php");
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

  header("Location:" . BASE_URL . "/pages/login.php");
  exit;

}

?>