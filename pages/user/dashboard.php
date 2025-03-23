<?php
session_start();
include("../../layout/navbar.php");
include('../../actions/verify_id.php');

$user_id = $_SESSION['user_id'];

$sql = "SELECT username FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

?>

<div class="mt-4">
  <h2>Dashbord User <?php echo $_SESSION['success_message'] ?></h2>

  <form action="../../actions/user/update_user.php" class="w-50 mt-5 mx-auto border p-5" method="POST">
    <h2>Edit User</h2>
    <div class="mb-3">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" class="form-control"
        value="<?= htmlspecialchars($user['username']) ?>">
      <div class="form-text">Masukan username baru-mu yang ingin kamu ganti.</div>

    </div>
    <div class="mb-3">
      <label for="password">Password</label>
      <input type="text" name="password" id="password" class="form-control">
      <div class="form-text">Masukan passwordmu.</div>
    </div>

    <div class="text-danger form-text mb-3">
      <?php echo isset($_SESSION['err_message']) ? $_SESSION['err_message'] : ''; ?>
    </div>
    <button type="submit" class="btn btn-primary">Change</button>

  </form>

</div>




<?php
include("../../layout/footer.php");
?>