<?php
session_start();
include("../../config/database.php");

header("Content-Type: application/json");

$response = [];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
  $username = isset($_POST['username']) ? trim($_POST['username']) : '';
  $role = isset($_POST['role']) ? trim($_POST['role']) : '';

  if (empty($id) || empty($username) || empty($role)) {
    $response["success"] = false;
    $response["message"] = "ID, Username dan Role harus diisi!";
  } else {
    if (!in_array($role, ["user", "admin"])) {
      $response["message"] = "Role tidak valid!";
    } else {
      $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
      $stmt->bind_param("si", $username, $id);
      $stmt->execute();
      $stmt->store_result();

      if ($stmt->num_rows > 0) {
        $response["message"] = "Username sudah digunakan!";
      } else {

        $stmt = $conn->prepare('UPDATE users SET username = ?, role = ? WHERE id = ?');
        $stmt->bind_param('ssi', $username, $role, $id);

        if ($stmt->execute()) {
          $response["success"] = true;
          $response["message"] = "Data berhasil diperbarui!";
        } else {
          $response["message"] = "Gagal memperbarui data.";
        }

        $stmt->close();
      }
    }
  }
} else {
  $response["success"] = false;
  $response["message"] = "Metode tidak diizinkan!";
}
echo json_encode($response);
exit;
?>