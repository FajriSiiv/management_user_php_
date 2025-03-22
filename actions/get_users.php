<?php
include("../config/database.php");

header("Content-Type: application/json");

$sql = "SELECT * FROM users WHERE role='user'";
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

echo json_encode($users);
exit;
?>