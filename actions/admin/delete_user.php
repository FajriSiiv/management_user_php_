<?php include("../../config/database.php");

if (isset($_POST["id"]) && $_SERVER['REQUEST_METHOD'] === "POST") {
  // sanitize id
  $id = intval($_POST["id"]);

  $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();

  header('Location: ' . BASE_URL . '/pages/admin/dashboard.php');
  exit;
}

?>