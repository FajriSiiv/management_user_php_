<?php
session_start();
include("../layout/navbar.php");


if (!isset($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_SESSION['user_id'])) {
  header("Location: ../pages/dashboard.php");
  exit;
}


?>


<form class="w-50 mx-auto pt-5" method="POST" action="../actions/login_action.php">
  <h2 class="text-2xl fw-bold mb-5">Login</h2>
  <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>" />

  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" name="username" class="form-control" id="username" />
    <!-- <div class="form-text">We'll never share your username with anyone else.</div> -->
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="password" />
  </div>
  <div class="text-end">
    <?php if (isset($_SESSION['err_message'])): ?>
      <div class="text-center">
        <p class="text-danger text-md"><?php echo $_SESSION['err_message'];
        unset($_SESSION['err_message']); ?></p>
      </div>
    <?php endif; ?>
    <button type="submit" class="btn btn-primary">Login</button>
  </div>


</form>


<?php include("../layout/footer.php") ?>